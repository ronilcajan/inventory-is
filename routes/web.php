<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingsController;

Route::get('/', function(){
    return redirect('auth');
});
Route::get('/register', function(){
    return redirect('auth/register');
});
Route::get('/admin', function(){
    return redirect('admin/dashboard');
});

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'] )->name('login');
    Route::get('/login', [UserController::class, 'index'] );
    Route::get('/register', [UserController::class, 'register'] );
    Route::post('/authenticate', [UserController::class, 'authenticate'] )->name('authenticate');
    Route::post('/signup', [UserController::class, 'signup'] )->name('signup');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/yearlySales', [DashboardController::class, 'sales']);

    Route::get('/products/items', [ProductController::class, 'show'])->name('items');
    Route::get('/products/create', [ProductController::class, 'create'])->name('items-create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('items-save');
    Route::post('/products/create', [ProductController::class, 'save'])->name('product-create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}/update', [ProductController::class, 'update']);
    Route::delete('/products/delete/{product}', [ProductController::class, 'destroy']);
    
    Route::get('/products/warehouse', [ProductController::class, 'warehouse'])->name('warehouse');
    Route::get('/products/shop', [ProductController::class, 'shop'])->name('store');
    Route::post('/products/warehouse/move_to_store', [ProductController::class, 'movetoStore'])->name('move-to-store');
    Route::post('/products/warehouse/return_to_warehouse', [ProductController::class, 'returntoWarehouse'])->name('return-to-warehouse');
    Route::get('/products/{product}/stock-card', [ProductController::class, 'stockCard']);

    Route::get('/supplier', [SupplierController::class, 'show'])->name('supplier');
    Route::post('/supplier/create', [SupplierController::class, 'store'])->name('supplier-create');
    Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier-update');
    Route::delete('/supplier/destroy/{supplier}', [SupplierController::class, 'destroy']);
    Route::get('/supplier/{supplier}/details', [SupplierController::class, 'supplier']);

    Route::get('/products/category', [CategoryController::class, 'show'])->name('category');
    Route::post('/products/category/create', [CategoryController::class, 'store'])->name('category-create');
    Route::post('/products/category/update', [CategoryController::class, 'update'])->name('category-update');
    Route::delete('/products/category/destroy/{category}', [CategoryController::class, 'destroy']);
    Route::get('/products/category/{category}/details', [CategoryController::class, 'category']);

    Route::get('/orders', [OrderController::class, 'show'])->name('orders');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders-create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders-save');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit']);
    Route::put('/orders/{order}/update', [OrderController::class, 'update']);
    Route::get('/orders/{order}/details', [OrderController::class, 'view']);
    Route::get('/orders/{order}/delivered', [OrderController::class, 'delivered']);
    Route::delete('/orders/destroy/{order}', [OrderController::class, 'destroy']);
    Route::post('/orders/findProduct', [OrderController::class, 'findProduct']);

    Route::get('/deliveries', [DeliveryController::class, 'show'])->name('deliveries');
    Route::get('/deliveries/{delivery}/details', [DeliveryController::class, 'view']);

    Route::get('/pos', [POSController::class, 'show']);
    Route::post('/pos/search', [POSController::class, 'search']);
    Route::post('/pos/sold', [POSController::class, 'sold']);
    
    Route::get('/sales/{receipt}', [POSController::class, 'receipt']);
    Route::get('/sales', [SalesController::class, 'show']);
    Route::get('/sales/{receipt}/view', [SalesController::class, 'view']);
    Route::delete('/sales/{receipt}/delete', [SalesController::class, 'destroy_sales']);
    Route::delete('/sales/item/{item}/delete', [SalesController::class, 'destroy']);

    Route::get('/report/sales', [SalesController::class, 'sales_report']);
    Route::get('/report/items', [ProductController::class, 'items_report']);

    Route::get('/users', [UserController::class, 'show']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/updateUser', [UserController::class, 'update']);
    Route::post('/resetPassword/{id}', [UserController::class, 'resetPassword']);
    Route::post('/changePass', [UserController::class, 'changePassword']);
    Route::get('/user/account', [UserController::class, 'profile']);
    Route::delete('/deleteUser/{user}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/roles', [RoleController::class, 'show']);
    Route::post('/createRole', [RoleController::class, 'store']);
    Route::post('/updateRole', [RoleController::class, 'update']);
    Route::delete('/deleteRole/{role}', [RoleController::class, 'destroy']);

    Route::get('/permissions', [PermissionController::class, 'show']);
    Route::post('/createPermission', [PermissionController::class, 'store']);
    Route::post('/updatePermission', [PermissionController::class, 'update']);
    Route::delete('/deletePermission/{permission}', [PermissionController::class, 'destroy']);

    Route::get('/settings', [SettingsController::class, 'show']);
    Route::post('/settings/create', [SettingsController::class, 'store']);
    Route::put('/settings/{id}/update', [SettingsController::class, 'update']);

});

Route::post('search_barcode', [OrderController::class, 'search_barode']);