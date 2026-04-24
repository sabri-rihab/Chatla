<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // ─── Role constants ───────────────────────────────────────────────
    const ROLE_SIMPLE        = 'simple';
    const ROLE_NURSERY_OWNER = 'nursery_owner';
    const ROLE_ADMIN         = 'admin';

    // ─── Status constants ─────────────────────────────────────────────
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_PENDING  = 'pending';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'profile_img',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    /** A nursery_owner user owns one nursery */
    public function nursery()
    {
        return $this->hasOne(Nursery::class, 'owner_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isNurseryOwner(): bool
    {
        return $this->role === self::ROLE_NURSERY_OWNER;
    }

    // ─── Casts ────────────────────────────────────────────────────────

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
