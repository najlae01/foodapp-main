<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function listOrder(){
        return response()->json(Order::all(), 200);
    }

    public function getOrder($id){
        $order = Order::find($id);
        if(is_null($order))
            return response()->json(['message'=>'Order Not Found'], 404);
        else
            return response()->json($order, 200);
    }

    public function addOrder(Request $request){
        $order = Order::create($request->all());
        return response()->json($order, 200);
    }

    public function updateOrder(Request $request, $id){
        $order = Order::find($id);
        if(is_null($order))
            return response()->json(['message'=>'Order Not Found'], 404);
        else{
            $order->update($request->all());
            return response()->json($order, 200);
        }
    }

    public function deleteOrder($id){
        $order = Order::find($id);
        if(is_null($order))
            return response()->json(['message'=>'Order Not Found'], 404);
        else{
            $order->delete();
            return response()->json(null, 204);
        }
    }
}