<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class EvenementController extends Controller
{
    public function store_evenement(Request $request)
    {
        $request->validate([
            'lib_evenement' => 'required|string',
            'date_evement' => 'required|date',
            'heure_evenement' => 'required|date_format:H:i',
            'description' => 'required|string',
        ]);

        // Création d'événement
        $evenement = new Evenement();
        $evenement->id_user = Auth::id();
        $evenement->lib_evenement = $request->lib_evenement;
        $evenement->date_evement = $request->date_evement;
        $evenement->heure_evenement = $request->heure_evenement;
        $evenement->description = $request->description;
        $evenement->paroisse_id = Auth::user()->paroisse_id; // Paroisse de l'utilisateur connecté
        $evenement->save();

        return redirect()->route('formEvenement')->with('success', 'Evenement créé avec succès.');
    }

    public function liste_des_evements()
    {
        $list_evenement = Evenement::with('user')
            ->where('paroisse_id', Auth::user()->paroisse_id)
            ->get();
        return $list_evenement;
    }

    public function liste_des_evenements_non_realises()
    {
        $evenements_non_realises = Evenement::with('user')
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->where(function ($query) {
                $query->where('date_evement', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->where('date_evement', '=', now()->toDateString())
                            ->where('heure_evenement', '>', now()->toTimeString());
                    });
            })
            ->get();

        return $evenements_non_realises;
    }

    public function update_evenement(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_evenement' => 'required|integer|exists:evenements,id',
            'modif_lib_evenement' => 'required|string',
            'modif_date_evement' => 'required|date',
            'modif_heure_evenement' => 'required|date_format:H:i',
            'modif_description' => 'required|string',
        ]);

        $modif_evenement = Evenement::where('id', $data['id_evenement'])
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->firstOrFail();

        // Mise à jour d'événement
        $modif_evenement->update([
            'lib_evenement' => $data['modif_lib_evenement'],
            'date_evement' => $data['modif_date_evement'],
            'heure_evenement' => $data['modif_heure_evenement'],
            'description' => $data['modif_description'],
            'paroisse_id' => auth()->user()->paroisse_id, // Paroisse de l'utilisateur connecté
        ]);

        return response()->json(['success' => true, 'message' => 'Evenement mis à jour avec succès.']);
    }

    // Suppression de evenement
    public function supp_evenement($id)
    {
        $deleted = DB::table("evenements")->where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Evenement supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}