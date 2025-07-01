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
            'paroisse_id' => 'required|exists:paroisses,id',
        ]);

        Depense::create($request->all());

        return redirect()->back()->with('success', 'Dépense enregistrée avec succès.');
    }

    public function listeDepensesMensuelles($mois = null, $annee = null)
    {
        $mois = $mois ?? date('m');
        $annee = $annee ?? date('Y');
        $paroisseId = auth()->user()->paroisse_id;

        $depensesMensuelles = Depense::whereYear('date_depense', $annee)
            ->where('paroisse_id', $paroisseId)
            ->whereMonth('date_depense', $mois)
            ->get();

        return response()->json($depensesMensuelles);
    }


    public function listeToutesDepenses()
    {
        $paroisseId = auth()->user()->paroisse_id;
        $toutesDepenses = Depense::where('paroisse_id', $paroisseId)->get();

        return response()->json($toutesDepenses);
    }

    public function listeDepensesAnneeEnCours()
    {
        $currentYear = now()->year;
        $paroisseId = auth()->user()->paroisse_id;

        $depensesAnneeEnCours = Depense::whereYear('date_depense', $currentYear)
            ->where('paroisse_id', $paroisseId)
            ->get();

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
            'modif_montant' => 'required|numeric',
            'modif_paroisse_id' => 'required|exists:paroisses,id',
        ]);

        $modif_depense = Depense::find($data['id_depense']);
        $modif_depense->update([
            'description' => $data['modif_description'],
            'date_depense' => $data['modif_date_depense'],
            'montant' => $data['modif_montant'],
            'paroisse_id' => $data['modif_paroisse_id']
        ]);

        return response()->json(['success' => true, 'message' => 'Dépense mise à jour avec succès.']);
    }


    // Suppression depense
    public function supp_depense($id)
    {

        $deleted = DB::table("depenses")
            ->where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérifier l'accès
            ->delete();


        if ($deleted) {
            return response()->json(['success' => 'Dépense supprimée avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}