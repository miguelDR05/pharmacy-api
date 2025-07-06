<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('status', 20)->default('active');

            $table->bigInteger('user_created')->unsigned()->index()->nullable();
            $table->bigInteger('user_updated')->unsigned()->index()->nullable();


            $table->foreign('user_created')->references('id')->on('users')->onDelete('no action');
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('no action');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
