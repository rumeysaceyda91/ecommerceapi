<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'productId',
        'price',
        'quantity',
        'userId',
        'createdDate'
    ];
}
