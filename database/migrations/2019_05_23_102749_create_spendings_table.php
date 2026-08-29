<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spending_name');
            $table->string('spending_description');
            $table->double('spending_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spendings');
    }
};
