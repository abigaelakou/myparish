<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;
    protected $table = 'affectations';

    protected $fillable = [
        'date_affectation',
        'id_catechumene',
        'id_classe',
        'paroisse_id',
    ];


    public function classeCatechese()
    {
        return $this->belongsTo(User::class, 'id_classe');
    }
    public function catechumene()
    {
        return $this->belongsTo(User::class, 'id_catechumene');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
