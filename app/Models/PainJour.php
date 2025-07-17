<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PainJour extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'date_pain',
        'paroisse_id',
        'id_user'
    ];


    public function auteur()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

  
    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class, 'paroisse_id');
    }
}

