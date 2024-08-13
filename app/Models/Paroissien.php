<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paroissien extends Model
{
    use HasFactory;

    protected $table = 'paroissiens';

    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'email',
        'sexe',
        'situation_matrimoniale',
        'date_naiss',
        'date_inscription',
        'sacrement_recu'
    ];
    //Relation entre les tables
    public function demandeMesses()
    {
        return $this->hasMany(DemandeMesse::class, 'id_paroissien');
    }

    public function Dons()
    {
        return $this->hasMany(Don::class, 'id_paroissien');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}