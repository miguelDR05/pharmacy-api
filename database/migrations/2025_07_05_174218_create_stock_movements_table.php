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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->enum('type', ['IN', 'OUT', 'ADJ']);
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();

            $table->bigInteger('user_created')->unsigned()->index()->nullable();
            $table->bigInteger('user_updated')->unsigned()->index()->nullable();

            $table->foreign('user_created')->references('id')->on('users')->onDelete('no action');
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
