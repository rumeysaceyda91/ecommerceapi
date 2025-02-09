<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class basket extends Model
{
    protected $fillable = [
        'productId',
        'price',
        'quantity',
        'userId'
    ];
}
