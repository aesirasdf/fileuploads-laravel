<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator = validator($request->all(), [
            "name" => "required|max:255|string",
            "price" => "required|numeric|min:1|max:1000000",
            "description" => "required|string",
            "category_id" => "required|exists:categories,id",
            "image" => "sometimes|image|mimes:jpg,jpeg,png"
        ]);

        if($validator->fails()){
            return response([
                "errors" => $validator->errors(),
                "message" => "Request didn't pass the validation!",
                "ok" => false
            ], 400);
        }

        $product = Product::create($validator->validated());
        if(isset($validator->validated()["image"])){
            $image = $request->file("image");
            $extension = $request->file("image")->getClientOriginalExtension();
            Storage::disk("public")->putFileAs("uploads", $image , "$product->id.$extension");

            $product->extension = $extension;
            $product->save();
        }

        return response([
            "data" => $product,
            "message" => "Product has been created!",
            "ok" => true
        ], 201);
    }

    public function index(Request $request){
        return response([
            "data" => Product::all(),
            "message" => "Products has been retrieved!",
            "ok" => true
        ]);
    }
}
