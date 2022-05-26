<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function listProduct(){
        return response()->json(Product::all(), 200);
    }

    public function getProduct($id){
        $product = Product::find($id);
        if(is_null($product))
            return response()->json(['message'=>'Product Not Found'], 404);
        else
            return response()->json($product, 200);
    }

    public function addProduct(Request $request){
        $product = new Product() ;

        $product->productName = $request->input('productName') ;
        $product->productDetails = $request->input('productDetails') ;
        $product->productPrice = $request->input('productPrice') ;
        $product->category_id = $request->input('category_id') ;
        if($request->hasfile('productImg') != null)
        {
            $completefileName = $request->file('productImg')->getClientOriginalName();
            $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
            $extension = $request->file('productImg')->getClientOriginalExtension();
            $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
            $path = $request->file('productImg')->storeAs('public/products', $compic);
            $product->productImg = $compic;
        }
        else{
                //  return $request;
            $product->productImg='';
        }
        if($product->save())
            return ['status' => true, 'message' => 'Product Added Successfully'];
        else
            return ['status' => false, 'message' => 'Something Went Wrong'];
        //return response()->json($product, 200);
    }

    public function updateProduct(Request $request, $id){
        $product = Product::find($id);
        if(is_null($product))
            return response()->json(['message'=>'Product Not Found'], 404);
        else{
            $product->productName = $request->input('productName') ;
            $product->productDetails = $request->input('productDetails') ;
            $product->productPrice = $request->input('productPrice') ;
            $product->category_id = $request->input('category_id') ;
            if($request->hasfile('productImg') != null)
            {
                $completefileName = $request->file('productImg')->getClientOriginalName();
                $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
                $extension = $request->file('productImg')->getClientOriginalExtension();
                $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
                $path = $request->file('productImg')->storeAs('public/products', $compic);
                $product->productImg = $compic;
            }
            else{
                    //  return $request;
                $product->productImg='';
            }
            if($product->save())
                return ['status' => true, 'message' => 'Product Updated Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json($product, 200);
        }
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        if(is_null($product))
            return response()->json(['message'=>'Product Not Found'], 404);
        else{
            if($product->delete())
                return ['status' => true, 'message' => 'Product Deleted Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json(null, 204);
        }
    }
}