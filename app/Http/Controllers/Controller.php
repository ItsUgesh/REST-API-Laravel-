<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Route;

abstract class Controller
{
    function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if($validation->fails()){
            return response()->json([
                "status"=>"error",
                "message"=> $validation->messages()
            ]);
        }
        $product = new Products();
        $product->name = $request->input('name');
        $product->user_id = Auth::user()->id; //$product->user_id = request()->user()->id;
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        if ($product->save()) {
            return response()->json([
                "status" => "success",
                "product" => $product,
                "message" => "Product created successfully"
            ]);
        }
        return response()->json([
            "status"=> "error",
            "message"=> "product cannot be created"
        ]);
    }
}

