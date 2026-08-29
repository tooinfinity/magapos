<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUser
{
    use HasFactory, HasRolesAndPermissions, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['image_path'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFirstNameAttribute(string $value): string
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute(string $value): string
    {
        return ucfirst($value);
    }

    public function getImagePathAttribute(): string
    {
        return asset('uploads/moderator_images/' . $this->image);
    }
}
