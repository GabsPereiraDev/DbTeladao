<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function(){
    return [
        'pong'=>true
    ];
});


Route::post('/upload', function(Request $request){

    $array = ['error'=>''];


    if($request->hasFile('url')){
        if($request->file('url')->isValid()){
            
            $foto = $request->file('url')->store('public');

            $url = asset(Storage::url($foto));

            echo $url;

        }
    }else{
        $array ['error'] = 'Nao foi enviado arquivo.';
    }

    $name = $request->input('name');
    $description = $request->input('description');
    $category = $request->input('category');
    $sub_category = $request->input('sub_category');
    $code = $request->input('code');


    //criando registro

    $products = new product();

    $products->name = $name;
    $products->description =$description;
    $products->url = $url;
    $products->category = $category;
    $products->sub_category = $sub_category;
    $products->code = $code;

    $products->save();
    


    return $products;


});
