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
        Schema::create('nursery_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nursery_id')->constrained('nurseries')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rate')->comment('Rating between 1 and 5');
            $table->timestamps();

            // A user can only rate a nursery once
            $table->unique(['nursery_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursery_ratings');
    }
};
