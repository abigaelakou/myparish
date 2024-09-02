<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messe extends Model
{
    use HasFactory;

    protected $table = 'messes';

    protected $fillable = [
        'date_messe',
        'heure_messe',
        'lieu_messe',
        'id_user',
        'id_type_messe',
        'id_celebrant'
    ];

    //Relation entre les tables

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function typeMesses()
    {
        return $this->belongsTo(TypeMesse::class, 'id_type_messe');
    }

    public function Celebrant()
    {
        return $this->belongsTo(User::class, 'id_celebrant');
    }

    public function demandeMesses()
    {
        return $this->hasMany(DemandeMesse::class, 'id_messe');
    }
}
