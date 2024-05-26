<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
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