<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function listGallery(){
        return response()->json(Gallery::all(), 200);
    }

    public function getGallery($id){
        $gallery = Gallery::find($id);
        if(is_null($gallery))
            return response()->json(['message'=>'Image Not Found'], 404);
        else
            return response()->json($gallery, 200);
    }

    public function addGallery(Request $request){
        $gallery = new Gallery() ;
        if($request->hasfile('galleryImg') != null)
        {
            $completefileName = $request->file('galleryImg')->getClientOriginalName();
            $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
            $extension = $request->file('galleryImg')->getClientOriginalExtension();
            $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
            $path = $request->file('galleryImg')->storeAs('public/galleries', $compic);
            $gallery->galleryImg = $compic;
        }
        else{
                //  return $request;
            $gallery->galleryImg='';
        }
        if($gallery->save())
            return ['status' => true, 'message' => 'Image Added Successfully'];
        else
            return ['status' => false, 'message' => 'Something Went Wrong'];
        //return response()->json($gallery, 200);
    }

    public function updateGallery(Request $request, $id){
        $gallery = Gallery::find($id);
        if(is_null($gallery))
            return response()->json(['message'=>'Image Not Found'], 404);
        else{
            if($request->hasfile('galleryImg') != null)
            {
                $completefileName = $request->file('galleryImg')->getClientOriginalName();
                $fileNamOnly = pathinfo($completefileName, PATHINFO_FILENAME);
                $extension = $request->file('galleryImg')->getClientOriginalExtension();
                $compic = str_replace(' ', '_', $fileNamOnly).'-'.rand().'_'.time().'.'.$extension;
                $path = $request->file('galleryImg')->storeAs('public/galleries', $compic);
                $gallery->galleryImg = $compic;
            }
            else{
                    //  return $request;
                $gallery->galleryImg='';
            }
            if($gallery->save())
                return ['status' => true, 'message' => 'gallery Updated Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
        //return response()->json($gallery, 200);
        }
    }
    public function deleteGallery($id){
        $gallery = Gallery::find($id);
        if(is_null($gallery))
            return response()->json(['message'=>'Image Not Found'], 404);
        else{
            if($gallery->delete())
                return ['status' => true, 'message' => 'Image Deleted Successfully'];
            else
                return ['status' => false, 'message' => 'Something Went Wrong'];
            //return response()->json(null, 204);
        }
    }
}