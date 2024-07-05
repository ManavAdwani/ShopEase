<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Str;


class ProcessProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productsData;

    /**
     * Create a new job instance.
     */
    public function __construct($productsData)
    {
        $this->productsData = $productsData;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->productsData as $product) {
            $checkProduct = Product::where('product_name', $product[0])
                ->orWhere('model_number', $product[5])->exists();
            if ($checkProduct) {
                continue;
            }
            $input = [
                'product_name' => $product[0],
                'product_price' => $product[3],
                'images' => "",
                'image_count' => 0,
                'quantity' => $product[4],
                'model_number' => $product[5],
                'color' => $product[6]
            ];
            $sku = Str::slug($product[0]);
            $input['sku'] = $sku;

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
                $addCategory = Category::create(['category_name' => $category, 'company_id' => 0]);
                $input['category_id'] = $addCategory->id;
            }

            // Ensure the Product model has 'company_id' and 'category_id' in its $fillable property
            Product::create($input);
        }
    }
}
