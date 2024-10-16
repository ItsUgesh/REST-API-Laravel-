<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CRUDController extends Controller
{
    function read()
    {
        $product = Products::all();
        return response()->json([
            "status" => "success",
            "products" => $product,
            "message" => "read successfully",
        ]);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->messages()
            ]);
        }
        $validator = $validator->validated();
        $product = Products::where('id', $id)->where("user_id", Auth::user()->id)->first();
        if (!$product) {
            return response()->json([
                "status" => "error",
                "message" => "product not found"
            ]);
        }
        $product->name = $validator['name'];
        $product->description = $validator['description'];
        $product->price = $validator['price'];
        if ($product->save()) {
            return response()->json([
                "status" => "success",
                "product" => $product,
                "message" => "The data is entered successfully"
            ]);
        }
        return response()->json([
            "status" => "error",
            "message" => "The data cannot be updated"
        ]);
    }

    function delete($id)
    {
        if ($product = Products::where('id', $id)->where("user_id", Auth::user()->id)->delete()) {
            return response()->json([
                "status" => "success",
                "message" => "Data is deleted successfully"
            ]);
        }
        return response()->json([
            "status" => "error",
            "message" => "Oh no Shit can't found the id to delete opppppppppssssssssss"
        ]);
    }
}
