<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\StockIn;
use App\Models\Products;
use App\Models\Settings;
use App\Models\StockOut;
use App\Models\SaleItems;
use App\Models\StockCard;
use Illuminate\Http\Request;

class POSController extends Controller
{
    //view permission
    public function show(){

        $products = Products::select('*','products.id as id')
                            ->leftjoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                            ->leftjoin('stock_in', 'products.id', '=', 'stock_in.products_id')
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
                                ->leftjoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                                ->leftjoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                                ->where('barcode','LIKE',"%$search%")
                                ->orWhere('name','LIKE',"%$search%")
                                ->get();
        }
        if(!$request->has('search')){
            $data = Products::select('*','products.id as id')
                                ->leftjoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                                ->leftjoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                                ->where('stock_out_qty','>', 0)
                                ->orWhere('stock_in_qty','>', 0)
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

                $store = Products::join('stock_out', 'products.id', '=', 'stock_out.products_id')
                                    ->where('barcode', $request->barcode[$i])->first();
                
                $warehouse = Products::join('stock_in', 'products.id', '=', 'stock_in.products_id')
                                    ->where('barcode', $request->barcode[$i])->first();

                $stock_out_new_qty = $store->stock_out_qty - $request->quantity[$i];

                $new_qty = array(
                    'stock_out_qty' => $stock_out_new_qty,
                );
                
                // if($stock_out_new_qty > 0){
                //     $new_qty = array(
                //         'stock_out_qty' => $stock_out_new_qty,
                //     );
                    
                // }else{

                //     $new_qty = array(
                //         'stock_out_qty' => 0,
                //     );

                //     $stock_in_new_qty = $warehouse->stock_in_qty - abs($stock_out_new_qty);

                //     $new_warehouse_qty = array(
                //         'stock_in_qty' => $stock_in_new_qty,
                //     );

                   

                //     $get_stock_card = StockCard::leftJoin('products','stock_card.products_id', '=', 'products.id')
                //     ->where('products.products_id',$warehouse->products_id)->latest();

                //     StockIn::where('products_id', $warehouse->products_id)->update($new_warehouse_qty);

                //     $stock_card = array(    
                //         'status' => 'Sold',
                //         'quantity' => abs($stock_out_new_qty) ,
                //         'unit' => $warehouse->unit,
                //         'price' => $warehouse->price,
                //         'reference' => '',
                //         'supplier' => '',
                //         'balance' =>  $get_stock_card - $stock_out_new_qty,
                //         'products_id' => $warehouse->products_id,
                //     );
                
                //     StockCard::create($stock_card);
                    
                // }

                StockOut::where('products_id', $store->id)->update($new_qty);
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