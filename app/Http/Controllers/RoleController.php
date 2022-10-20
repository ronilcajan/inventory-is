<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin']);
    }

    // view roles 
    public function show(){
        $roles = Role::with('permissions')->get();

        $permissions = Permission::all();

        return view('auth.roles',[
            'title' => 'Manage Roles',
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    // create new role
    public function store(Request $request){

        $formfields = $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'required'
        ]);

        $permi = $request->permissions;

        $role = Role::create($formfields);

        $addPermission = $role->givePermissionTo($permi);

        if($addPermission){
            return back()->with('success','Role had been created successfully!');
        }
        
        return back()->with('error','Creating a role is not successfull!');
        
    }
    // edit role
    public function update(Request $request){

        $formfields = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $permi = $request->permissions;

        Role::findOrFail($request->role_id)->update($formfields);

        $role = Role::find($request->role_id)->syncPermissions($permi);
        
        if($role){
            return back()->with('success','Permission had been updated successfully!');
        }
        
        return back()->with('error','Updating a permission is not successfull!');
        
    }
    // delete permission
    public function destroy(Role $role){
        $role->delete();
        return back()->with('success','Role has been deleted successfully!');
    }
}
