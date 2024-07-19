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
    ];

    //Relation entre les tables

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function demandeMesses()
    {
        return $this->hasMany(DemandeMesse::class, 'id_messe');
    }
}