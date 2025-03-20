<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonParoissien extends Model
{
    use HasFactory;

    protected $table = 'non_paroissiens';

    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'email',
        'sexe',
        'paroisse_id',
    ];


    //Relation entre les tables
    public function Dons()
    {
        return $this->hasMany(Don::class, 'id_non_paroissien');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
