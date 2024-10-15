<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveauCatechetique extends Model
{
    use HasFactory;


    protected $table = 'niveau_catechetiques';

    protected $fillable = [
        'lib_niveau',
    ];

    //Relation entre les tables


    public function classeCatecheses()
    {
        return $this->hasMany(ClasseCatechese::class, 'id_niveau');
    }
}