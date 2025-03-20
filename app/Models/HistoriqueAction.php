<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'paroisse_id',
        'user_id',
        'action',
        'details',
    ];

    // Relations
    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
