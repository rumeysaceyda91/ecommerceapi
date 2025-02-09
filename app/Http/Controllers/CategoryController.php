<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        return response()->json(
            $categories
        );
    }

    public function add(Request $request)
    {
        $category = new Category([
            'name' => $request->name
        ]);
            
        $category->save();
            
        return response()->json(compact('category'), 201);
    }

    public function update(Request $request, $id)
    {
        $update = Category::where('id',$id)->update([
            'name'=>$request->name
        ]);
        if($update){
            return response()->json(['success'=>true]);
        }
        else 
        {
            return response()->json(['success'=>false,'message'=>'Ürün düzenlenemedi']);
        }
    }

    public function removeById($id)
    {
        Category::where('id',$id)->delete();
            
        return response()->json(['success'=>true,'message'=>'Kategori Silindi']);
    }
}
