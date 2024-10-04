<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementCatechese extends Model
{
    use HasFactory;


    protected $table = 'paiements_catechese';
    protected $casts = [
        'id_inscription' => 'integer',
    ];

    protected $fillable = [
        'id_inscription',
        'montant',
        'mode_paiement',
        'transaction_id',
        'payment_status',
        'date_paiement',
        'contact',
    ];

    // Relation entre les tables
    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'id_inscription');
    }
}