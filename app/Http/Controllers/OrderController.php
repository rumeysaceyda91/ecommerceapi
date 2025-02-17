<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Basket;
use DateTime;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->userId;
        
        if(!empty($user_id)){
            $orders = Order::where('userId', $user_id)->get();
            return response()->json(
                $orders
            );
        }
        else{
            return response()->json(['message'=>$user], 401);
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
        }
            
        return response()->json(["message" => "Sipariş Eklendi"], 201);
    }
}
