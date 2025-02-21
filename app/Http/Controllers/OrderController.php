<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Basket;
use App\Models\Product;
use DateTime;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->userId;
        $products = new Product;
        
        if(!empty($user_id)){
            $orders = Order::where('userId', $user_id)->get();
            foreach($orders as $order){
            $products = Product::where('id', $order->productId)->get();
            }

            $model = [
                "orders" => $orders,
                "products" => $products
            ];
         
            return response()->json($model);
        }
        else{
            return response()->json(['message'=>"Lütfen login olunuz"], 401);
        }
    }

    public function add(Request $request)
    {
        $user_id = $request->userId;
        $dt = new DateTime();
        $baskets = $request->baskets;
        
        foreach($baskets as $basket)
        {
            $orders = new Order([
                'userId' => $user_id,
                'productId' => $basket['productId'],
                'price' => $basket['price'],
                'quantity' => $basket['quantity'],
                'createdDate' => $dt->format('Y-m-d H:i:s')
            ]);
                
            $orders->save();
            Basket::where('id', $basket['id'])->delete();
        }
            
        return response()->json(["message" => "Sipariş Eklendi"], 201);
    }
}
