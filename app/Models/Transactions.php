<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'paiement_id',
        'transaction_id',
        'date',
        'paroisse_id',
    ];

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
