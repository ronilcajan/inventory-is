<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StockIn;
use App\Models\Category;
use App\Models\Products;
use App\Models\StockOut;
use App\Models\Supplier;
use App\Models\StockCard;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view product
    public function show(){
        $products = Products::select('*','products.id as id')
                            ->leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                            ->leftJoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                            ->leftJoin('supplier', 'stock_in.supplier_id', '=', 'supplier.id')
                            ->filter(request(['search']))
                            ->paginate(10);

        return view('product.items',[
            'title' => 'Manage Products',
            'products' => $products,
        ]);
    }

    public function items_report(Request $request){
        if($request->export){
            return Excel::download(new ProductExport($request->search), date('Y-m-d-h-i-s').'-sales-report.xlsx');
        }

        $products = StockCard::select('*','stock_card.created_at as created_at')
            ->leftJoin('supplier','stock_card.supplier', '=', 'supplier.id')
            ->leftJoin('products','stock_card.products_id', '=', 'products.id')
            ->orderBy('stock_card.created_at','ASC')
            ->filter(request(['search']))
            ->paginate(10);

        return view('product.items_report',[
            'title' => 'Products Reports',
            'products' => $products,
        ]);
    }

    public function create(){

        $suppliers = Supplier::all();
        $category = Category::all();
        $product = Products::latest()->first();

        return view('product.create_product',[
            'title' => 'Create Products',
            'categories' => $category,
            'suppliers' => $suppliers,
            'product' =>  $product
        ]);
    }

    // create new product
    public function store(Request $request){

        $product = $request->validate([
            'barcode' => 'required|unique:products,barcode',
            'name' => 'required|unique:products,name',
            'description' => '',
            'unit' => '',
            'min_stocks' => '',
            'category_id' => '',
        ]);

        if($request->hasFile('image')){
            $product['image'] = $request->file('image')->store('products','public');
        }

        $createProduct = Products::create($product);

        if($createProduct){

            $stock_in = array(
                'reference' => '',
                'stock_in_qty' => $request->quantity,
                'price' => $request->price,
                'products_id' => $createProduct->id,
                'supplier_id' => $request->supplier_id,
            );
    
            StockIn::create($stock_in);
            
            $stock_card = array(    
                'status' => 'stock-in',
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'price' => $request->price,
                'reference' => '',
                'supplier' => $request->supplier_id,
                'balance' => $request->quantity,
                'products_id' => $createProduct->id,
            );

            StockCard::create($stock_card);

            return back()->with('success','Product has been created successfully!');
        }
        
        return back()->with('error','Creating a product  is not successfull!');
        
    }

    // create new product
    public function save(Request $request){

        $product = $request->validate([
            'barcode' => 'required|unique:products,barcode',
            'name' => 'required|unique:products,name',
            'description' => '',
            'unit' => '',
            'min_stocks' => '',
            'category_id' => '',
        ]);

        $createProduct = Products::create($product);

        if($createProduct){

            return back()->with('success','Product has been created successfully!');
        }
        
        return back()->with('error','Creating a product  is not successfull!');
        
    }

    public function edit($product){

        $suppliers = Supplier::all();
        $category = Category::all();

        $getProduct = Products::select('*','products.id as id')
                            ->leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                            ->leftJoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                            ->leftJoin('supplier', 'stock_in.supplier_id', '=', 'supplier.id')
                            ->where('products.id', $product)
                            ->first();
                            
        return view('product.edit_product',[
            'title' => 'Edit Products',
            'categories' => $category,
            'suppliers' => $suppliers,
            'product' =>  $getProduct
        ]);
    }
    
    // update product
    public function update(Request $request, Products $product){

        $formfields = $request->validate([
            'barcode' => 'required',
            'name' => 'required',
            'description' => '',
            'unit' => '',
            'min_stocks' => '',
            'category_id' => '',
        ]);

        if($request->hasFile('image')){
            $formfields['image'] = $request->file('image')->store('products','public');
        }

        $update = $product->update($formfields);
        
        if($update){

            $check = StockIn::where('products_id',$product->id)->first(); //check if exist
            
            if($check){
                $stock_in = array(
                    'price' =>  $request->price,
                    'stock_in_qty' => $request->quantity,
                    'supplier_id' => $request->supplier_id,
                );
    
                StockIn::where('products_id', $product->id)->update($stock_in);
            }else{
                $stock_in = array(
                    'reference' => '',
                    'stock_in_qty' => $request->quantity,
                    'price' => $request->price,
                    'products_id' => $product->id,
                    'supplier_id' => $request->supplier_id,
                );
                StockIn::create($stock_in);

                $stock_card = array(    
                    'status' => 'stock-in',
                    'quantity' => $request->quantity,
                    'unit' => $request->unit,
                    'price' => $request->price,
                    'reference' => '',
                    'supplier' => $request->supplier_id,
                    'balance' => $request->quantity,
                    'products_id' => $product->id,
                );
    
                StockCard::create($stock_card);
            }
            

            return back()->with('success','Product has been updated successfully!');
        }
        
        return back()->with('error','Updating a product is not successfull!');
        
    }

    public function warehouse(){
        $products = Products::select('*','products.id as id')
                            ->leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                            ->leftJoin('supplier', 'stock_in.supplier_id', '=', 'supplier.id')
                            ->filter(request(['search']))
                            ->paginate(10);

        return view('product.warehouse',[
            'title' => 'Products in Warehouse',
            'products' => $products,
        ]);
    }

    public function shop(){
        $products = Products::select('*','products.id as id')
                            ->join('stock_out', 'products.id', '=', 'stock_out.products_id')
                            ->filter(request(['search']))
                            ->paginate(10);

        return view('product.store',[
            'title' => 'Products in Store',
            'products' => $products,
        ]);
    }

    public function movetoStore(Request $request){
        
        $validator = Validator::make($request->all(), [
            'percentage' => 'required',
            'mark_up' => 'required',
            'incharge' => 'required',
            'stock_out_qty' => 'required',
            'products_id' => 'required',
            'user_id' => '',
        ]);

        $product = $validator->validated();
        $product['user_id'] = Auth::user()->id;

        $check = StockOut::where('products_id',$request->products_id)->first(); //check if exist
        if($check){
            $stockout = array(
                'percentage' => $request->percentage,
                'mark_up' => $request->mark_up,
                'incharge' => $request->incharge,
                'stock_out_qty' => $check->stock_out_qty + $request->stock_out_qty,
            );
            $stock = StockOut::where('products_id',$request->products_id)->update($stockout);
        }else{
            $stock = StockOut::create($product);
        }

        if($stock){
            $stock_in = StockIn::where('products_id',$request->products_id)->first();

            $stock_out_qty = $request->stock_out_qty;

            $newStockinQTY = array(
                'stock_in_qty' => $stock_in->stock_in_qty - $stock_out_qty
            );

            StockIn::where('products_id',$request->products_id)->update($newStockinQTY);

            // $stockcard = StockCard::where('products_id', $request->products_id)->orderByDesc('id')->first();
            $stockcard = StockCard::where('products_id',$request->products_id)->latest()->first();
            $stock_card = array(    
                'status' => 'stock-out',
                'quantity' => $request->stock_out_qty,
                'unit' => $request->unit,
                'mark_up_price' => $request->mark_up,
                'incharge' => $request->incharge,
                'balance' => $stockcard->balance - $stock_out_qty,
                'products_id' => $request->products_id
            );

            StockCard::create($stock_card);


            return back()->with('success','Product has been moved successfully!');
        }
      
        
        return back()->with('error','Moving a product is not successfull!');
        
    }

    public function returntoWarehouse(Request $request){

        $check = StockOut::where('products_id',$request->products_id)->first(); //check if exist
        if($check){
            $stockout = array(
                'stock_out_qty' => $check->stock_out_qty - $request->return_qty,
            );
            $stock = StockOut::where('id',$check->id)->update($stockout);

            if($stock){
                $stock_in = StockIn::where('products_id',$request->products_id)->first();
    
                $newStockinQTY = array(
                    'stock_in_qty' => $stock_in->stock_in_qty + $request->return_qty
                );
    
                StockIn::where('products_id',$request->products_id)->update($newStockinQTY);
    
                $stockcard = StockCard::where('products_id',$request->products_id)->latest()->first();
    
                $stock_card = array(    
                    'status' => 'returned-item',
                    'quantity' => $request->return_qty,
                    'unit' => $request->unit,
                    'price' => $request->price,
                    'balance' => $stockcard->balance + $request->return_qty,
                    'products_id' => $request->products_id
                );
    
                StockCard::create($stock_card);
                return back()->with('success','Product has been returned successfully!');
            }
        }
        return back()->with('error','Returning a product is not successfull!');
        
    }

    public function stockCard(Products $product){
        
      if(request(['date'])){

        $stock_card = StockCard::select('*','stock_card.created_at as created_at')
            ->leftJoin('supplier','stock_card.supplier', '=', 'supplier.id')
            ->where('products_id',$product->id)
            ->filter(request(['date']))
            ->orderBy('stock_card.created_at','ASC')
            ->get();

      }else{

        $stock_card = StockCard::select('*','stock_card.created_at as created_at')
            ->leftJoin('supplier','stock_card.supplier', '=', 'supplier.id')
            ->where('products_id',$product->id)
            ->whereMonth('stock_card.created_at', Carbon::now()->month)
            ->whereYear('stock_card.created_at', Carbon::now()->year)
            ->filter(request(['date']))
            ->orderBy('stock_card.created_at','ASC')
            ->get();
      }

        return view('product.stock_card',[
            'title' => 'Stock Card Management',
            'stock_card' => $stock_card,
            'product' => $product,
        ]);
    }

    // delete product
     public function destroy(Products $product){
        $product->delete();
        return back()->with('success','Product has been deleted successfully!');
    }
}