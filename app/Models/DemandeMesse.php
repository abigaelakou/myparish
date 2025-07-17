<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeMesse extends Model
{
    use HasFactory;

    protected $table = 'demande_messes';

    protected $fillable = [
        'id_user',
        'id_type_messe',
        'id_type_intention',
        'date_messe',
        'heure_messe',
        'lieu_messe',
        'intentions',
        'paroisse_id',
    ];


    // Relation avec les tables
    public function messe()
    {
        return $this->belongsTo(Messe::class, 'id_messe');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function typeIntention()
    {
        return $this->belongsTo(TypeIntention::class, 'id_type_intention');
    }

    public function typeMesse()
    {
        return $this->belongsTo(TypeMesse::class, 'id_type_messe');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
    
}
