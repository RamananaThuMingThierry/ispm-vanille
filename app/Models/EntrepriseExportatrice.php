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
        'pays',
        'adresse',
        'email',
        'telephone',
        'responsable',
        'description',
    ];
}
