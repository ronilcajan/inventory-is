<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Products;
use App\Models\StockOut;
use App\Models\SaleItems;
use App\Models\Settings;
use Illuminate\Http\Request;

class POSController extends Controller
{
    //view permission
    public function show(){

        $products = Products::select('*','products.id as id')
                                ->join('stock_out', 'products.id', '=', 'stock_out.products_id')
                                ->where('stock_out_qty','>', 0)
                                ->get();
        $system = Settings::get()->first();
                                
        return view('pos.pos',[
            'title' => 'POS',
            'products' => $products,
            'system' => $system
        ]);
    }

    public function search(Request $request){
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $data = Products::select('*','products.id as id')
                                ->join('stock_out', 'products.id', '=', 'stock_out.products_id')
                                ->where('stock_out_qty','>', 0)
                                ->where('barcode','LIKE',"%$search%")
                                ->orWhere('name','LIKE',"%$search%")
                                ->get();
        }
        if(!$request->has('search')){
            $data = Products::select('*','products.id as id')
                                ->join('stock_out', 'products.id', '=', 'stock_out.products_id')
                                ->where('stock_out_qty','>', 0)
                                ->get();
        }
        return response()->json($data);
    }

    public function sold(Request $request){

        $data = array(
            'success' => false,
            'msg' => "Something went wrong!"
        );
        $reference = substr(str_shuffle("0123456789"), 0, 7);
        
        $sale = array(
            'reference' => $reference,
            'cash' => $request->paymentcash,
            'total_qty' => $request->total_quantity,
            'total_amount' => $request->grandtotal,
            'discount' => $request->discount,
            'user_id' => auth()->user()->id,
        );
        
        $create_sale = Sales::create($sale);

        if($create_sale){
            $items = [];
            
            for($i = 0;  $i < count($request->barcode); $i++){
                $items[] = array(
                    'sale_qty' => $request->quantity[$i],
                    'sale_price' => $request->price[$i],
                    'sale_product' => $request->barcode[$i],
                    'sales_id' => $create_sale->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                );

                $products = Products::join('stock_out', 'products.id', '=', 'stock_out.products_id')
                                    ->where('barcode', $request->barcode[$i])->first();

                $new_qty = array(
                    'stock_out_qty' => $products->stock_out_qty - $request->quantity[$i],
                );

                StockOut::where('products_id', $products->id)->update($new_qty);
			}

            SaleItems::insert($items);

            $data = array(
                'success' => true,
                'receipt_id' => $create_sale->id,
                'msg' => "Items has been sold!"
            );
        }
        
        return response()->json($data);
    }

    public function receipt($receipt){
        $sales = Sales::join('users','sales.user_id','=','users.id')->where('sales.id', $receipt)->first();
        
        $sold_items = SaleItems::join('products', 'sale_items.sale_product', '=', 'products.barcode')
                        ->where('sales_id', $receipt)->get();
                                
        return view('pos.receipt',[
            'title' => 'POS',
            'sales' => $sales,
            'sold_items' => $sold_items
        ]);
    }
}