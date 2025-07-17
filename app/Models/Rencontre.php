<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencontre extends Model
{
    use HasFactory;
    protected $fillable = [
        'jour',
        'heure_debut',
        'heure_fin',
        'id_mouvement',
        'paroisse_id',
    ];


    public function mouvement()
    {
        return $this->belongsTo(Mouvement::class, 'id_mouvement');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
