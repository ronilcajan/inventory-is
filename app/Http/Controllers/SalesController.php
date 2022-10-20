<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\StockIn;
use App\Models\SaleItems;
use App\Models\StockOut;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function show(){
        $sales = Sales::select('*','sales.id as id')
                    ->join('users','sales.user_id','=','users.id')
                    ->orderBy('sales.created_at','DESC')
                    ->filter(request(['search']))->paginate(10);
        return view('sales.manage',[
            'title' => 'Manage Sales',
            'sales' => $sales
        ]);
    }

    public function view($receipt){
        $sales = Sales::where('sales.id', $receipt)->first();
        
        $sold_items = SaleItems::select('*','sale_items.id as id')->join('products', 'sale_items.sale_product', '=', 'products.barcode')
                        ->where('sales_id', $receipt)->paginate(10);
                                
        return view('sales.view',[
            'title' => 'Receipt No.: '.$receipt,
            'sales' => $sales,
            'sold_items' => $sold_items
        ]);
    }

    public function destroy_sales(Sales $receipt){

        $receipt->delete();
        return back()->with('success','Sales has been deleted successfully!');
    }

    public function destroy(SaleItems $item){

        $check = StockOut::join('products', 'stock_out.products_id', '=', 'products.id')->where('products.barcode', $item->sale_product )->first(); //check if exist
           
        if($check){
            $stockout = array(
                'stock_out_qty' => $check->stock_out_qty + $item->sale_qty,
            );
            StockOut::where('products_id', $check->products_id)->update($stockout);
        }
        $item->delete();
        return back()->with('success','Sold item has been removed successfully!');
    }
}