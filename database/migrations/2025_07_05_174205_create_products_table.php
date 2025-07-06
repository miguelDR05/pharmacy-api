<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->integer('stock')->default(0);
            $table->boolean('active')->default(true);
            $table->string('status', 20)->default('available');

            $table->bigInteger('user_created')->unsigned()->index()->nullable();
            $table->bigInteger('user_updated')->unsigned()->index()->nullable();


            $table->foreign('user_created')->references('id')->on('users')->onDelete('no action');
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('no action');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
