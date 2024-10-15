<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\json;

class DepensesController extends Controller
{
    //
    public function storeDepense(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date_depense' => 'required|date',
        ]);

        Depense::create($request->all());

        return redirect()->back()->with('success', 'Dépense enregistrée avec succès.');
    }

    public function listeDepensesMensuelles($mois = null, $annee = null)
    {
        $mois = ($mois === null || $mois == 'null') ? date('m') : $mois;
        $annee = ($annee === null || $annee == 'null') ? date('Y') : $annee;

        $depensesMensuelles = Depense::whereYear('date_depense', $annee)
            ->whereMonth('date_depense', $mois)
            ->get();

        return response()->json($depensesMensuelles);
    }


    public function listeToutesDepenses()
    {
        $toutesDepenses = Depense::all();

        return response()->json($toutesDepenses);
    }

    public function listeDepensesAnneeEnCours()
    {
        $currentYear = now()->year;
        $depensesAnneeEnCours = Depense::whereYear('date_depense', $currentYear)->get();

        return response()->json($depensesAnneeEnCours);
    }

    // Modification des information 
    public function update_depense(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_depense' => 'required|integer|exists:depenses,id',
            'modif_description' => 'required|string',
            'modif_date_depense' => 'required|date',
            'modif_montant' => 'required|',
        ]);

        // Mise à jour depense
        $modif_depense = Depense::find($request->id_depense);
        $modif_depense->description = $request->modif_description;
        $modif_depense->date_depense = $request->modif_date_depense;
        $modif_depense->montant = $request->modif_montant;
        $modif_depense->save();
        return response()->json(['success' => true, 'message' => 'Dépense mis à jour avec succès.']);
    }

    // Suppression depense
    public function supp_depense($id)
    {
        DB::table("depense")->where("id", $id)->delete();
        return true;
    }
}