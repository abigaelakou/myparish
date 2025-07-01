<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionCatechese extends Model
{
    use HasFactory;

    protected $table = 'decisions_catechese';

    protected $fillable = [
        'id_catechumene',
        'annee_catechetique',
        'moy_final',
        'total_presence_catechese',
        'total_presence_messes',
        'total_presence_ceb',
        'decision_finale',
        'paroisse_id',
    ];

    public function Catechumene()
    {
        return $this->belongsTo(Catechumene::class, 'id_catechumene');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
