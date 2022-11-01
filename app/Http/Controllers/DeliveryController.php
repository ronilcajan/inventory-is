<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Delivery;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view permission
    public function show(){
        $deliveries = Delivery::select('*','delivery.id as id')
                                ->join('order', 'delivery.order_id', '=', 'order.id')->filter(request(['search']))->paginate(10);
        return view('delivery.manage',[
            'title' => 'Manage Delivery',
            'deliveries' => $deliveries
        ]);
    }

    public function view(Delivery $delivery){

        $supplier = Supplier::join('order', 'supplier.id', '=', 'order.supplier_id')
                                ->join('delivery', 'order.id', '=', 'delivery.order_id')
                                ->where('delivery.id',$delivery->id)->first();

        $order = Order::join('delivery', 'order.id', '=', 'delivery.order_id')
                        ->where('delivery.id',$delivery->id)->first();

        $order_items = Order::join('order_items', 'order.id', '=', 'order_items.order_id')
                                ->join('products', 'order_items.products_id', '=', 'products.id')
                                ->join('delivery', 'order.id', '=', 'delivery.order_id')
                                ->where('delivery.id',$delivery->id)->get();

        return view('delivery.delivery_details',[
            'title' => 'Delivery Details',
            'supplier' => $supplier,
            'order' => $order,
            'order_items' => $order_items,
            'delivery' => $delivery
        ]);
    }

}