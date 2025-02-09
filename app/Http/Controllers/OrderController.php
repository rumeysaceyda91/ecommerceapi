<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Basket;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('userId', $user->id)->get();

        return response()->json(
            $orders
        );
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $basket = Basket::where('userId', $user->id)->get();

        $orders = new Order([
            'userId' => $user->id,
            'productId' => $basket->productId,
            'price' => $basket->price,
            'quantity' => $basket->quantity,
            'createdDate' => Date()
        ]);
            
        $orders->save();
            
        return response()->json(["message" => "Sipariş Eklendi"], 201);
    }
}
