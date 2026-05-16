<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_STAFF = 'staff';
    public const ROLE_SUPER_ADMIN = 'super-admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function borrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }

    public function reviewedBorrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class, 'reviewed_by');
    }

    public function createdItems(): HasMany
    {
        return $this->hasMany(Item::class, 'created_by');
    }

    public function updatedItems(): HasMany
    {
        return $this->hasMany(Item::class, 'updated_by');
    }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles, true);
    }

    public function isRegularUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function canAccessAdminDashboard(): bool
    {
        return $this->hasRole([self::ROLE_STAFF, self::ROLE_SUPER_ADMIN]);
    }
}
