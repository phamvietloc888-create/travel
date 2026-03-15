<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'phone',
        'address',
        'birthday',
        'avatar',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * 👉 Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * 👉 Lịch sử đặt tour của user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function reviews()
{
    return $this->hasMany(\App\Models\Review::class);
}

}
