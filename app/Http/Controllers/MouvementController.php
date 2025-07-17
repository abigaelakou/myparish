<?php

namespace App\Http\Controllers;

use App\Models\MembreMouvement;
use App\Models\Mouvement;
use App\Models\Rencontre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MouvementController extends Controller
{
    //
    public function create_mouvement(Request $request)
    {
        $data = $request->validate([
            'lib_mouvement' => 'required|string|max:255',
            'description' => 'required|string',
            'date_creation' => 'required|string',
            'rencontres' => 'required|array',
            'rencontres.*.jour' => 'required|string',
            'rencontres.*.heure_debut' => 'required|date_format:H:i',
            'rencontres.*.heure_fin' => 'required|date_format:H:i|after:rencontres.*.heure_debut',
        ]);

        $mouvement = Mouvement::create([
            'lib_mouvement' => $data['lib_mouvement'],
            'description' => $data['description'],
            'date_creation' => $data['date_creation'],
            'paroisse_id' => auth()->user()->paroisse_id
        ]);

        foreach ($data['rencontres'] as $rencontre) {
            $rencontre['id_mouvement'] = $mouvement->id;
            Rencontre::create($rencontre);
        }

        return redirect()->route('formAddMouvement')->with('success', 'Mouvement créé avec succès');
    }

    // Liste des rencontres avec leurs mouvements associés, limitée à la paroisse de l'utilisateur
    public function liste_des_rencontres_mouvement()
    {
        $liste_rencontre_mouv = DB::table('rencontres')
            ->join('mouvements', 'rencontres.id_mouvement', '=', 'mouvements.id')
            ->join('paroisses', 'mouvements.paroisse_id', '=', 'paroisses.id')
            ->where('mouvements.paroisse_id', auth()->user()->paroisse_id)
            ->select('rencontres.*', 'mouvements.lib_mouvement', 'mouvements.date_creation', 'mouvements.description', 'paroisses.nom_paroisse')
            ->get();

        return $liste_rencontre_mouv;
    }

    // Modification des informations de rencontre
    public function update_rencontre(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_mouvement' => 'required|integer|exists:mouvements,id',
            'id_rencontre' => 'required|integer|exists:rencontres,id',
            'lib_mouvement' => 'required|string|max:255',
            'description' => 'required|string',
            'date_creation' => 'required|string',
            'rencontres' => 'required|array',
            'rencontres.*.jour' => 'required|string',
            'rencontres.*.heure_debut' => 'required|date_format:H:i',
            'rencontres.*.heure_fin' => 'required|date_format:H:i|after:rencontres.*.heure_debut',
        ]);

        // Vérification que le mouvement appartient bien à la paroisse de l'utilisateur connecté
        $mouvement = Mouvement::where('id', $data['id_mouvement'])
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->firstOrFail();

        // Mise à jour des informations du mouvement
        $mouvement->update([
            'lib_mouvement' => $data['lib_mouvement'],
            'description' => $data['description'],
            'date_creation' => $data['date_creation'],
        ]);

        // Suppression des anciennes rencontres
        Rencontre::where('id_mouvement', $mouvement->id)->delete();

        // Ajout des nouvelles rencontres
        foreach ($data['rencontres'] as $rencontre) {
            $rencontre['id_mouvement'] = $mouvement->id;
            Rencontre::create($rencontre);
        }

        return response()->json(['success' => true, 'message' => 'Mouvement mis à jour avec succès.']);
    }


    //****************************PARTIR MEMBRE DES MOUVEMENTS*************************** */
    public function create()
    {
        $mouvements = DB::table('mouvements')
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->orderBy('lib_mouvement')
            ->get();
        return view('Espaces.Admin.formAddMembreMouvement', compact('mouvements'));
    }

    public function showEditMembreModal()
    {
        $mouvements = DB::table('mouvements')
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->orderBy('lib_mouvement')
            ->get();
        return view('Espaces.Admin.listeMembreMouv', compact('mouvements'));
    }

    // Création de membre de mouvement
    public function create_membre_mouv(Request $request)
    {
        $data = $request->validate([
            'name_membre' => 'required|string|max:255',
            'contact' => 'required|string|max:15|unique:membre_mouvements',
            'date_inscription' => 'required|string',
            'role_membre' => 'required|string|in:MEMBRE SIMPLE,RESPONSABLE,MEMBRE BUREAU',
            'id_mouvement' => 'required|integer|exists:mouvements,id',
        ]);

        $membre_mouvement = MembreMouvement::create([
            'name_membre' => $data['name_membre'],
            'contact' => $data['contact'],
            'date_inscription' => $data['date_inscription'],
            'role_membre' => $data['role_membre'],
            'id_mouvement' => $data['id_mouvement'],
            'paroisse_id' => auth()->user()->paroisse_id
        ]);

        return redirect()->route('formAddMembreMouvement')->with('success', 'Nouveau membre ajouté au mouvement avec succès.');
    }

    // Liste des membres des mouvements
    public function list_membre_mouv()
    {
        $liste_membre_mouv = DB::table('membre_mouvements')
            ->join('mouvements', 'membre_mouvements.id_mouvement', '=', 'mouvements.id')
            ->join('paroisses', 'membre_mouvements.paroisse_id', '=', 'paroisses.id')
            ->where('membre_mouvements.paroisse_id', auth()->user()->paroisse_id)
            ->select('membre_mouvements.*', 'mouvements.lib_mouvement', 'paroisses.nom_paroisse')
            ->get();

        return $liste_membre_mouv;
    }

    // Modification des membres de mouvement
    public function update_membre_mouv(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_membre_mouvement' => 'required|integer|exists:membre_mouvements,id',
            'modif_name_membre' => 'required|string|max:255',
            'modif_contact' => 'required|string|max:15|unique:membre_mouvements,contact,' . $request->id_membre_mouvement,
            'modif_date_inscription' => 'required|string',
            'modif_role_membre' => 'required|string|in:MEMBRE SIMPLE,RESPONSABLE,MEMBRE BUREAU',
            'modif_id_mouvement' => 'required|integer|exists:mouvements,id',
        ]);

        $modif_membre = MembreMouvement::where('id', $data['id_membre_mouvement'])
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->firstOrFail();

        // Mise à jour des informations du membre de mouvement
        $modif_membre->update([
            'name_membre' => $data['modif_name_membre'],
            'contact' => $data['modif_contact'],
            'date_inscription' => $data['modif_date_inscription'],
            'role_membre' => $data['modif_role_membre'],
            'id_mouvement' => $data['modif_id_mouvement'],
        ]);

        return response()->json(['success' => true, 'message' => 'Membre mis à jour avec succès.']);
    }

    // suppression de membre
    public function supp_membre($id)
    {
        $deleted = DB::table("membre_mouvements")->where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Un membre supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}