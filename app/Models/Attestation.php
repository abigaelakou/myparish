<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    use HasFactory;

    protected $table = 'attestations';

    protected $fillable = [
        'contenu',
        'date_delivre',
        'id_catechumene',
        'paroisse_id',
    ];

    // Relation avec la table catechumene
    public function catechumene()
    {
        return $this->belongsTo(Catechumene::class, 'id_catechumene');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
