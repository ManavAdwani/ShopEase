<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Company;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;


class ProductController extends Controller
{
    public function index()
    {
        $activePage = 'products';
        $products = Product::all();
        $TotalProducts = Product::count();
        $TotalCompanies = Company::count();
        return view('admin.products.index', compact('activePage', 'products', 'TotalProducts', 'TotalCompanies'));
    }

    public function create()
    {
        $activePage = 'products';
        $companies = Company::all();
        $categories = Category::all();
        return view('admin.products.create_product', compact('activePage', 'companies', 'categories'));
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
        return redirect()->route('admin.products')->with('success', 'Product addedd successfully !');
    }

    public function delete($id)
    {
        $product_det = Product::findOrFail($id);
        if ($product_det) {
            $product_det->delete();
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully !');
        } else {
            return back()->with('error', 'Something went wrong !');
        }
    }


    public function edit($id)
    {
        $activePage = 'products';
        $product = Product::where('id', $id)->select('*')->first();
        $name = $product->product_name ?? '';
        $selectedcompany = $product->company_id ?? 0;
        $selectedcategory = $product->category_id ?? 0;
        $price = $product->product_price ?? 0;
        $images = $product->images ?? '';
        $companies = Company::all();
        $categories = Category::all();
        $product_id = $id ?? 0;
        return view('admin.products.edit_product', compact('product_id', 'activePage', 'companies', 'categories', 'product', 'name', 'selectedcompany', 'selectedcategory', 'price', 'images'));
    }

    public function create_company(Request $request)
    {
        $company_name = $request->get('company_name') ?? '';
        $company = new Company();
        $company->company_name = $company_name;
        $company->save();
        return response()->json([
            'id' => $company->id,
            'company_name' => $company->company_name,
        ]);
    }

    public function create_category(Request $request)
    {
        $category_name = $request->get('category_name') ?? '';
        $category = new Category();
        $category->company_id = 0;
        $category->category_name = $category_name;
        $category->save();
        return response()->json([
            'id' => $category->id,
            'category_name' => $category->category_name,
        ]);
    }

    public function delete_images($id, $imagePath)
    {
        $ogImage = Crypt::decrypt($imagePath);
        $product_id = $id ?? 0;
        $product = Product::findOrFail($product_id);
        $productImage = $product->images ?? '';
        $allImages = explode(',', $productImage);
        $newImages = array_filter($allImages, function ($value) use ($ogImage) {
            return $value !== $ogImage;
        });
        $product->images = implode(',', $newImages);
        $product->save();
        return back()->with('success', 'Image deleted successfully !');
        // dd($ogImage);

    }


    public function update_product($id, Request $request)
    {
        $product_id = $id ?? 0;
        $product = Product::findOrFail($id);
        if ($product) {
            $request->validate([
                'product_name' => 'required',
                'company_id' => 'required',
                'category_id' => 'required',
                'product_price' => 'required',
            ]);

            $oldImages = $product->images ?? '';
            // dd($oldImages);
            $oldImageCount = $product->image_count ?? 0;

            $product_images = $request->file('product_images');
            $product_name = $request->input('product_name') ?? '';
            $product_company = $request->input('company_id') ?? 0;
            $product_category = $request->input('category_id') ?? 0;
            $product_price = $request->input('product_price') ?? 0;

            $imagePaths = [];
            $image_cnt = 0;
            // dd($product_images);
            if ($request->hasFile('product_images')) {
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
                    $imagePathsString = implode(',', $imagePaths);
                    if (!empty($oldImages)) {
                        $updatedImages = $oldImages . ',' . $imagePathsString;
                    } else {
                        $updatedImages = $imagePathsString;
                    }
                    $product->images = $updatedImages;
                }
            }

            // $product = new Product();
            $product->product_name = $product_name;
            $product->company_id = $product_company;
            $product->category_id = $product_category;
            $product->product_price = $product_price;
            $product->image_count = $image_cnt + $oldImageCount;
            $product->save();
            return redirect()->route('admin.products')->with('success', 'Product Updated successfully !');
        } else {
            return redirect()->route('admin.products')->with('error', 'Something went wrong !');
        }
    }

    // USER SIDE
    public function user_products(Request $request)
    {
        $selectedcat = $request->get('category') ?? 0;
        $selectedcom = $request->get('company') ?? 0;
        $searched = $request->get('search') ?? '';

        // Fetch all categories and companies
        $categories = Category::all();
        $companies = Company::all();

        // Initialize the query builder for products
        $query = Product::query();

        // Apply category filter if present
        if ($request->get('category')) {
            $query->where('category_id', $request->get('category'));
        }

        if ($request->get('company')) {
            $query->where('company_id', $request->get('company'));
        }

        if ($request->get('search')) {
            $query->where('product_name', 'LIKE', '%' . $request->get('search') . '%');
        }

        // Paginate the results
        $products = $query->paginate(20);

        // Return the view with the fetched data
        return view('users.products.index', compact('searched', 'categories', 'companies', 'selectedcom', 'products', 'selectedcat'));
    }

    public function fav_product(Request $request)
    {
        $user_id = $request->user_id ?? 0;
        $product_id = $request->product_id ?? 0;

        // Check if the product is already in the favourites
        $getFav = Favourite::where('product_id', $product_id)->select()->first();

        if (!empty($getFav->id)) {
            $DBuserId = $getFav->user_id;
            $userIds = explode(",", $DBuserId);

            if (in_array($user_id, $userIds)) {
                // User has already favorited this product, so remove it from the favorites
                $userIds = array_diff($userIds, [$user_id]);
                $newIdsString = implode(",", $userIds);
                $getFav->user_id = $newIdsString;
                $getFav->update();

                // If no users are left, delete the record
                if (empty($newIdsString)) {
                    $getFav->delete();
                }

                return response()->json(['status' => 'success', 'message' => 'Product removed from your favorite list.']);
            } else {
                // Add user to the favorite list
                $userIds[] = $user_id;
                $newIdsString = implode(",", $userIds);
                $getFav->user_id = $newIdsString;
                $getFav->update();

                return response()->json(['status' => 'success', 'message' => 'Product added successfully to your favorite list!']);
            }
        } else {
            // No favorite entry found, create a new one
            $input = [
                'user_id' => $user_id,
                'product_id' => $product_id
            ];
            $fav_product = Favourite::create($input);

            if ($fav_product) {
                return response()->json(['status' => 'success', 'message' => 'Product added successfully to your favorite list!']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add product to your favorite list.']);
            }
        }
    }


    public function add_to_cart(Request $request)
    {
        $user_id = $request->user_id ?? 0;
        $product_id = $request->product_id ?? 0;
        $product_quantity = $request->pro_quan ?? 0;

        $product = Product::findOrFail($product_id);
        $input = [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $product_quantity,
            'status' => "pending"
        ];

        $checkCart = Cart::where('product_id', '=', $product_id)->where('user_id', '=', $user_id)->where('status', 'pending')->select()->first();
        if (!empty($checkCart->id)) {
            $cart = Cart::findOrFail($checkCart->id);
            $oldQuantity = $cart->quantity;
            $newQuant = $oldQuantity + $product_quantity;
            $cart->quantity = $newQuant;
            $cart->update();
            return response()->json(['data' => $product->product_name, 'status' => 'success', 'message' => 'Product added successfully in your cart !']);
        } else {
            $cart = Cart::create($input);
            if (!empty($cart->id)) {
                return response()->json(['data' => $product->product_name, 'status' => 'success', 'message' => 'Product added successfully in your cart !']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong please try again later !']);
            }
        }
    }

    public function store_products(Request $request)
    {
        $productsData = $request->productsData;

        foreach ($productsData as $product) {
            $checkProduct = Product::where('product_name', $product[0])->exists();
            if ($checkProduct) {
                return;
            }
            $input = [
                'product_name' => $product[0],
                'product_price' => $product[3],
                'images' => "",
                'image_count' => 0,
                'quantity' => $product[4]
            ];

            // Handle company
            $company = $product[1];
            $checkCompany = Company::where('company_name', $company)->first();
            if ($checkCompany) {
                $input['company_id'] = $checkCompany->id;
            } else {
                $addCompany = Company::create(['company_name' => $company]);
                $input['company_id'] = $addCompany->id;
            }

            // Handle category
            $category = $product[2];
            $checkCategory = Category::where('category_name', $category)->first();
            if ($checkCategory) {
                $input['category_id'] = $checkCategory->id;
            } else {
                $addCategory = Category::create(['category_name' => $category]);
                $input['category_id'] = $addCategory->id;
            }

            // Debugging: ensure $input contains the required fields
            if (!isset($input['company_id']) || !isset($input['category_id'])) {
                return back()->with('error', 'Company or Category ID missing');
            }


            // Ensure the Product model has 'company_id' and 'category_id' in its $fillable property
            Product::create($input);
        }

        return back()->with('success', 'Products added successfully!');
    }

    public function check_product(Request $request)
    {
        $product_name = $request->name ?? '';
        $company = $request->company ?? '';

        $checkProduct = Product::where('product_name', $product_name)->exists();
        return response()->json(['exists' => $checkProduct]);
    }

    public function download_users_csv()
    {
        $file = public_path('sample_csv\products.csv');

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file);
    }

    public function fav_product_page(Request $request){
        $activePage = 'products';
        $user_id = auth()->user()->id;
        $products = Product::join('favourites','products.id','=','favourites.product_id')->whereRaw("FIND_IN_SET(?, favourites.user_id)", [$user_id])->paginate(10);
        $TotalProducts = Product::count();
        $TotalCompanies = Company::count();
        return view('users.products.fav_product', compact('activePage', 'products', 'TotalProducts', 'TotalCompanies'));
    }
}
