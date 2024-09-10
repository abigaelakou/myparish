<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;


    protected $table = 'evenements';

    protected $fillable = [
        'lib_evenement',
        'date_evement',
        'heure_evenement',
        'id_user',
        'description'
    ];


    // Relation avec les tables
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
