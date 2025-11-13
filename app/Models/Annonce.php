<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;

class Annonce extends Model
{
    use HasFactory;

    protected $table = 'annonces';

    protected $fillable = [
        'categorie',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'commune',
        'district',
        'region',
        'contact',
    ];

    protected $casts = [
        'quantite'      => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
    ];

    protected $appends = ['prix_formatted'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function getPrixFormattedAttribute(): string
    {
        if ($this->prix_unitaire === null) {
            return '';
        }

        return number_format($this->prix_unitaire, 2, ',', ' ') . ' MGA';
    }
}
