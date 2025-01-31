<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

route::get("categories", [CategoryController::class, "index"]);
route::get("products", [ProductController::class, "index"]);
route::post("products", [ProductController::class, "store"]);
route::post("transactions", [TransactionController::class, "store"]);
route::get("transactions", [TransactionController::class, "index"]);