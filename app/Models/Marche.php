<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marche extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'produit',
        'prix',
        'disponibilite',
    ];

    protected $casts = [
        'date' => 'date',
        'prix' => 'decimal:2',
    ];
}
