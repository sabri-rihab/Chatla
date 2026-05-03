<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NurseryInventory extends Model
{
    use HasFactory;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($inventory) {
            $plant = \App\Models\Plant::find($inventory->plant_id);
            $nursery = \App\Models\Nursery::find($inventory->nursery_id);
            
            if ($plant && $nursery) {
                $baseSlug = \Illuminate\Support\Str::slug($plant->name . ' at ' . $nursery->name);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $inventory->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'nursery_id',
        'plant_id',
        'slug',
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

    /**
     * Get the display image for the frontend.
     * Logic:
     * 1. Check for custom nursery uploaded inventory image.
     * 2. Fallback to plant's primary default image.
     * 3. Fallback to a generic placeholder.
     */
    public function getDisplayImageAttribute()
    {
        $firstImage = $this->images->first();
        if ($firstImage) {
            $path = $firstImage->image_path;
            if (str_starts_with($path, 'http')) {
                return $path;
            }
            if (str_starts_with($path, '/storage/')) {
                return asset($path);
            }
            return asset('storage/' . $path);
        }

        if ($this->plant) {
            $defaultImage = $this->plant->defaultImages->firstWhere('is_primary', true) ?? $this->plant->defaultImages->firstWhere('is_primary', 1);
            if ($defaultImage) {
                $path = $defaultImage->image_path;
                return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
            }
        }

        return 'https://images.unsplash.com/photo-1599599810694-d5c4d7e4c0f5?auto=format&fit=crop&q=80';
    }
}
