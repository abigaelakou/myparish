<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'source_id',
        'source_type',
        'transaction_id',
        'paroisse_id',
        'montant',
        'status',
        'date',
        'paiement_id',
    ];


     public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }

    public function don()
    {
        return $this->belongsTo(Don::class, 'source_id')->where('source_type', 'don');
    }

    
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

}
