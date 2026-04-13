<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DefaultPlantImage extends Model
{
    use HasFactory;

    protected $fillable = ['plant_id', 'image_path', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
