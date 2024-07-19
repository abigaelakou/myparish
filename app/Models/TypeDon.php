<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDon extends Model
{
    use HasFactory;


    protected $table = 'type_dons';

    protected $fillable = [
        'lib_type_don',
    ];

    //Relation entre les tables
    public function Dons()
    {
        return $this->hasMany(Don::class, 'id_type_don');
    }
}