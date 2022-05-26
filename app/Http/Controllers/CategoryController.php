<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listCategory(){
        return response()->json(Category::all(), 200);
    }

    public function getCategory($id){
        $category = Category::find($id);
        if(is_null($category))
            return response()->json(['message'=>'Category Not Found'], 404);
        else
            return response()->json($category, 200);
    }

    public function addCategory(Request $request){
        $category = new Category() ;

        $category->categoryName = $request->input('categoryName') ;
        $category->categoryDetails = $request->input('categoryDetails') ;
        if($request->hasfile('categoryImg') != null)
        {
            $completefileName = $request->file('categoryImg')->getClientOriginalName();
            $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
            $extension = $request->file('categoryImg')->getClientOriginalExtension();
            $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
            $path = $request->file('categoryImg')->storeAs('public/categories', $compic);
            $category->categoryImg = $compic;
        }
        else{
                //  return $request;
            $category->categoryImg='';
        }
        if($category->save())
            return ['status' => true, 'message' => 'Category Added Successfully'];
        else
            return ['status' => false, 'message' => 'Something Went Wrong'];
        //return response()->json($category, 200);
    }

    public function updateCategory(Request $request, $id){
        $category = Category::find($id);
        if(is_null($category))
            return response()->json(['message'=>'Category Not Found'], 404);
        else{
            $category->categoryName = $request->input('categoryName') ;
            $category->categoryDetails = $request->input('categoryDetails') ;
            if($request->hasfile('categoryImg') != null)
            {
                $completefileName = $request->file('categoryImg')->getClientOriginalName();
                $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
                $extension = $request->file('categoryImg')->getClientOriginalExtension();
                $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
                $path = $request->file('categoryImg')->storeAs('public/categories', $compic);
                $category->categoryImg = $compic;
            }
            else{
                    //  return $request;
                $category->categoryImg='';
            }
            if($category->save())
                return ['status' => true, 'message' => 'Category Updated Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json($category, 200);
        }
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        if(is_null($category))
            return response()->json(['message'=>'Category Not Found'], 404);
        else{
            if($category->delete())
                return ['status' => true, 'message' => 'Category Deleted Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json(null, 204);
        }
    }

    public function productsByCategory($id)
    {
        $category = Category::find($id);
        $products = DB::table('products')->where('category_id','=', $id)->get();
        if(is_null($category))
            return response()->json(['message'=>'Category Not Found'], 404);
        else
            return response()->json($products, 200);
    }
}