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
        Schema::table('nurseries', function (Blueprint $table) {
            // Latitude ranges from -90 to 90. 10 total digits, 8 after the decimal.
            $table->decimal('latitude', 10, 8)->nullable();
            
            // Longitude ranges from -180 to 180. 11 total digits, 8 after the decimal.
            $table->decimal('longitude', 11, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nursaries', function (Blueprint $table) {
            //
        });
    }
};
