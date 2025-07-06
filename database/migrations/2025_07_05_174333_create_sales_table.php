<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->decimal('total', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('payment_method');
            $table->string('status', 20)->default('completed');
            $table->boolean('active')->default(true);

            $table->bigInteger('user_created')->unsigned()->index()->nullable();
            $table->bigInteger('user_updated')->unsigned()->index()->nullable();
            $table->foreign('user_created')->references('id')->on('users')->onDelete('no action');
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('no action');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
