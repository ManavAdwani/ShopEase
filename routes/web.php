<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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

#Users Route
// Route::get('users-nav',[UserController::class,'navbar'])->name('users.navbar');
Route::get('homepage',[UserController::class,'user_homepage'])->name('users.homepage');
Route::get('user-products',[ProductController::class,'user_products'])->name('users.products');
Route::post('fav_product',[ProductController::class,'fav_product'])->name('users.fav_pro');