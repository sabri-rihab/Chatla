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
            $table->string('slug')->nullable()->unique()->after('id');
        });

        // Populate existing records
        $inventories = \App\Models\NurseryInventory::with(['plant', 'nursery'])->get();
        foreach ($inventories as $inventory) {
            $baseSlug = \Illuminate\Support\Str::slug($inventory->plant->name . ' at ' . $inventory->nursery->name);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\NurseryInventory::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $inventory->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nursery_inventories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
