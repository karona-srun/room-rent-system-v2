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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('apartment_id')->nullable();
            $table->boolean('is_paid');
            $table->boolean('is_screenshot');
            $table->string('telegram_message')->nullable();
            $table->string('telegram_message_at')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_date');
            $table->string('room_rent_id');
            $table->double('room_cost');
            $table->double('electric_cost');
            $table->bigInteger('water_old_number')->nullable();
            $table->bigInteger('water_new_number')->nullable();
            $table->double('water_cost')->nullable();
            $table->double('trash_cost')->nullable();
            $table->longText('other')->nullable();
            $table->string('sub_total_amount');
            $table->string('total_amount');
            $table->string('user_id')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
