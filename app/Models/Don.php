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
        'valeur',
        'date_don',
        'id_type_don',
        'id_paroissien',
        'id_non_paroissien'

    ];

    // Relation avec les tables
    public function TypeDon()
    {
        return $this->belongsTo(TypeDon::class, 'id_type_don');
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