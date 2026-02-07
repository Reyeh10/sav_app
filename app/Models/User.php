<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ ajouté
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
            public function inspections()
                {
                    return $this->hasMany(Inspection::class, 'inspector_id');
                }

                public function approvedSavCases()
                {
                    return $this->hasMany(SavCase::class, 'approved_by');
                }

            public function isAdmin()
                {
                    return trim(strtolower($this->role)) === 'admin';
                }

            public function isVendeur()
                {
                    return trim(strtolower($this->role)) === 'vendeur';
                }

            public function isMecanicien()
                {
                    return trim(strtolower($this->role)) === 'mecanicien';
                }
            public function isLogistique()
                {
                    return $this->role === 'logistique';
                }

}
