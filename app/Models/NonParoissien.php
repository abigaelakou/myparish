<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonParoissien extends Model
{
    use HasFactory;

    protected $table = 'non_paroissiens';

    protected $fillable = [
        'name',
        'contact',
        'email',
        'sexe'
    ];


    //Relation entre les tables
    public function Dons()
    {
        return $this->hasMany(Don::class, 'id_non_paroissien');
    }
}