<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeMesse extends Model
{
    use HasFactory;

    protected $table = 'demande_messes';

    protected $fillable = [
        'intention',
        'montant',
        'id_messe',
        'id_paroissien'
    ];


    // Relation avec les tables
    public function Messe()
    {
        return $this->belongsTo(Messe::class, 'id_messe');
    }

    public function Paroissien()
    {
        return $this->belongsTo(Paroissien::class, 'id_paroissien');
    }
}