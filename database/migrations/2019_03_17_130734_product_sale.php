<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sale', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->string('quantity');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('sale_id');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sale');
    }
};
