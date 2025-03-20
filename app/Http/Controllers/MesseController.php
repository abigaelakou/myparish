<?php

namespace App\Http\Controllers;

use App\Mail\MesseCreated;
use App\Models\Messe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MesseController extends Controller
{

    public function create_messe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_messe' => 'required|date|after_or_equal:today',
            'heure_messe' => 'required|date_format:H:i',
            'lieu_messe' => 'required|string',
            'id_type_messe' => 'required|integer|exists:type_messes,id',
            'id_celebrant' => 'required|integer|exists:users,id',
            'paroisse_id' => 'required|exists:paroisses,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $messe = new Messe();
        $messe->date_messe = $request->date_messe;
        $messe->heure_messe = $request->heure_messe;
        $messe->lieu_messe = $request->lieu_messe;
        $messe->id_user = auth()->id(); // Celui qui a crée la messe
        $messe->id_type_messe = $request->id_type_messe;
        $messe->id_celebrant = $request->id_celebrant; //le celebrant de la messe
        $messe->paroisse_id = Auth::user()->paroisse_id; // Paroisse de l'utilisateur connecté

        // dd($request->all());
        $messe->save();
        // Envoi de la notification au célébrant
        $celebrant = User::find($request->id_celebrant);
        if ($celebrant) {
            try {
                Mail::to($celebrant->email)->send(new MesseCreated($messe, $celebrant));
            } catch (\Exception $e) {
                return redirect()->route('formMesse')->with('error', 'Messe créée mais l\'envoi de l\'email a échoué.');
            }
        }
        return redirect()->route('formMesse')->with('success', 'Messe créée avec succès.');
    }

    // liste des messes
    public function liste_toutes_les_messes()
    {
        $liste_toutes_messes = DB::table('messes')
            ->join('users as creator', 'messes.id_user', '=', 'creator.id') // Utilisateur qui a créé la messe
            ->join('users as celebrant', 'messes.id_celebrant', '=', 'celebrant.id') // Utilisateur assigné pour célébrer la messe
            ->join('type_messes', 'messes.id_type_messe', '=', 'type_messes.id')
            ->join('paroisses', 'messes.paroisse_id', '=', 'paroisses.id')
            ->select(
                'messes.*',
                'creator.name as creator_name',
                'celebrant.name as celebrant_name',
                'type_messes.lib_type_messe',
                'paroisses.nom_paroisse'
            )
            ->get();

        return $liste_toutes_messes;
    }

    // Liste des messes pour le célébrant connecté
    public function liste_des_messes_du_celebrant()
    {
        $liste_toutes_messes_celebrant = DB::table('messes')
            ->where('id_celebrant', auth()->id())
            ->join('users as creator', 'messes.id_user', '=', 'creator.id') // Utilisateur qui a créé la messe
            ->join('type_messes', 'messes.id_type_messe', '=', 'type_messes.id')
            ->join('paroisses', 'messes.paroisse_id', '=', 'paroisses.id')
            ->select(
                'messes.*',
                'creator.name as creator_name',
                'celebrant.name as celebrant_name',
                'type_messes.lib_type_messe',
                'paroisses.nom_paroisse'
            )
            ->get();

        return $liste_toutes_messes_celebrant;
    }

    // Modification des informations de messe
    public function update_messe(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_messe' => 'required|integer|exists:messes,id',
            'modif_date_messe' => 'required|date',
            'modif_heure_messe' => 'required|date_format:H:i',
            'modif_lieu_messe' => 'required|string',
            'modif_id_type_messe' => 'required|integer|exists:type_messes,id',
            'modif_id_celebrant' => 'required|integer|exists:users,id',
            'modif_paroisse_id' => 'required|exists:paroisses,id',
        ]);

        $modif_messe = Messe::where('id', $data['id_messe'])
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->firstOrFail();

        $modif_messe->update([
            'date_messe' => $data['modif_date_messe'],
            'heure_messe' => $data['modif_heure_messe'],
            'lieu_messe' => $data['modif_lieu_messe'],
            'id_type_messe' => $data['modif_id_type_messe'],
            'id_celebrant' => $data['modif_id_celebrant'],
            'paroisse_id' => $data['modif_paroisse_id'],
        ]);

        return response()->json(['success' => true, 'message' => 'Messe mise à jour avec succès.']);
    }


    // Suppression de messe
    public function supp_messe($id)
    {
        $deleted = DB::table("messes")->where('id', $id)
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'Type intention supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Suppression échouée ou non autorisée.'], 403);
        }
    }
}