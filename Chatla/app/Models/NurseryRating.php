<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseryRating extends Model
{
    protected $fillable = ['user_id', 'nursery_id', 'rate'];

    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
