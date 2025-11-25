<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diocese extends Model
{
    protected $fillable = [
        'nom',
        'pays_id',
    ];

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function paroisses()
    {
        return $this->hasMany(Paroisse::class);
    }
}