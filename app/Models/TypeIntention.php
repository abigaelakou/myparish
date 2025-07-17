<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIntention extends Model
{
    use HasFactory;

    protected $table = 'type_intentions';

    protected $fillable = [
        'lib_type_intention',
        'paroisse_id',
    ];


    public function demandeMesse()
    {
        return $this->hasMany(DemandeMesse::class, 'id_type_intention');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
