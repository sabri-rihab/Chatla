<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'name',
        'email',
        'request_type',
        'subject',
        'message',
        'status',
    ];

    /**
     * Get enum values for request_type from the database schema.
     */
    public static function getRequestTypes()
    {
        return [
            'Bug/Error',
            'false information',
            'feature request',
            'missing content',
            'other'
        ];
    }
}
