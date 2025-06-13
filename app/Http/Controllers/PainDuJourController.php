<?php

namespace App\Http\Controllers;

use App\Models\PainJour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PainDuJourController extends Controller
{
    //
    public function store_pain_jour(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'date_pain' => 'required|date',
            'contenu' => 'required|string',
        ]);
        $date = $request->date_pain;
        $paroisseId = Auth::user()->paroisse_id;

        $dejaPublie = PainJour::where('paroisse_id', $paroisseId)
            ->where('date_pain', $date)
            ->first();

        if ($dejaPublie) {
            return redirect()->back()->withErrors(['Un pain du jour a déjà été publié pour cette date.']);
        }

        // Création de pain
        $pain_jour = new PainJour();
        $pain_jour->id_user = Auth::id();
        $pain_jour->titre = $request->titre;
        $pain_jour->date_pain = $request->date_pain;
        $pain_jour->contenu = $request->contenu;
        $pain_jour->paroisse_id = Auth::user()->paroisse_id; // Paroisse de l'utilisateur connecté
        $pain_jour->est_auto = false; // bien préciser que ce n'est pas automatique
        $pain_jour->save();

        return redirect()->route('formPainJour')->with('success', 'Pain Du jour créé et envoyé avec succès.');
    }

    public function formPainJour(Request $request)
    {
        $today = now()->toDateString();
        $paroisseId = Auth::user()->paroisse_id;

        $painAujourdhui = PainJour::where('paroisse_id', $paroisseId)
            ->where('date_pain', $today)
            ->first();

       $query = PainJour::where('paroisse_id', $paroisseId);
        // Filtrage par date si elle est envoyée depuis la requête
        if ($request->filled('filtre_date')) {
            $query->where('date_pain', $request->filtre_date);
        }
        $pains = $query->orderByDesc('date_pain')->paginate(10); // 10 par page
        return view('Espaces.PainDuJour.formPainJour', compact('painAujourdhui', 'pains'));
    }

    public function remplacer_pain_auto($id)
    {
        $pain = PainJour::findOrFail($id);

        if (!$pain->est_auto) {
            return back()->with('error', 'Ce message n’est pas automatique.');
        }

        return view('Espaces.PainDuJour.remplacer', compact('pain'));
    }

    public function remplacer_pain_auto_action(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string',
            'contenu' => 'required|string',
        ]);

        $pain = PainJour::findOrFail($id);

        if (!$pain->est_auto) {
            return redirect()->route('formPainJour')->with('error', 'Ce message n’est pas automatique.');
        }

        $pain->titre = $request->titre;
        $pain->contenu = $request->contenu;
        $pain->est_auto = false; // Désormais, c’est un message manuel
        $pain->id_user = Auth::id();
        $pain->save();

        return redirect()->route('formPainJour')->with('success', 'Le message a été remplacé avec succès.');
    }

    public function vueUtilisateurPainDuJour(Request $request)
    {
        $user = Auth::user();
        $paroisseId = $user->paroisse_id;

        $today = now()->toDateString();
        $painAujourdhui = PainJour::where('paroisse_id', $paroisseId)
            ->where('date_pain', $today)
            ->first();

        $query = PainJour::where('paroisse_id', $paroisseId)
            ->orderByDesc('date_pain');

        if ($request->filled('date')) {
            $query->whereDate('date_pain', $request->input('date'));
        }
        $pains = $query->paginate(10);
        return view('Espaces.PainDuJour.pain_du_jour', compact('painAujourdhui', 'pains'));
    }


}
