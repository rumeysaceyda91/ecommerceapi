<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->userId;
        
        if(!empty($user_id)){
            $baskets = Basket::where('userId', $user_id)->get();

            return response()->json(
                $baskets
            );
        }
        else{
            return response()->json(['message'=>'Lütfen login olunuz'], 401);
        }
    }

    public function add(Request $request)
    {
        if(!empty($request->userId)){
            $basket = new Basket([
                'userId' => $request->userId,
                'productId' => $request->productId,
                'price' => $request->price,
                'quantity' => $request->quantity
            ]);
                
            $basket->save();

            $product = Product::where('id', $request->productId)->first();
    
            Product::where('id', $request->productId)->update(['stock' => intval($product->stock) - $request->quantity]);
                
            return response()->json(["message" => $request->userId], 201);
        }else{
            return response()->json(["message" => "Lütfen login olunuz!!"], 401);
        }
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
