<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNavBar extends Model
{
    use HasFactory;
    protected $table = "admin_nav_bar";
    protected $fillable = [
        'website_logo',
        'website_name'
    ];
}
