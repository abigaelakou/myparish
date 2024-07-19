<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUtilisateur extends Model
{
    use HasFactory;

    protected $table = 'type_utilisateurs';

    protected $fillable = [
        'lib_type_utilisateur',
    ];

    public function users()
    {
        return $this->hasMany(user::class, 'id_type_utilisateur');
    }
}