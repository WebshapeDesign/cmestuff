<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('van_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('week_start_date');
            $table->string('oil_level_action');
            $table->string('oil_level_signed');
            $table->string('water_level_action');
            $table->string('water_level_signed');
            $table->string('tyres_action');
            $table->string('tyres_signed');
            $table->string('screen_action');
            $table->string('screen_signed');
            $table->text('vehicle_defects')->nullable();
            $table->json('van_items_check')->nullable();
            $table->json('ppe_check')->nullable();
            $table->boolean('is_checked')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->boolean('is_late')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('van_logs');
    }
}; 