<?php

namespace App\Models;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marche extends Model
{
    use HasFactory;

    protected $table = 'marches';

    protected $fillable = [
        'date',
        'produit_id',
        'marche',
        'monnaie',
        'source',
        'prix',
        'disponibilite',
    ];

    protected $casts = [
        'date'          => 'date',
        'prix'          => 'decimal:2',
        'disponibilite' => 'integer',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}

