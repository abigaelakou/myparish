<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paroisse extends Model
{
    use HasFactory;
    protected $table = 'paroisses';

    protected $fillable = [
        'nom_paroisse',
        'adresse',
        'contact',
        'email',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
