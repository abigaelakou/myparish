<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCatechese extends Model
{
    use HasFactory;

    protected $table = 'session_catecheses';

    protected $fillable = [
        'lib_session_catechese'
    ];
}
