<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $casts = [
        'birthdate' => 'date'
    ];

    public function User(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
