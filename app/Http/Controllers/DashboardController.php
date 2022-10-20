<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\SaleItems;
use Carbon\Carbon;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    public function index(){

        $total_sales = Sales::whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $product = Products::count('id');
        $stock_in = Products::join('stock_in', 'stock_in.products_id', '=', 'products.id')->sum('stock_in.stock_in_qty');
        $stock_out = Products::join('stock_out', 'stock_out.products_id', '=', 'products.id')->sum('stock_out.stock_out_qty');
        $product_sold = SaleItems::select('*','sale_items.created_at as created_at')
                                    ->join('products', 'products.barcode', '=', 'sale_items.sale_product')
                                    ->orderBy('sale_items.created_at', 'DESC')->get();
        return view('/dashboard',[
            'title' => 'Dashboard',
            'total_sales' => $total_sales,
            'product_sold' => $product_sold,
            'product' => $product,
            'stock_in' => $stock_in,
            'stock_out' => $stock_out,
        ]);
    }

    public function sales(){

       

        $jan = Sales::whereMonth('created_at', '01')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $feb = Sales::whereMonth('created_at', '02')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $mar = Sales::whereMonth('created_at', '03')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $apr = Sales::whereMonth('created_at', '04')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $may = Sales::whereMonth('created_at', '05')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $jun = Sales::whereMonth('created_at', '06')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $jul = Sales::whereMonth('created_at', '07')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $aug = Sales::whereMonth('created_at', '08')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $sep = Sales::whereMonth('created_at', '09')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $oct = Sales::whereMonth('created_at', '10')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $nov = Sales::whereMonth('created_at', '11')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $dec = Sales::whereMonth('created_at', '12')->whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
    
        $data = array(
            'jan' => $jan,
            'feb' => $feb,
            'mar' => $mar,
            'apr' => $apr,
            'may' => $may,
            'jun' => $jun,
            'jul' => $jul,
            'aug' => $aug,
            'sep' => $sep,
            'oct' => $oct,
            'nov' => $nov,
            'dec' => $dec,
        );
        
        return response()->json($data);
    }
}