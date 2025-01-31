<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("transaction_id");
            $table->decimal("price", 16, 2);
            $table->integer("quantity");

            $table->primary(["product_id", "transaction_id"]);
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
            $table->foreign("transaction_id")->references("id")->on("transactions")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transaction');
    }
};
