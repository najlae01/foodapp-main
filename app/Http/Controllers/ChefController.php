<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function listChef(){
        return response()->json(Chef::all(), 200);
    }

    public function getChef($id){
        $chef = Chef::find($id);
        if(is_null($chef))
            return response()->json(['message'=>'Chef Not Found'], 404);
        else
            return response()->json($chef, 200);
    }

    public function addChef(Request $request){
        $chef = new Chef() ;

        $chef->chefName = $request->input('chefName') ;
        $chef->chefDetails = $request->input('chefDetails') ;
        $chef->chefRole = $request->input('chefRole') ;
        if($request->hasfile('chefImg') != null)
        {
            $completefileName = $request->file('chefImg')->getClientOriginalName();
            $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
            $extension = $request->file('chefImg')->getClientOriginalExtension();
            $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
            $path = $request->file('chefImg')->storeAs('public/chefs', $compic);
            $chef->chefImg = $compic;
        }
        else{
                //  return $request;
            $chef->chefImg='';
        }
        if($chef->save())
            return ['status' => true, 'message' => 'chef Added Successfully'];
        else
            return ['status' => false, 'message' => 'Something Went Wrong'];
        //return response()->json($chef, 200);
    }

    public function updateChef(Request $request, $id){
        $chef = Chef::find($id);
        if(is_null($chef))
            return response()->json(['message'=>'chef Not Found'], 404);
        else{
            $chef->chefName = $request->input('chefName') ;
            $chef->chefDetails = $request->input('chefDetails') ;
            $chef->chefRole = $request->input('chefRole') ;
            if($request->hasfile('chefImg') != null)
            {
                $completefileName = $request->file('chefImg')->getClientOriginalName();
                $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
                $extension = $request->file('chefImg')->getClientOriginalExtension();
                $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
                $path = $request->file('chefImg')->storeAs('public/chefs', $compic);
                $chef->chefImg = $compic;
            }
            else{
                    //  return $request;
                $chef->chefImg='';
            }
            if($chef->save())
                return ['status' => true, 'message' => 'Chef Updated Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json($chef, 200);
        }
    }

    public function deleteChef($id){
        $chef = Chef::find($id);
        if(is_null($chef))
            return response()->json(['message'=>'Chef Not Found'], 404);
        else{
            if($chef->delete())
                return ['status' => true, 'message' => 'Chef Deleted Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json(null, 204);
        }
    }
}