<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlantFamily extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // ─── Relationships ────────────────────────────────────────────────

    /** A plant family has many plants */
    public function plants()
    {
        return $this->hasMany(Plant::class, 'family_id');
    }
}
