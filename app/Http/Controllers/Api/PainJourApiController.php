<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PainJour;
use Illuminate\Support\Facades\Auth;

class PainJourApiController extends Controller
{
   public function painDuJourUtilisateur()
{
    $today = now()->toDateString();
    $user = Auth::user();

    $pain = PainJour::where('paroisse_id', $user->paroisse_id)
        ->where('date_pain', $today)
        ->first();

    if (!$pain) {
        return response()->json(['status' => false, 'message' => 'Aucun pain du jour publié aujourd’hui.']);
    }

    return response()->json(['status' => true, 'pain' => $pain]);
}

public function historiqueUtilisateur()
{
    $user = Auth::user();

    $pains = PainJour::where('paroisse_id', $user->paroisse_id)
        ->orderByDesc('date_pain')
        ->paginate(15);

    return response()->json(['status' => true, 'pains' => $pains]);
}

}
