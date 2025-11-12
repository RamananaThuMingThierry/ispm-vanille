<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producteur extends Model
{
    use HasFactory;

    protected $table = 'producteurs';

    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'quantite',
        'telephone',
        'email',
        'fokontany',
        'commune',
        'district',
        'region',
    ];
}
