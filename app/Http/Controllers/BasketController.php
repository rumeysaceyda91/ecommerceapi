<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $baskets = Basket::where('userId', $user->id)->get();

        return response()->json(
            $baskets
        );
    }

    public function add(Request $request)
    {
        $basket = new Basket([
            'userId' => $request->userId,
            'productId' => $request->productId,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);
            
        $basket->save();

        $product = Product::where('id', $request->productId)->get();
        $product->stock -= $request->quantity;
        Product::update($product)->where('id', $request->productId);
            
        return response()->json(["message" => "Ürün Eklendi"], 201);
    }

    public function removeById($id)
    {
        Basket::where('id',$id)->delete();
            
        return response()->json(['success'=>true,'message'=>'Sepet Silindi']);
    }

    public function getCount(Request $request)
    {
        $count = Basket::where('userId', $request->userId)->count();

        return response()->json(
            ["count" => $count]
        );
    }
}
