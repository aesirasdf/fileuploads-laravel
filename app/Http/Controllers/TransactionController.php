<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            "cart" => ["required", "array"],
            "cart.*" => ["required", "array"],
            "cart.*.id" => ["exists:products,id"],
            "cart.*.quantity" => ["integer", "min:1", "max:100"]
        ]);


        if ($validator->fails()){
            return response([
                "errors" => $validator->errors(),
                "ok" => false,
                "message" => "Request didn't pass the validation!"
            ], 400);
        }

        $transaction = Transaction::create();

        $validated = $request->all();
        $array = [];
        $products = Product::all();


        foreach($validated['cart'] as $product){
            $array[$product["id"]] = [
                "quantity" => $product["quantity"], 
                "price" => $products->find($product["id"])->price
            ];
        }

        $transaction->products()->sync($array);
        $transaction->products;

        return response([
            "data" => $transaction,
            "ok" => true,
            "message" => "Transaction success!"
        ], 201);
    }

    public function index(){
        $transactions = Transaction::with("products")->limit(5)->orderByDesc("id")->get();

        return response([
            "ok" => true,
            "data" => $transactions,
            "message" => "Transactions has been retrieved!"
        ]);
    }
}
