<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;

class FluxCommercial extends Model
{
    use HasFactory;

    protected $table = 'flux_commercials';

    protected $fillable = [
        'type',
        'produit_id',
        'annee',
        'quantite',
        'valeur',
    ];

    protected $casts = [
        'annee'     => 'integer',
        'quantite'  => 'decimal:2',
        'valeur'    => 'decimal:2',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
