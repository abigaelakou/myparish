<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembreMouvement extends Model
{
    use HasFactory;

    protected $table = 'membre_mouvements';

    protected $fillable = [
        'name_membre',
        'contact',
        'date_inscription',
        'role_membre',
        'id_mouvement',
    ];

    // Relation avec les tables
    public function Mouvement()
    {
        return $this->belongsTo(Mouvement::class, 'id_mouvement');
    }
}