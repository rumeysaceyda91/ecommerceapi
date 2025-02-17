<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::post('/register', [App\Http\Controllers\UserController::class, 'register'])->name('post.register');

Route::group([

    'prefix' => 'v1'
    
], function () {
    Route::post('register', [App\Http\Controllers\UserController::class, 'register']);
    Route::post('login', [App\Http\Controllers\UserController::class, 'login']);

    Route::post('products', [App\Http\Controllers\ProductController::class, 'index']);
    Route::get('productimages', [App\Http\Controllers\ProductController::class, 'getProductImages']);
    Route::post('products/getAllForHomePage', [App\Http\Controllers\ProductController::class, 'getAllForHomePage']);
});

Route::group([
    'prefix' => 'v1'
],function(){
    Route::get('Users', [App\Http\Controllers\UserController::class, 'Users']);
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']);

    Route::post('baskets', [App\Http\Controllers\BasketController::class, 'index']);
    Route::post('baskets/add', [App\Http\Controllers\BasketController::class, 'add']);
    Route::post('baskets/removeById/{id}', [App\Http\Controllers\BasketController::class, 'removeById']);
    Route::post('baskets/getCount', [App\Http\Controllers\BasketController::class, 'getCount']);

    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('categories/add', [App\Http\Controllers\CategoryController::class, 'add']);
    Route::post('categories/update', [App\Http\Controllers\CategoryController::class, 'update']);
    Route::post('categories/removeById/{id}', [App\Http\Controllers\CategoryController::class, 'removeById']);

    Route::post('orders', [App\Http\Controllers\OrderController::class, 'index']);
    Route::post('orders/create', [App\Http\Controllers\OrderController::class, 'add']);

    Route::post('products/add', [App\Http\Controllers\ProductController::class, 'add']);
    Route::post('products/update', [App\Http\Controllers\ProductController::class, 'update']);
    Route::post('products/removeById/{id}', [App\Http\Controllers\ProductController::class, 'removeById']);
    Route::post('products/changeActiveStatus', [App\Http\Controllers\ProductController::class, 'changeActiveStatus']);
    Route::post('products/getById', [App\Http\Controllers\ProductController::class, 'getById']);
    Route::post('products/removeImageByProductIdAndIndex', [App\Http\Controllers\ProductController::class, 'removeImageByProductIdAndIndex']);
})->middleware('auth:api');
