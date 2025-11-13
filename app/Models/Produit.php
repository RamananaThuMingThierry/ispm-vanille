<?php

namespace App\Models;

use App\Models\Marche;
use App\Models\Annonce;
use App\Models\FluxCommercial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';

    protected $fillable = [
        'nom',
        'unite'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function marches()        { return $this->hasMany(Marche::class); }
    public function fluxCommerciaux(){ return $this->hasMany(FluxCommercial::class); }
    public function annonces()       { return $this->hasMany(Annonce::class); }
}
