<?php

use App\Http\Controllers\CRUDController;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::any("/user/register", function () {
    $faker = Faker\Factory::create();

    $user = new User();

    $user->name = $faker->name;
    $user->email = $faker->unique()->safeEmail;
    $user->password = Hash::make("passowrd");
    if($user -> save()){
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json(["success"=>"success","data"=> $user,"token"=>$token,"message"=>"The data is entried.💖"]);
    }
    return response()->json(["success"=>"failed","message"=>"Error! When saving your data."]);
});
//create
Route::prefix("product")->middleware("auth:sanctum")->group(function(){

Route::post("create",[CRUDController::class, 'create']);
//read
Route::post("read",[CRUDController::class, 'read']);
//uodate
Route::post("update/{id}",[CRUDController::class,'update']);
//delete
Route::post("delete/{id}",[CRUDController::class,'delete']);
});
