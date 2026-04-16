<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nursery extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'city_id', 'name', 'phone', 'address', 
        'status', 'website', 'rating', 'operating_hours', 'profile_img', 'latitude', 'longitude'
    ];

    // ─── Relationships ────────────────────────────────────────────────

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function inventory()
    {
        return $this->hasMany(NurseryInventory::class);
    }

    public function plants()
    {
        return $this->belongsToMany(Plant::class, 'nursery_inventories')
                    ->withPivot('stock_quantity', 'growth_status')
                    ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(NurseryRating::class);
    }
}
