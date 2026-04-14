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
        Schema::table('nursery_inventories', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('growth_status');
            $table->integer('quantity')->default(0)->after('price');
            $table->text('custom_description')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nursery_inventories', function (Blueprint $table) {
            $table->dropColumn(['price', 'quantity', 'custom_description']);
        });
    }
};
