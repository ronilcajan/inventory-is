<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StockIn;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Products;
use App\Models\Supplier;
use App\Models\StockCard;
use App\Models\OrderItems;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    public function show(){
        $orders = Order::filter(request(['search']))->orderBy('status','DESC')->paginate(10);
        return view('order.manage',[
            'title' => 'Manage Orders',
            'orders' => $orders
        ]);
    }

    public function create(){
        $suppliers = Supplier::all();
        $category = Category::all();
        $products = Products::latest()->first();
        $order = Order::latest()->first();
        return view('order.create_orders',[
            'title' => 'Create Orders',
            'categories' => $category,
            'suppliers' => $suppliers,
            'products' => $products,
            'order' => $order
        ]);
    }

    // create 
    public function store(Request $request){

        $order = array(
            'order_number' => $request->order_no,
            'quantity' => $request->total_qty,
            'amount' => $request->grand_total,
            'status' => 'pending',
            'supplier_id' =>  $request->supplier_id,
        );

        $insert = Order::create($order);
        
        if($insert){

            $order_items = [];

            for($i=0; $i < count($request->product_id); $i++){
                $order_items[] = array(
                    'quantity' => $request->product_qty[$i],
                    'price' => $request->product_price[$i],
                    'order_id' => $insert->id,
                    'products_id' => $request->product_id[$i],
                );
            }

            OrderItems::insert($order_items);

            return redirect('/admin/orders/'.$insert->id.'/edit')->with('success','Orders has been created successfully!');
        }
        return back()->with('error','Creating a orders is not successfull!');
        
    }

    public function edit($order){
        $suppliers = Supplier::all();
        $category = Category::all();
        $products = Products::latest()->first();
        $orders = Order::find($order);

        $order_items = Order::join('order_items', 'order.id', '=', 'order_items.order_id')
                                ->leftJoin('products', 'order_items.products_id', '=', 'products.id')
                                ->where('order.id','=', $order)->get();
                                
        return view('order.edit_orders',[
            'title' => 'Edit Orders',
            'categories' => $category,
            'suppliers' => $suppliers,
            'products' => $products,
            'order' => $orders,
            'order_items' => $order_items
        ]);
    }

     // create 
     public function update(Order $order,Request $request){

        $order_details = array(
            'order_number' => $request->order_no,
            'quantity' => $request->total_qty,
            'amount' => $request->grand_total,
            'status' => 'pending',
            'supplier_id' =>  $request->supplier_id,
        );

        $update = $order->update($order_details);

        if($update){

            $order_items = [];

            for($i=0; $i < count($request->product_id); $i++){
                $order_items[] = array(
                    'quantity' => $request->product_qty[$i],
                    'price' => $request->product_price[$i],
                    'order_id' => $order->id,
                    'products_id' => $request->product_id[$i],
                );
            }
            OrderItems::where('order_id', $order->id)->delete();

            OrderItems::insert($order_items);

            return back()->with('success','Orders has been updated successfully!');
        }
        
        return back()->with('error','Updating a orders is not successfull!');
        
    }

    public function delivered(Order $order){

        $order_details = array(
            'status' => 'closed',
        );

        $update = $order->update($order_details);

        if($update){

            $delivery_or = 'DR-'.date('Y').'-'.$order->id;
            $delivery = array(
                'delivery_or' => $delivery_or,
                'order_id' => $order->id,
            );
    
            Delivery::create($delivery);

            $order_items = OrderItems::join('products', 'order_items.products_id', '=', 'products.id')->where('order_id',$order->id)->get();//get all items

            foreach($order_items as $row){

                $check = StockIn::where('products_id', $row->products_id)->first(); //check if exist
            
                if($check){
                    
                    $stock_in = array(
                        'price' =>  $row->price,
                        'stock_in_qty' => $check->stock_in_qty + $row->quantity,
                        'supplier_id' => $order->supplier_id,
                    );
        
                    StockIn::where('products_id', $row->products_id)->update($stock_in);

                    $stock_card = array(    
                        'status' => 'stock-in',
                        'quantity' => $row->quantity,
                        'unit' => $row->unit,
                        'price' => $row->price,
                        'reference' => $delivery_or,
                        'supplier' => $order->supplier_id,
                        'balance' => $check->stock_in_qty + $row->quantity,
                        'products_id' => $row->id,
                    );

                }else{
                    
                    $stock_in = array(
                        'reference' => $delivery_or,
                        'stock_in_qty' => $row->quantity,
                        'price' => $row->price,
                        'products_id' => $row->products_id,
                        'supplier_id' => $order->supplier_id,
                    );

                    StockIn::create($stock_in);
    
                    $stock_card = array(    
                        'status' => 'stock-in',
                        'quantity' => $row->quantity,
                        'unit' => $row->unit,
                        'price' => $row->price,
                        'reference' => $delivery_or,
                        'supplier' => $order->supplier_id,
                        'balance' => $row->quantity,
                        'products_id' => $row->id,
                    );
                }
                
                StockCard::create($stock_card);
            } 
            
            return back()->with('success','Orders has been mark as delivered!');
        }

        return back()->with('error','Marking delivery as delivered is not successfull!');
    }

    public function view($order){
        $supplier = Supplier::join('order', 'supplier.id', '=', 'order.supplier_id')->where('order.id',$order)->first();
        $order = Order::find($order);

        $order_items = Order::join('order_items', 'order.id', '=', 'order_items.order_id')
                                ->join('products', 'order_items.products_id', '=', 'products.id')
                                ->find($order);
        return view('order.order_details',[
            'title' => 'Purchase Order',
            'supplier' => $supplier,
            'order' => $order,
            'order_items' => $order_items
        ]);
    }

    public function search_barode(Request $request){
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Products::where('barcode','LIKE',"%$search%")->orWhere('name','LIKE',"%$search%")->get();
        }
        return response()->json($data);
    }

    public function findProduct(Request $request){
        $data = [];

        if($request->has('id')){
            $search = $request->id;
            $data = Products::leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')->find($search);
        }
        return response()->json($data);
    }

    // delete
    public function destroy(Order $order){
        $order->delete();
        return back()->with('success','Order has been deleted successfully!');
    }
}