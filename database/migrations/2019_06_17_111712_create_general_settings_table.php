<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name');
            $table->string('activity');
            $table->string('phone');
            $table->string('address');
            $table->date('start_day');
            $table->string('image');
            $table->double('investment_capital');
            $table->string('rc')->nullable();
            $table->string('article')->nullable();
            $table->string('nif')->nullable();
            $table->string('nis')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
