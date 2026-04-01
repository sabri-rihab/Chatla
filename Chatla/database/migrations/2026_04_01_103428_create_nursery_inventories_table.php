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
        Schema::create('nursery_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nursery_id')->constrained()->onDelete('cascade');
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->integer('stock_quantity')->default(0);
            $table->enum('growth_status', ['seed', 'seedling', 'vegetative', 'mature']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursery_inventories');
    }
};
