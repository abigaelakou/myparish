<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;


    protected $table = 'inscriptions';

    protected $fillable = [
        'annee_catechetique',
        'montant',
        'date_inscription',
        'id_catechumene',
        'id_user',
        'id_classe'
    ];

    // Relation avec les tables
    public function Catechumene()
    {
        return $this->belongsTo(Catechumene::class, 'id_catechumene');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ClasseCatechese()
    {
        return $this->belongsTo(ClasseCatechese::class, 'id_classe');
    }
}