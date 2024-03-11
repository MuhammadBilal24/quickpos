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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pcode')->nullable();
            $table->string('barcode')->nullable();
            $table->string('pname');
            $table->string('category');
            $table->string('pimg')->nullable();
            $table->string('cprice')->nullable();
            $table->string('rprice')->nullable();
            $table->string('wprice')->nullable();
            $table->string('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
