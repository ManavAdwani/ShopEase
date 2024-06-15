<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = "user_address";
    protected $fillable = [
        'address',
        'zipcode',
        'city',
        'state',
        'user_id'
    ];
}
