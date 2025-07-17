<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivage extends Model
{
    use HasFactory;
    protected $table = 'archivages';

    protected $fillable = [
        'lib_document',
        'date_archivage',
        'fichier',
        'id_user',
        'paroisse_id',
    ];

    // Relation avec la table users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }
}
