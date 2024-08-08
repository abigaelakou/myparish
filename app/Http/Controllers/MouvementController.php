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
    public function store(Request $request)
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
        ]);


        foreach ($data['rencontres'] as $rencontre) {
            $rencontre['id_mouvement'] = $mouvement->id;
            Rencontre::create($rencontre);
        }

        return redirect()->route('formAddMouvement')->with('success', 'Mouvement créé avec succès');
    }

    // Liste des mouvements avec leur jours de renconcontres
    public function liste_des_rencontres_mouvement()
    {
        $liste_rencontre_mouv = DB::table('rencontres')
            ->join('mouvements', 'rencontres.id_mouvement', '=', 'mouvements.id')
            ->select('rencontres.*', 'mouvements.lib_mouvement', 'mouvements.date_creation', 'mouvements.description')
            ->get();
        return $liste_rencontre_mouv;
    }

    public function edit_rencontre_mouv($id)
    {
        $mouvement = Mouvement::with('rencontres')->findOrFail($id);
        return $mouvement;
    }

    // Modification des information 
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

        // Mettre à jour les informations du mouvement
        $mouvement = Mouvement::findOrFail($data['id_mouvement']);
        $mouvement->update([
            'lib_mouvement' => $data['lib_mouvement'],
            'description' => $data['description'],
            'date_creation' => $data['date_creation'],
        ]);

        // Supprimer les anciennes rencontres
        Rencontre::where('id_mouvement', $mouvement->id)->delete();

        // Ajouter les nouvelles rencontres
        foreach ($data['rencontres'] as $rencontre) {
            $rencontre['id_mouvement'] = $mouvement->id;
            Rencontre::create($rencontre);
        }

        return response()->json(['success' => true, 'message' => 'Mouvement mis à jour avec succès.']);
    }


    //****************************PARTIR MEMBRE DES MOUVEMENTS*************************** */
    public function create()
    {
        $mouvements = DB::table('mouvements')->orderBy('lib_mouvement')->get();
        // dd($mouvements);
        return view('Espaces.Admin.formAddMembreMouvement', compact('mouvements'));
    }

    public function showEditMembreModal()
    {
        $mouvements = DB::table('mouvements')->orderBy('lib_mouvement')->get();
        return view('Espaces.Admin.listeMembreMouv', compact('mouvements'));
    }

    // creation de membre de mouvement
    public function create_membre_mouv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_membre' => 'required|string|max:255',
            'contact' => 'required|string|max:15|unique:membre_mouvements',
            'date_inscription' => 'required|string|',
            'role_membre' => 'required|string|in:MEMBRE SIMPLE,RESPONSABLE,MEMBRE BUREAU',
            'id_mouvement' => 'required|integer|exists:mouvements,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $membre_mouvement = new MembreMouvement();
        $membre_mouvement->name_membre = $request->name_membre;
        $membre_mouvement->contact = $request->contact;
        $membre_mouvement->date_inscription = $request->date_inscription;
        $membre_mouvement->role_membre = $request->role_membre;
        $membre_mouvement->id_mouvement = $request->id_mouvement;
        $membre_mouvement->save();

        return redirect()->route('formAddMembreMouvement')->with('success', 'Nouveau membre ajouté au mouvement avec succès.');
    }
    // Liste des membres des mouvements
    public function list_membre_mouv()
    {
        $liste_membre_mouv = DB::table('membre_mouvements')
            ->join('mouvements', 'membre_mouvements.id_mouvement', '=', 'mouvements.id')
            ->select('membre_mouvements.*', 'mouvements.lib_mouvement')
            ->get();
        return $liste_membre_mouv;
    }

    // Modification des membres mouvement
    public function update_membre_mouv(Request $request)
    {
        Log::info($request->all());

        $validator = $request->validate([
            'id_membre_mouvement' => 'required|integer|exists:membre_mouvements,id',
            'modif_name_membre' => 'required|string|max:255',
            'modif_contact' => 'required|string|max:255|unique:membre_mouvements,contact,' . $request->id_membre_mouvement,
            'modif_date_inscription' => 'required|string|',
            'modif_role_membre' => 'required|string|in:MEMBRE SIMPLE,RESPONSABLE,MEMBRE BUREAU',
            'modif_id_mouvement' => 'required|integer|exists:mouvements,id',
        ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        $modif_membre = MembreMouvement::find($request->id_membre_mouvement);
        $modif_membre->name_membre = $request->modif_name_membre;
        $modif_membre->contact = $request->modif_contact;
        $modif_membre->date_inscription = $request->modif_date_inscription;
        $modif_membre->role_membre = $request->modif_role_membre;
        $modif_membre->id_mouvement = $request->modif_id_mouvement;
        $modif_membre->save();
        return true;
    }
    // suppression de membre
    public function supp_membre($id)
    {
        DB::table("membre_mouvements")->where("id", $id)->delete();
        return true;
    }
}
