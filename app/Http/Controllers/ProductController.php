<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $activePage = 'products';
        $products = Product::all();
        return view('admin.products.index',compact('activePage','products'));
    }
}
