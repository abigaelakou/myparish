<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMesse extends Model
{
    use HasFactory;

    protected $table = 'type_messes';

    protected $fillable = [
        'lib_type_messe',
        'paroisse_id',
    ];

    public function messe()
    {
        return $this->hasMany(Messe::class, 'id_type_messe');
    }

    public function demandeMesses()
    {
        return $this->hasMany(DemandeMesse::class, 'id_type_messe');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
