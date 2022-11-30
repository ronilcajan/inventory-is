<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view 
    public function show(){
        $discounts = Discount::filter(request(['search']))->paginate(10);
        return view('discount.manage',[
            'title' => 'Manage Discount',
            'discounts' => $discounts
        ]);
    }

    // create new product category
    public function store(Request $request){

        $formfields = $request->validate([
            'coupon' => 'required|unique:discount,coupon',
            'discount' => 'required',
            'use' => 'required',
            'description' => '',
        ]);

        $discount = Discount::create($formfields);
        
        if($discount){
            return back()->with('success','Dicount has been created successfully!');
        }
        
        return back()->with('error','Creating a discount is not successful!');
        
    }

    // delete product category
    public function destroy(Discount $discount){
        $discount->delete();
        return back()->with('success','Product discount has been deleted successfully!');
    }
}