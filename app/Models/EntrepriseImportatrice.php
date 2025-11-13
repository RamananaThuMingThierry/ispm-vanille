<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrepriseImportatrice extends Model
{
    use HasFactory;

    protected $table = 'entreprise_importatrices';

    protected $fillable = [
        'nom',
        'raison_sociale',
        'pays',
        'adresse',
        'email',
        'telephone',
        'responsable',
        'activite',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
