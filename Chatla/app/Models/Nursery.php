<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nursery extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'name', 'phone', 'city', 'address', 
        'status', 'website', 'rating', 'operating_hours'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function inventory()
    {
        return $this->hasMany(NurseryInventory::class);
    }
}
