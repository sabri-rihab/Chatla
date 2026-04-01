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
        Schema::create('nurseries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('phone'); // Changed from bigint to string for formatting
            $table->string('city');
            $table->string('address'); // Corrected spelling and type
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->string('website')->nullable();
            $table->unsignedTinyInteger('rating')->default(0); 
            $table->string('operating_hours')->nullable(); // Corrected spelling and type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurseries');
    }
};
