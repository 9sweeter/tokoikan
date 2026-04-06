<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is petugas (staff)
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    // Check if user is regular user
    public function isUser()
    {
        return $this->role === 'user';
    }

    // Relationships
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}