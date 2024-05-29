<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $activePage = 'products';
        $products = Product::all();
        $TotalProducts = Product::count();
        return view('admin.products.index', compact('activePage', 'products','TotalProducts'));
    }

    public function create()
    {
        $activePage = 'products';
        return view('admin.products.create_product', compact('activePage'));
    }

    public function store(Request $request)
    {
        // dd("HI");
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'category_id' => 'required',
            'product_price' => 'required',
            'product_images' => 'required'
        ]);

        $product_images = $request->file('product_images');
        $product_name = $request->input('product_name') ?? '';
        $product_company = $request->input('company_id') ?? 0;
        $product_category = $request->input('category_id') ?? 0;
        $product_price = $request->input('product_price') ?? 0;

        $imagePaths = [];
        $image_cnt = 0;
        if ($product_images) {
            foreach ($product_images as $image) {
                $image_cnt++;
                // Define the path where you want to save the file
                $destinationPath = public_path('uploads/products');
            
                // Ensure the directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
            
                // Save the file
                $filename = $image->getClientOriginalName(); // Or generate a unique name
                $image->move($destinationPath, $filename);
            
                // Create the relative path to store in the database or use later
                $relativePath = 'uploads/products/' . $filename;
                $imagePaths[] = $relativePath;
                // dd($imagePaths);
            }
        }

        // Convert the array of image paths to a comma-separated string
        $imagePathsString = implode(',', $imagePaths);
        $product = new Product();
        $product->images = $imagePathsString;
        $product->product_name = $product_name;
        $product->company_id = $product_company;
        $product->category_id = $product_category;
        $product->product_price = $product_price;
        $product->image_count = $image_cnt;
        $product->save();
        return redirect()->route('admin.products')->with('success','Product addedd successfully !');

    }

    public function delete($id){
        $product_det = Product::findOrFail($id);
        if($product_det){
            $product_det->delete();
            return redirect()->route('admin.products')->with('success','Product deleted successfully !');
        }else{
            return back()->with('error','Something went wrong !');
        }
    }
}
