<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [UserController::class, 'login'])->name('users.login');

#Admin Routes
Route::get('admin-dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('users',[AdminController::class,'users'])->name('admin.users');
Route::get('upload-users',[AdminController::class,'upload_users'])->name('admin.upload_users');
Route::get('create-users',[AdminController::class,'create_user'])->name('admin.create');
Route::post('store-user',[AdminController::class,'store_user'])->name('admin.store_user');
Route::get('edit-user/{id}',[AdminController::class,'edit_user'])->name('admin.edit_user');
Route::post('update-user/{id}',[AdminController::class,'update_user'])->name('admin.update_user');
Route::get('change-password/{id}',[AdminController::class,'change_pass'])->name('admin.change_pass');
Route::post('update_password/{id}',[AdminController::class,'update_pass'])->name('admin.update_pass');
Route::get('delete-user/{id}',[AdminController::class,'delete_user'])->name('admin.delete_user');

Route::get('products',[ProductController::class,'index'])->name('admin.products');
Route::get('create-product',[ProductController::class,'create'])->name('admin.create_product');
Route::post('store-product',[ProductController::class,'store'])->name('admin.product_store');
Route::get('delete-product/{id}',[ProductController::class,'delete'])->name('admin.delete_product');
ROute::get('edit-product/{id}',[ProductController::class,'edit'])->name('admin.edit_product');
Route::post('create-company',[ProductController::class,'create_company'])->name('admin.create_company');
Route::post('create-category',[ProductController::class,'create_category'])->name('admin.create_category');
Route::get('delete-images/{id}/{image}',[ProductController::class,'delete_images'])->name('admin.delete_images');
Route::post('update-product/{id}',[ProductController::class,'update_product'])->name('admin.update_product');
Route::get('orders',[OrdersController::class,'orders'])->name('admin.orders');
Route::get('edit-order/{id}',[OrdersController::class,'edit_order'])->name('admin.edit_order');
Route::post('update-cart-admin',[OrdersController::class,'update_cart_admin'])->name('admin.update_cart');
Route::get('accept-order/{id}',[OrdersController::class,'accept_order'])->name('admin.accept_order');
Route::get('reject-order/{id}',[OrdersController::class,'reject_order'])->name('admin.reject_order');

Route::post('store-csv-users',[AdminController::class,'store_csv_users'])->name('admin.store_csv_users');

#Users Route
// Route::get('users-nav',[UserController::class,'navbar'])->name('users.navbar');
Route::get('homepage',[UserController::class,'user_homepage'])->name('users.homepage');
Route::get('user-products',[ProductController::class,'user_products'])->name('users.products');
Route::post('fav_product',[ProductController::class,'fav_product'])->name('users.fav_pro');
Route::post('add_to_cart',[ProductController::class,'add_to_cart'])->name('users.add_to_cart');
Route::get('cart',[CartController::class,'cart_index'])->name('users.cart');
Route::post('update_cart',[CartController::class,'update_cart'])->name('users.update_cart');
Route::get('user-address',[CartController::class,'user_address'])->name('users.address');
Route::post('add-address',[CartController::class,'store_address'])->name('users.store_address');
Route::get('/get-city-state', [CartController::class, 'getCityState']);
Route::get('thank-you',[CartController::class,'thankyou'])->name('users.thankyou');
Route::get('save-order-old-address/{id}',[CartController::class,'save_order_old'])->name('users.save_address_order');
