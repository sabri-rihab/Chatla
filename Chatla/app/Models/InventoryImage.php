<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryImage extends Model
{
    use HasFactory;

    protected $fillable = ['nursery_inventory_id', 'image_path'];

    // ─── Relationships ────────────────────────────────────────────────

    public function inventoryEntry()
    {
        return $this->belongsTo(NurseryInventory::class, 'nursery_inventory_id');
    }
}
