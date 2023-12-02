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
        Schema::create('apartments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->decimal('exchange_riel',8,2);
            $table->decimal('water_cost',8,2);
            $table->decimal('trash_cost',8,2);
            $table->decimal('wifi_cost',8,2)->nullable();
            $table->decimal('parking_cost',8,2)->nullable();
            $table->longText('address')->nullable();
            $table->longText('noted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
