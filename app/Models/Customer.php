<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{

     use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'type_client',
        'address'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function proformas(): HasMany
    {
        return $this->hasMany(Proforma::class);
    }

}
