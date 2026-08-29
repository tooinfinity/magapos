<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_name');
            $table->string('phone');
            $table->string('address');
            $table->string('description')->nullable();
            $table->string('rc')->nullable();
            $table->string('article')->nullable();
            $table->string('nif')->nullable();
            $table->string('nis')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
