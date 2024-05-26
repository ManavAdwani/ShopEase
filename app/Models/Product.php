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
        'product_company',
        'product_category',
        'product_price',
        'image_count',
    ];
}
