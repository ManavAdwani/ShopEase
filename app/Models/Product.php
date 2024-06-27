<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'images',
        'product_name',
        'company_id',
        'category_id',
        'product_price',
        'image_count',
        'quantity',
        'color',
        'sku',
        'model_number'
    ];
}
