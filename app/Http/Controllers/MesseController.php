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
            'date_messe' => 'required|date',
            'heure_messe' => 'required|date_format:H:i',
            'lieu_messe' => 'required|string',
            'id_type_messe' => 'required|integer|exists:type_messes,id',
            'id_celebrant' => 'required|integer|exists:users,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $messe = new Messe();
        $messe->date_messe = $request->date_messe;
        $messe->heure_messe = $request->heure_messe;
        $messe->lieu_messe = $request->lieu_messe;
        $messe->id_user = Auth::id(); // Celui qui a crée la messe
        $messe->id_type_messe = $request->id_type_messe;
        $messe->id_celebrant = $request->id_celebrant; //le celebrant de la messe
        // dd($request->all());
        $messe->save();
        // Envoi de la notification au célébrant
        $celebrant = User::find($request->id_celebrant);
        if ($celebrant) {
            // Envoyer l'email avec l'objet Messe et le célébrant
            Mail::to($celebrant->email)->send(new MesseCreated($messe, $celebrant));
        }
        return redirect()->route('formMesse')->with('success', 'Messe créé avec succès.');
    }

    // liste des messes
    public function liste_toutes_les_messes()
    {
        $liste_toutes_messes = DB::table('messes')
            ->join('users as creator', 'messes.id_user', '=', 'creator.id') // Utilisateur qui a créé la messe
            ->join('users as celebrant', 'messes.id_celebrant', '=', 'celebrant.id') // Utilisateur assigné pour célébrer la messe
            ->join('type_messes', 'messes.id_type_messe', '=', 'type_messes.id')
            ->select(
                'messes.*',
                'creator.name as creator_name',
                'celebrant.name as celebrant_name',
                'type_messes.lib_type_messe'
            )
            ->get();
        return $liste_toutes_messes;
    }

    //liste des messes du celebrant connecté (je vais afficher sur son tableau de bord)

    function liste_des_messes_du_celebrant()
    {
        $liste_toutes_messes_celebrant = DB::table('messes')
            ->where('id_celebrant', Auth::id())
            ->join('users as creator', 'messes.id_user', '=', 'creator.id') // Utilisateur qui a créé la messe
            ->join('users as celebrant', 'messes.id_celebrant', '=', 'celebrant.id') // Utilisateur assigné pour célébrer la messe
            ->join('type_messes', 'messes.id_type_messe', '=', 'type_messes.id')
            ->select(
                'messes.*',
                'creator.name as creator_name',
                'celebrant.name as celebrant_name',
                'type_messes.lib_type_messe'
            )
            ->get();

        return $liste_toutes_messes_celebrant;
    }

    // Modification des information 
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
        ]);
        // Mise à jour de messe
        $modif_messe = Messe::find($request->id_messe);
        $modif_messe->date_messe = $request->modif_date_messe;
        $modif_messe->heure_messe = $request->modif_heure_messe;
        $modif_messe->lieu_messe = $request->modif_lieu_messe;
        $modif_messe->id_type_messe = $request->modif_id_type_messe;
        $modif_messe->id_celebrant = $request->modif_id_celebrant;
        $modif_messe->save();
        return true;
    }

    // Suppression de messe
    public function supp_messe($id)
    {
        DB::table("messes")->where("id", $id)->delete();
        return true;
    }
}
