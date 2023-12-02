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
        Schema::create('room_rents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('room_id')->nullable();
            $table->double('price');
            $table->string('user_id')->nullable();
            $table->string('apartment_id')->nullable();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('telegram_id')->nullable();
            $table->longText('address')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_back')->nullable();
            $table->longText('noted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_rents');
    }
};
