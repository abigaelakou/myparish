<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureBiblique extends Model
{
    use HasFactory;
    protected $fillable = [
    'titre',            // Ex : "Lecture de la lettre de saint Paul"
    'contenu',          // Texte complet de la lecture
    'reference',        // Ex : "1 Co 13, 1-13"
    'date_lecture',     // Date prévue de la lecture
    'paroisse_id'       // Pour filtrer selon la paroisse
];

}
