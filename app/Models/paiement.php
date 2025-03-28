<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    use HasFactory;
    protected $table = 'paiements';

    protected $fillable = [
        'moyen_paiement',
        'montant',
        'contact',
        'id_demande',
        'paroisse_id',
    ];

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
