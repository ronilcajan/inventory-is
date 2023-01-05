<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Sales;
use App\Models\StockIn;
use App\Models\Products;
use App\Models\SaleItems;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $total_sales = Sales::whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $today_sales = Sales::whereDate('created_at', Carbon::today())->sum('total_amount');
        $product = Products::count('id');
        $user = User::with('roles')->count('id');
        $order_closed = Order::where('status','=','closed')->get();
        $order_pending = Order::where('status','=','pending')->get();
        $stock_in = StockIn::where('stock_in_qty', '!=', 0)->get();
        $latest_product = SaleItems::select('*','sale_items.created_at as created_at')
                                    ->join('products', 'products.barcode', '=', 'sale_items.sale_product')
                                    ->orderBy('sale_items.created_at', 'DESC')->get();

        $most_product = SaleItems::select('*','sale_items.created_at as created_at', DB::raw('COUNT(sale_items.sale_qty) as count_qty'))
                                    ->join('products', 'products.barcode', '=', 'sale_items.sale_product')
                                    ->groupBy('sale_items.sale_product')
                                    ->orderBy('count_qty', 'DESC')->get();

        return view('/dashboard',[
            'title' => 'Dashboard',
            'total_sales' => $total_sales,
            'product_sold' => $latest_product,
            'most_product' => $most_product,
            'store' => $stock_in,
            'product' => $product,
            'today_sales' => $today_sales,
            'user' => $user,
            'order_closed' => $order_closed,
            'order_pending' => $order_pending,
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

        $last_jan = Sales::whereMonth('created_at', '01')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_feb = Sales::whereMonth('created_at', '02')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_mar = Sales::whereMonth('created_at', '03')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_apr = Sales::whereMonth('created_at', '04')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_may = Sales::whereMonth('created_at', '05')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_jun = Sales::whereMonth('created_at', '06')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_jul = Sales::whereMonth('created_at', '07')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_aug = Sales::whereMonth('created_at', '08')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_sep = Sales::whereMonth('created_at', '09')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_oct = Sales::whereMonth('created_at', '10')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_nov = Sales::whereMonth('created_at', '11')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
        $last_dec = Sales::whereMonth('created_at', '12')->whereYear('created_at', Carbon::now()->format('Y')-1)->sum('total_amount');
    
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
            'last_jan' => $last_jan,
            'last_feb' => $last_feb,
            'last_mar' => $last_mar,
            'last_apr' => $last_apr,
            'last_may' => $last_may,
            'last_jun' => $last_jun,
            'last_jul' => $last_jul,
            'last_aug' => $last_aug,
            'last_oct' => $last_oct,
            'last_nov' => $last_nov,
            'last_dec' => $last_dec,
        );
        
        return response()->json($data);
    }

    public function delivery(){

        $delivered = Order::where('status','=','closed')->get();
        $pending = Order::where('status','=','pending')->get();
    
        $data = array(
            'delivered' => count($delivered),
            'pending' => count($pending),
        );
        
        return response()->json($data);
    }
}