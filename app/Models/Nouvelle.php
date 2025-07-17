<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nouvelle extends Model
{
    protected $fillable = [
        'titre', 'contenu', 'image', 'paroisse_id'
    ];
}
