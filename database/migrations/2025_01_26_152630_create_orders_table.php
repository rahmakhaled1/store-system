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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("username")->nullable();
            $table->string("phone")->nullable();
            $table->foreignId("governorate_id")
                ->nullable()
                ->constrained("governorates")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string("code")->nullable();
            $table->string("total_before_delivery")->nullable();
            $table->string("total_after_delivery")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->longText("address")->nullable();
            $table->string("city")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
