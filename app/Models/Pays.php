<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $fillable = [
        'nom',
        'code',
    ];

    public function dioceses()
    {
        return $this->hasMany(Diocese::class);
    }
}