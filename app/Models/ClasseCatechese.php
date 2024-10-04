<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseCatechese extends Model
{
    use HasFactory;
    protected $table = 'classe_catecheses';

    protected $fillable = [
        'lib_classe_cate',
        'id_niveau',
        'id_session',
        'id_user'
    ];

    // Relation avec les tables


    public function niveau()
    {
        return $this->belongsTo(NiveauCatechetique::class, 'id_niveau');
    }

    public function session()
    {
        return $this->belongsTo(SessionCatechese::class, 'id_session');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function Evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_classe');
    }

    public function Inscriptions()
    {
        return $this->hasMany(Inscription::class, 'id_classe');
    }
}