<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('week_commencing'); // The selected Sunday date
            $table->json('entries');          // Stores daily hours and site/job numbers
            $table->decimal('materials', 10, 2)->nullable();
            $table->decimal('others', 10, 2)->nullable();
            $table->decimal('total_expenses', 10, 2)->nullable();
            $table->timestamps();              // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
