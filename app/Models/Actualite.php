<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Actualite extends Model
{
    use HasFactory;

    protected $table = 'actualites';

    protected $fillable = [
        'titre',
        'slug',
        'contenu',
        'image',
        'statut',
        'publie_le',
        'ala_une',
        'auteur_id',
    ];

    protected $casts = [
        'publie_le' => 'datetime',
        'ala_une'   => 'boolean',
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    protected static function booted()
    {
        static::creating(function ($actualite) {
            if (empty($actualite->slug)) {
                $actualite->slug = Str::slug($actualite->titre . '-' . uniqid());
            }
            if ($actualite->statut === 'publie' && empty($actualite->publie_le)) {
                $actualite->publie_le = now();
            }
        });
    }
}
