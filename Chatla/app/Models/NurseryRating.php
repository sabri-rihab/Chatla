<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseryRating extends Model
{
    protected $fillable = [
        'nursery_id',
        'user_id',
        'rate',
    ];


    // Get the nursery that was rated.

    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }

    
    // Get the user who made the rating.
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

