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
            if (!Schema::hasColumn('nurseries', 'profile_img')) {
                $table->string('profile_img')->nullable()->after('operating_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nurseries', function (Blueprint $table) {
            $table->dropColumn('profile_img');
        });
    }
};
