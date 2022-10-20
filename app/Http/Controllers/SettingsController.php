<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view permission
    public function show(){
        $system =  Settings::get()->first();
        return view('settings',[
            'title' => 'Settings',
            'system' => $system
        ]);
    }

     // create new product category
     public function store(Request $request){

        $formfields = $request->validate([
            'business_name' =>  'required',
            'system_name' =>  'required',
            'address' =>  'required',
            'contact' =>  'required',
            'email' =>  'required',
        ]);

        if($request->hasFile('logo')){
            $formfields['logo'] = $request->file('logo')->store('system','public');
        }
        
        $create = Settings::create($formfields);
        
        if($create){
            return back()->with('success','System info has been created successfully!');
        }
        
        return back()->with('error','Creating system info is not successfull!');
        
    }
    public function update(Request $request, $id){

        $formfields = $request->validate([
            'business_name' =>  'required',
            'system_name' =>  'required',
            'address' =>  'required',
            'contact' =>  'required',
            'email' =>  'required',
        ]);

        if($request->hasFile('logo')){
            $formfields['logo'] = $request->file('logo')->store('system','public');
        }
        
        $update = Settings::findOrFail($id)->update($formfields);
        
        if($update){
            return back()->with('success','System info has been updated successfully!');
        }
        
        return back()->with('error','Updating system info is not successfull!');
        
    }
}