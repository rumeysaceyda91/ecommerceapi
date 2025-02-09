<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();

        return response()->json(
            $products
        );
    }

    public function add(Request $request)
    {
        $product = new Product([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'categories' => $request->categories,
            'isActive' => true,
            'imageUrls' => '',
            'createdDate' => Date()
        ]);
            
        $product->save();
            
        return response()->json(compact('product'), 201);
    }

    public function update(Request $request, $id)
    {
        $update = Product::where('id', $id)->update([
            'name'=>$request->name
        ]);
        if($update){
            return response()->json(['success'=>true]);
        }
        else 
        {
            return response()->json(['success'=>false, 'message'=>'Ürün düzenlenemedi']);
        }
    }

    public function removeById($id)
    {
        Product::where('id',$id)->delete();
            
        return response()->json(['success'=>true, 'message'=>'Kategori Silindi']);
    }

    public function changeActiveStatus(Request $request)
    {
        $product = Product::where('id', $id);
        $update = Product::where('id', $id)->update([
            'isActive'=>!$product->isActive
        ]);
        if($update){
            return response()->json(['success'=>true]);
        }
        else 
        {
            return response()->json(['success'=>false, 'message'=>'Ürün düzenlenemedi']);
        }
    }

    public function getById($id)
    {
        $product = Product::where('id', $id)->get();

        return response()->json(
            $product
        );
    }

    public function removeImageByProductIdAndIndex(Request $request)
    {
            
        return response()->json(["message"=>"test!!"]);
    }

    public function getAllForHomePage()
    {
        $products = Product::get();

        return response()->json(
            $products
        );
    }
}
