<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }
    
    //view permission
    public function show(){
        $permissions = Permission::all();
        return view('auth.permission',[
            'title' => 'Manage Permissions',
            'permissions' => $permissions
        ]);
    }

    // create new permission
    public function store(Request $request){

        $formfields = $request->validate([
            'name' => 'required|unique:permissions,name',
            'description' => 'required'
        ]);

        $permissions = Permission::create($formfields);
        
        if($permissions){
            return back()->with('success','Permission had been created successfully!');
        }
        
        return back()->with('error','Creating a permission is not successfull!');
        
    }
     // edit permission
    public function update(Request $request){

        $formfields = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $permissions = Permission::findOrFail($request->permission_id)->update($formfields);
        
        if($permissions){
            return back()->with('success','Permission had been updated successfully!');
        }
        
        return back()->with('error','Updating a permission is not successfull!');
        
    }
     // delete permission
     public function destroy(Permission $permission){
        $permission->delete();
        return back()->with('success','Permission has been deleted successfully!');
    }
}
