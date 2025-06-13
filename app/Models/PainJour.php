<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PainJour extends Model
{
    use HasFactory;
    protected $fillable = [
    'titre',         // Titre du message (facultatif ou inspirant)
    'contenu',       // Texte du pain du jour (méditation, exhortation…)
    'date_pain',     // Date du jour correspondant
    'paroisse_id',   // Pour que chaque paroisse ait ses propres pains
    'id_user'
];

}
