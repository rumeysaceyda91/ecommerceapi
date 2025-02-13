<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Helper\fileUpload;
use Illuminate\Support\Facades\Log;
use DateTime;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $pageNumber = $request->pageNumber;
        $pageSize = $request->pageSize;
        $search = $request->search;
        if(!isset($search))
        {
            $productCount = Product::get()->count();
            $products = Product::get();
        }else{
            $productCount = Product::where('name', $search)->get()->count();
            $products = Product::where('name', $search)->get();
        }
        $totalPageCount = ceil($productCount / $pageSize);

        $model = [
            "search" => $search,
            "datas" => $products,
            "pageNumber" => $pageNumber,
            "pageSize" => $pageSize,
            "totalPageCount" => $totalPageCount,
            "isFirstPage" => $pageNumber == 1 ? true : false,
            "isLastPage" => $totalPageCount == $pageNumber ? true : false
        ];

        return response()->json(
            $model
        );
    }

    public function add(Request $request)
    {
        $all = $request->all();
        $file = $request->images;
        $dt = new DateTime();
        $product = new Product([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'categories' => $request->categories,
            'isActive' => true,
            'imageUrls' => '',
            'createdDate' => $dt->format('Y-m-d H:i:s')
        ]);

        //unset($all['file']);unset($request->file('images'));
        $product->save();

        //$image_path = $request->file('images')->store('files', 'public');
        $image_path = $request->file('images')->store('files',['disk' => 'public_uploads']);
        $data = Product::where('id', $product->id)->update([
            'imageUrls' => $image_path
        ]);
        Log::info(json_encode($product->id));
             
            
        return response()->json($request, 201);
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
            
        return response()->json(['success'=>true, 'message'=>'Ürün Silindi']);
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

    public function getProductImages()
    {
        $product_images = ProductImage::get();

        return response()->json(
            $product_images
        );
    }
}
