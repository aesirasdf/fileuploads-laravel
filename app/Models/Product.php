<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        "name",
        "description",
        "extension",
        "price",
        "category_id",
        "barcode"
    ];

    public function transactions(){
        return $this->belongsToMany(Transaction::class)->withPivot(["price", "quantity"]);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
