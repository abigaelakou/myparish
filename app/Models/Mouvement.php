<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    use HasFactory;

    protected $table = 'mouvements';

    protected $fillable = [
        'lib_mouvement',
        'date_creation',
        'description'
    ];

    //Relation entre les tables
    public function MembreMouvements()
    {
        return $this->hasMany(MembreMouvement::class, 'id_mouvement');
    }

    public function rencontres()
    {
        return $this->hasMany(Rencontre::class, 'id_mouvement');
    }
}
