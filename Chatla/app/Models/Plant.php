<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'family_id',
        'about_description',
        'light_need',
        'watering',
        'temperature',
        'pet_friendly',
        'sun_exposure',
        'leaf_care',
        'support_instructions',
    ];

    protected $casts = [
        'pet_friendly' => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    /** Plant belongs to a PlantFamily */
    public function family()
    {
        return $this->belongsTo(PlantFamily::class, 'family_id');
    }

    /** Plant has many default (generic) images */
    public function defaultImages()
    {
        return $this->hasMany(DefaultPlantImage::class);
    }

    /** Plant appears in many nursery inventories */
    public function inventories()
    {
        return $this->hasMany(NurseryInventory::class);
    }

    /** Nurseries carrying this plant (via pivot) */
    public function nurseries()
    {
        return $this->belongsToMany(Nursery::class, 'nursery_inventories')
            ->withPivot('stock_quantity', 'growth_status')
            ->withTimestamps();
        ;
    }
}
