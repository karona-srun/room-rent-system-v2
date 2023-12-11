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
            $table->double('exchange_riel',8);
            $table->double('water_cost',8);
            $table->double('trash_cost',8);
            $table->double('wifi_cost',8)->nullable();
            $table->double('parking_cost',8)->nullable();
            $table->longText('address')->nullable();
            $table->longText('noted')->nullable();
            $table->longText('terms_and_conditions')->nullable();
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
