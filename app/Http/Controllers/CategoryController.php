<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view permission
    public function show(){
        $categories = Category::filter(request(['search']))->paginate(10);
        return view('product.category',[
            'title' => 'Manage Products Category',
            'categories' => $categories
        ]);
    }

    // create new product category
    public function store(Request $request){

        $formfields = $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => '',
        ]);

        $supplier = Category::create($formfields);
        
        if($supplier){
            return back()->with('success','Product category has been created successfully!');
        }
        
        return back()->with('error','Creating a product category  is not successfull!');
        
    }
    //  // update product category
    public function update(Request $request){

        $formfields = $request->validate([
            'name' => 'required',
            'description' => '',
        ]);

        $supplier = Category::findOrFail($request->category_id)->update($formfields);
        
        if($supplier){
            return back()->with('success','Product category has been updated successfully!');
        }
        
        return back()->with('error','Updating a product category is not successfull!');
        
    }

    public function category(Category $category){

        $products = Products::leftJoin('categories', 'products.category_id', '=', 'categories.id')
                            ->leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                            ->leftJoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                            ->where('categories.id', $category->id)
                            ->paginate(10);

        return view('product.category_details',[
            'title' => 'Category: '.$category->name,
            'category' => $category,
            'products' => $products
        ]);
    }

    // delete product category
     public function destroy(Category $category){
        $category->delete();
        return back()->with('success','Product category has been deleted successfully!');
    }
}
