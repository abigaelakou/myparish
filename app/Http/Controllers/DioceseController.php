<?php

namespace App\Http\Controllers;

use App\Models\Diocese;
use App\Models\Pays;
use App\Models\HistoriqueAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DioceseController extends Controller
{
    // Liste des dioceses
    public function index()
    {
        $dioceses = Diocese::with('pays')->orderBy('nom')->get();
        return $dioceses;
    }

    // Récupérer les diocèses d’un pays
    public function byPays($paysId)
    {
        $dioceses = Diocese::where('pays_id', $paysId)->orderBy('nom')->get();
        return $dioceses;
    }

    // Créer un diocèse
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'      => 'required|string|max:255|unique:dioceses,nom',
            'pays_id'  => 'required|integer|exists:pays,id',
        ]);

        $diocese = Diocese::create($data);

        HistoriqueAction::create([
            'user_id' => auth()->id(),
            'action' => 'Création de diocèse',
            'details' => 'Diocèse : ' . $diocese->nom,
        ]);

        return redirect()->back()->with('success', 'Diocèse créé avec succès.');
    }

    // Modifier un diocèse
    public function update(Request $request, $id)
    {
        $diocese = Diocese::findOrFail($id);

        $data = $request->validate([
            'nom'      => 'required|string|max:255|unique:dioceses,nom,' . $diocese->id,
            'pays_id'  => 'required|integer|exists:pays,id',
        ]);

        $diocese->update($data);

        HistoriqueAction::create([
            'user_id' => auth()->id(),
            'action' => 'Modification diocèse',
            'details' => 'Diocèse : ' . $diocese->nom,
        ]);

        return response()->json(['success' => true, 'message' => 'Diocèse mis à jour avec succès.']);
    }

    // Supprimer diocèse (optionnel)
    public function destroy($id)
    {
        Diocese::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Diocèse supprimé.']);
    }
}