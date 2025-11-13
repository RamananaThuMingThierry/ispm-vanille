<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrepriseExportatrice extends Model
{
    use HasFactory;

    protected $table = 'entreprise_exportatrices';

    protected $fillable = [
        'nom',
        'raison_sociale',
        'pays',
        'adresse',
        'responsable',
        'email',
        'telephone',
        'activite',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
