<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nursery;

class City extends Model
{
    protected $fillable = ['name'];

    public function nurseries()
    {
        return $this->hasMany(Nursery::class);
    }
}
