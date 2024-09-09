<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    use HasFactory;

    protected $table = 'dons';

    protected $fillable = [
        'description',
        'date_don',
        'mode_paiement',
        'transaction_id',
        'payment_status',
        'contact',
        'montant',
        'type_donateur',
        'donateur_id',
        'id_type_don',

    ];

    // Relation avec les tables
    public function typeDon()
    {
        return $this->belongsTo(TypeDon::class, 'id_type_don');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'donateur_id');
    }
    public function Paroissien()
    {
        return $this->belongsTo(Paroissien::class, 'id_paroissien');
    }

    public function NonParoissien()
    {
        return $this->belongsTo(NonParoissien::class, 'id_non_paroissien');
    }
}
