<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;


    protected $table = 'inscriptions';

    protected $fillable = [
        'annee_catechetique',
        'date_inscription',
        'id_catechumene',
        'id_user',
        'id_niveau',
        'id_session',
        'paroisse_id',
    ];

    // Relation avec les tables
    public function catechumene()
    {
        return $this->belongsTo(Catechumene::class, 'id_catechumene');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function sessionCatechese()
    {
        return $this->belongsTo(SessionCatechese::class, 'id_session');
    }

    public function niveauCatechetique()
    {
        return $this->belongsTo(NiveauCatechetique::class, 'id_niveau');
    }

    public function paiements()
    {
        return $this->hasMany(PaiementCatechese::class, 'id_inscription');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }

    public function niveau()
    {
        return $this->belongsTo(NiveauCatechetique::class, 'id_niveau');
    }

    public function session()
    {
        return $this->belongsTo(SessionCatechese::class, 'id_session');
    }

    public function paiement()
    {
        return $this->hasOne(PaiementCatechese::class, 'id_inscription');
    }


}
