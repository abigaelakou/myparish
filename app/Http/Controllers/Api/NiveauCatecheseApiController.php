<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\NiveauCatechetique;

class NiveauCatecheseApiController extends Controller
{
    public function index()
    {
        $niveaux = NiveauCatechetique::all();
        return response()->json($niveaux);
    }

}
