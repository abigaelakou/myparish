<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Api\NotificationController;

class AnnonceController extends Controller
{
    public function store_annonce(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'contenu' => 'required|string',
        ]);

        // Création d'événement
        $annonce = new Annonce();
        $annonce->id_user = Auth::id();
        $annonce->titre = $request->titre;
        $annonce->contenu = $request->contenu;
        $annonce->paroisse_id = Auth::user()->paroisse_id; // Paroisse de l'utilisateur connecté
        $annonce->save();
        // Envoyer la notification
        app(NotificationController::class)->notifyNewAnnonce($annonce->id);
    
        return redirect()->route('formEvenement')->with('success', 'Annonce créé avec succès.');
    }

    public function liste_des_annonces()
    {
        $list_annonce = Annonce::with('user')
            ->where('paroisse_id', Auth::user()->paroisse_id)
            ->get();
        return $list_annonce;
    }


    public function update_annonce(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_annonce'=> 'required|integer|exists:annonces,id',
            'modif_titre' => 'required|string',
            'modif_contenu' => 'required|string',
        ]);

        $modif_annonce = Annonce::where('id', $data['id_annonce'])
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->firstOrFail();

        // Mise à jour d'événement
        $modif_annonce->update([
            'titre' => $data['modif_titre'],
            'contenu' => $data['modif_description'],
            'paroisse_id' => auth()->user()->paroisse_id, // Paroisse de l'utilisateur connecté
        ]);

        return response()->json(['success' => true, 'message' => 'Annonce mis à jour avec succès.']);
    }

    // Suppression d'annonce
    public function supp_annonce($id)
    {
        $deleted = DB::table("annonces")->where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Annonce supprimée avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}