<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDon extends Model
{
    use HasFactory;


    protected $table = 'type_dons';

    protected $fillable = [
        'lib_type_don',
        'paroisse_id',
    ];

    //Relation entre les tables
    public function don()
    {
        return $this->hasMany(Don::class, 'id_type_don');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
