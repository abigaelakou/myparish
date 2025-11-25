<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\HistoriqueAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaysController extends Controller
{
    // Liste des pays
    public function index()
    {
        $pays = Pays::orderBy('nom')->get();
        return $pays;
    }

    // Formulaire création : si tu en utilises un
    public function create()
    {
        return view('pays.create');
    }

    // Ajout d’un pays
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'  => 'required|string|max:255|unique:pays,nom',
            'code' => 'nullable|string|max:5',
        ]);

        $pays = Pays::create($data);

        HistoriqueAction::create([
            'user_id' => auth()->id(),
            'action' => 'Création de pays',
            'details' => 'Pays : ' . $pays->nom,
        ]);

        return redirect()->back()->with('success', 'Pays ajouté avec succès.');
    }

    // Modifier un pays
    public function update(Request $request, $id)
    {
        $pays = Pays::findOrFail($id);

        $data = $request->validate([
            'nom'  => 'required|string|max:255|unique:pays,nom,' . $pays->id,
            'code' => 'nullable|string|max:5',
        ]);

        $pays->update($data);

        HistoriqueAction::create([
            'user_id' => auth()->id(),
            'action' => 'Modification pays',
            'details' => 'Pays : ' . $pays->nom,
        ]);

        return response()->json(['success' => true, 'message' => 'Pays mis à jour avec succès.']);
    }

    // Supprimer un pays (optionnel)
    public function destroy($id)
    {
        $pays = Pays::findOrFail($id);

        $pays->delete();

        return response()->json(['success' => true, 'message' => 'Pays supprimé.']);
    }
}