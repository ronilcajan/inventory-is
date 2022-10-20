<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware(['role:admin'])->except(['index','register','signup','authenticate','changePassword','profile','logout']);
    }
    // show login page
    public function index(){
        return view('auth.login');
    }

    // authenticate login attempt
    public function authenticate(Request $request){
        $formfields = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->input('remember_me');

        if(auth()->attempt($formfields,$remember)){

            $request->session()->regenerate();
            return redirect('admin/dashboard')->with('success', "You're now logged in!");

        }

        return back()->withErrors(['username' => 'Invalid Credentials!']);
    }

    // show register page
    public function register(){
        return view('auth.register');
    }
      // register new user
    public function signup(Request $request){
        $formfields = $request->validate([
            'username' => 'required|min:5|unique:users,username',
            'password' => 'required|min:5',
        ]);

        //hash password
        $formfields['password'] = Hash::make($formfields['password']);

        $user = User::create($formfields);

        $create = $user->syncRoles(['admin']);
        
        if($create){
            return redirect('/auth/login')->with('success','User had been created successfully!');
        }
        
        return back()->with('error','Creating a user is not successfull!');
    }

    // show user page
    public function show(){
        $user = User::with('roles')->paginate(10);
        $role = Role::all();

        return view('auth.users',[
            'title' => 'Manage Users',
            'users' => $user,
            'roles' => $role
        ]);
    }

    // create new user
    public function store(Request $request){
        $formfields = $request->validate([
            'username' => 'required|min:5|unique:users,username',
            'firstname' => '',
            'lastname' => '',
            'contact_no' => '',
            'password' => '',
        ]);

        $role = $request->validate([
            'name' => 'required'
        ]);

        //hash password
        $formfields['password'] = Hash::make($formfields['username']);

        $user = User::create($formfields);

        $create = $user->syncRoles($role);

        if($create){
            return back()->with('success','User had been created successfully!');
        }
        
        return back()->with('error','Creating a user is not successfull!');
    }

    // update user
    public function update(Request $request){

        $formfields = $request->validate([
            'firstname' => '',
            'lastname' => '',
            'contact_no' => '',
        ]);

        $role = $request->validate([
            'name' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);
        User::findOrFail($request->user_id)->update($formfields);

        $update = $user->syncRoles($role);

        if($update){
            return back()->with('success','User had been updated successfully!');
        }
        
        return back()->with('error','Updating a user is not successfull!');
        
    }

    // reset user password
    public function resetPassword(Request $request){
        $pass = array();

        $user = User::findOrFail($request->id);
         //hash password
        $pass['password'] = Hash::make($user->username);

        User::findOrFail($request->id)->update($pass);

        return back()->with('success','User password has been successfully reset!');
    }

     // change user password
     public function changePassword(Request $request){
        $formfields = $request->validate([
            'username' => 'required',
            'password' => 'required|min:5|',
        ]);
        //hash password
        $formfields['password'] = Hash::make($formfields['password']);

        User::findOrFail($request->user_id)->update($formfields);

        return back()->with('success','Your password has been changed successfully!');
    }

    public function profile(){
        $user = User::find(auth()->user()->id)->profile;
        $data = array(
            'title' => 'Personnel Profile',
            'user' => $user
        );
        
        return view('auth.user_profile', $data);
    }

    // delete user
    public function destroy(User $user){
        $user->delete();
        return back()->with('success','User has been deleted successfully!');
    }

    // user logout
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','User had been logged out!');
    }

}
