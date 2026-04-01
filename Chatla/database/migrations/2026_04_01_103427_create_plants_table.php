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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('family_id')->constrained('plant_families')->onDelete('cascade');
            $table->text('about_description')->nullable();
            $table->string('light_need')->nullable();
            $table->string('watering')->nullable();
            $table->string('temperature')->nullable();
            $table->boolean('pet_friendly')->default(false);
            $table->string('sun_exposure')->nullable();
            $table->text('leaf_care')->nullable();
            $table->text('support_instructions')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
