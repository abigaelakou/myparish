<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecuPaiement extends Model
{
    use HasFactory;

    protected $table = 'recu_paiements';

    protected $fillable = [
        'id_paiement',
        'nom_prenom',
        'montant',
        'contact',
        'date_paiement',
        'paroisse_id',
    ];

    public function paiement()
    {
        return $this->belongsTo(PaiementCatechese::class, 'id_paiement');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
