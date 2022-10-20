<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view permission
    public function show(){
        $suppliers = Supplier::filter(request(['search']))->paginate(10);

        return view('supplier.manage',[
            'title' => 'Manage Supplier',
            'suppliers' => $suppliers
        ]);
    }

    // // create new supplier
    public function store(Request $request){

        $formfields = $request->validate([
            'supplier_name' => 'required|unique:supplier,supplier_name',
            'supplier_email' => 'required|email|unique:supplier,supplier_email',
            'supplier_contact_no' => 'required',
            'supplier_address' => '',
            'supplier_company' => '',
        ]);

        $supplier = Supplier::create($formfields);
        
        if($supplier){
            return back()->with('success','Supplier had been created successfully!');
        }
        
        return back()->with('error','Creating a supplier is not successfull!');
        
    }
    //  // update supplier
    public function update(Request $request){

        $formfields = $request->validate([
            'supplier_name' => 'required',
            'supplier_email' => 'required|email',
            'supplier_contact_no' => 'required',
            'supplier_address' => '',
            'supplier_company' => '',
        ]);

        $supplier = Supplier::findOrFail($request->supplier_id)->update($formfields);
        
        if($supplier){
            return back()->with('success','Supplier had been updated successfully!');
        }
        
        return back()->with('error','Updating a supplier is not successfull!');
        
    }
    //  // delete supplier
     public function destroy(Supplier $supplier){
        $supplier->delete();
        return back()->with('success','Supplier has been deleted successfully!');
    }

    //view permission
    public function supplier(Supplier $supplier){

        $products = Products::leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                            ->leftJoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                            ->leftJoin('supplier', 'stock_in.supplier_id', '=', 'supplier.id')
                            ->where('supplier.id', $supplier->id)
                            ->paginate(10);

        return view('supplier.supplier',[
            'title' => 'Supplier: '.$supplier->supplier_name,
            'supplier' => $supplier,
            'products' => $products
        ]);
    }
}
