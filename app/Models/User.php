<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'must_change_password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'must_change_password' => 'boolean',
    ];

    /*
    =================================
    ROLE HELPERS
    =================================
    */

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isLogistique()
    {
        return $this->role === 'logistique';
    }

    public function isMecanicien()
    {
        return $this->role === 'mecanicien';
    }

    public function isVendeur()
    {
        return $this->role === 'vendeur';
    }
}
