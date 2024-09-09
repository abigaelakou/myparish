<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'status',
        'id_type_utilisateur',
    ];

    //Relation entre les tables

    public function TypeUtilisateur()
    {
        return $this->belongsTo(TypeUtilisateur::class, 'id_type_utilisateur');
    }

    public function archichages()
    {
        return $this->hasMany(Archivage::class, 'id_user');
    }

    public function ClasseCatecheses()
    {
        return $this->hasMany(ClasseCatechese::class, 'id_user');
    }

    public function Evenements()
    {
        return $this->hasMany(Evenement::class, 'id_user');
    }

    public function Inscriptions()
    {
        return $this->hasMany(Inscription::class, 'id_user');
    }
    public function Messes()
    {
        return $this->hasMany(Messe::class, 'id_user');
    }
    public function DemandeMesse()
    {
        return $this->hasMany(DemandeMesse::class, 'id_user');
    }

    public function paroissien()
    {
        return $this->hasOne(Paroissien::class);
    }

    public function non_paroissien()
    {
        return $this->hasOne(NonParoissien::class);
    }

    public function don()
    {
        return $this->hasMany(Don::class, 'donateur_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
