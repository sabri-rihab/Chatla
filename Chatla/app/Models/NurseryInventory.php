<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NurseryInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursery_id',
        'plant_id',
        'stock_status',
        'growth_status',
        'quantity',         // logical quantity in stock (integer >= 0)
        'price',            // optional price in MAD
        'custom_description', // nursery-specific description override
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'float',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    /** The nursery that holds this inventory entry */
    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }

    /** The plant species of this inventory entry */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    /** Images attached to this specific inventory entry */
    public function images()
    {
        return $this->hasMany(InventoryImage::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────

    /** Filter by nursery */
    public function scopeForNursery($query, int $nurseryId)
    {
        return $query->where('nursery_id', $nurseryId);
    }

    /** Filter by growth status */
    public function scopeByGrowth($query, string $growth)
    {
        return $query->where('growth_status', $growth);
    }
}
