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
            $table->foreignId("product_id")->nullable()
                ->constrained("products")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId("order_id")->nullable()
                ->constrained("orders")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer("quantity")->nullable()->default(1);
            $table->string("price")->nullable()->default(null);
            $table->timestamps();
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
