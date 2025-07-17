<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceCatechese extends Model
{
    use HasFactory;

    protected $table = 'presences_catechese';

    protected $fillable = [
        'id_catechumene',
        'type_presence',
        'date_presence',
        'paroisse_id',
    ];

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
