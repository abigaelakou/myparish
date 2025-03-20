<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;
    protected $table = 'depenses';
    protected $fillable = ['description', 'montant', 'date_depense', 'paroisse_id',];

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
