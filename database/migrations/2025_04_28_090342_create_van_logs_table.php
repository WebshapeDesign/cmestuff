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
        Schema::create('van_logs', function (Blueprint $table) {
            $table->id();
            
            // Link to Vehicle and User
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Mileage snapshot
            $table->integer('vehicle_mileage')->nullable();

            // Action fields + Signatures
            $table->string('oil_level_action')->nullable();
            $table->string('oil_level_signed')->nullable();
            $table->string('water_level_action')->nullable();
            $table->string('water_level_signed')->nullable();
            $table->string('tyres_action')->nullable();
            $table->string('tyres_signed')->nullable();
            $table->string('screen_action')->nullable();
            $table->string('screen_signed')->nullable();

            // General vehicle defects
            $table->text('vehicle_defects')->nullable();

            // Table-style sections
            $table->json('van_items_check')->nullable(); // Ladder/Steps, Vacuum, Tools, Fire Extinguisher
            $table->json('ppe_check')->nullable();       // First Aid Kit, Fire Extinguisher, etc

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('van_logs');
    }
};
