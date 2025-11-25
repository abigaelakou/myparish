<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paroisse extends Model
{
    use HasFactory;
    protected $table = 'paroisses';

    protected $fillable = [
        'nom_paroisse',
        'adresse',
        'contact',
        'email',
        'status',
        'diocese_id',
    ];

       protected $casts = [
        'status' => 'integer',
        'diocese_id' => 'integer',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function paroisse()
    {
        return $this->belongsTo(Paroisse::class, 'paroisse_id');
    }

    
    public function diocese()
    {
        return $this->belongsTo(Diocese::class);
    }

      /**
     * Scope pour récupérer uniquement les paroisses actives
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Accessor pour vérifier si la paroisse est active
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 1;
    }
}