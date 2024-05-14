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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('zip_order');
            $table->string('fullName');
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('orderNote')->nullable();
            $table->string('phone')->nullable();
            $table->integer('total');
            $table->integer('quantity');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('status');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
