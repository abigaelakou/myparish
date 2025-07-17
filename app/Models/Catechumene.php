<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catechumene extends Model
{
    use HasFactory;

    protected $table = 'catechumenes';

    protected $fillable = [
        'name',
        'contact',
        'email',
        'nom_prenom_pere',
        'contact_pere',
        'nom_prenom_mere',
        'contact_mere',
        'nom_prenom_parain',
        'contact_parain',
        'sacrement_recu',
        'paroisse_id',
    ];

    //Relation entre les tables
    public function attestations()
    {
        return $this->hasMany(Attestation::class, 'id_catechumene');
    }

    public function Evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_catechumene');
    }
    public function inscription()
    {
        return $this->hasMany(Inscription::class, 'id_catechumene');
    }

    public function decisions()
    {
        return $this->hasMany(DecisionCatechese::class, 'id_catechumene');
    }

    public function presences()
    {
        return $this->hasMany(PresenceCatechese::class, 'id_catechumene');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
