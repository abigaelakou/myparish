<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParoisseKycDocument extends Model
{
    protected $table = 'paroisse_kyc_documents';

    protected $fillable = [
        'paroisse_id',
        'type_document',
        'chemin_fichier',
    ];

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
