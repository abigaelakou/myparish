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
    //
    public function store_evenement(Request $request)
    {
        $request->validate([
            'lib_evenement' => 'required|string',
            'date_evement' => 'required|date',
            'heure_evenement' => 'required|date_format:H:i',
            'description' => 'required|string',

        ]);
        // Création d'évenement
        $evenement = new Evenement();
        $evenement->id_user = Auth::id();
        $evenement->lib_evenement = $request->lib_evenement;
        $evenement->date_evement = $request->date_evement;
        $evenement->heure_evenement = $request->heure_evenement;
        $evenement->description = $request->description;
        $evenement->save();
        return redirect()->route('formEvenement')->with('success', 'Evenement créé avec succès.');
    }

    public function liste_des_evements()
    {
        // Récupérer tous les évenements
        $list_evenement = Evenement::with('user')->get();
        return $list_evenement;
    }

    public function liste_des_evenements_non_realises()
    {
        // Récupérer les événements dont la date et l'heure sont supérieures à la date actuelle (événements futurs)
        $evenements_non_realises = Evenement::with('user')
            ->where('date_evement', '>', now()->toDateString())
            ->orWhere(function ($query) {
                $query->where('date_evement', '=', now()->toDateString())
                    ->where('heure_evenement', '>', now()->toTimeString());
            })
            ->get();

        return $evenements_non_realises;
    }


    // Modification des information 
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

        // Mise à jour d'evenement
        $modif_evenement = Evenement::find($request->id_evenement);
        $modif_evenement->lib_evenement = $request->modif_lib_evenement;
        $modif_evenement->date_evement = $request->modif_date_evement;
        $modif_evenement->heure_evenement = $request->modif_heure_evenement;
        $modif_evenement->description = $request->modif_description;
        $modif_evenement->save();
        return response()->json(['success' => true, 'message' => 'Evenement mis à jour avec succès.']);
    }

    // Suppression de evenement
    public function supp_evenement($id)
    {
        DB::table("evenements")->where("id", $id)->delete();
        return true;
    }
}
