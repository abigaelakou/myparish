<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'note',
        'id_catechumene',
        'id_classe'
    ];

    // Relation avec les tables
    public function Catechumene()
    {
        return $this->belongsTo(Catechumene::class, 'id_catechumene');
    }

    public function ClasseCatechese()
    {
        return $this->belongsTo(ClasseCatechese::class, 'id_classe');
    }
}