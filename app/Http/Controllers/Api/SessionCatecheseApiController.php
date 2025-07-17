<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\SessionCatechese;

class SessionCatecheseApiController extends Controller
{

    public function index()
    {
        $sessions = SessionCatechese::all();
        return response()->json($sessions);
    }

}
