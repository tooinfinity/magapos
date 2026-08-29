<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('codebar');
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('image')->default('product.png');
            $table->double('purchase_price', 8, 2);
            $table->double('sale_price', 8, 2);
            $table->integer('min_stock');
            $table->integer('stock');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
