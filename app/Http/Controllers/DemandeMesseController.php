<?php

namespace App\Http\Controllers;

use App\Models\DemandeMesse;
use App\Models\TypeMesse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PDF;
use PhpOffice\PhpWord\PhpWord;


class DemandeMesseController extends Controller
{
    public function formPaiement(Request $request)
    {
        // Récupérer l'ID de la demande depuis la requête
        $demandeId = $request->query('id_demande');
        // Trouver la demande de messe correspondante
        $demande = DemandeMesse::findOrFail($demandeId);

        // Passer la demande à la vue
        return view('Espaces.Messe.formPaiement', compact('demande'));
    }

    public function store_demande_messe(Request $request)
    {
        $request->validate([
            'id_type_messe' => 'required|exists:type_messes,id',
            'id_type_intention' => 'required|exists:type_intentions,id',
            'date_messe' => 'required|date',
            'heure_messe' => 'required|date_format:H:i',
            'lieu_messe' => 'required|string',
            'intentions' => 'nullable|string',
        ]);
        // Création de la demande de messe
        $demande = new DemandeMesse();
        $demande->id_user = Auth::id();
        $demande->id_type_messe = $request->id_type_messe;
        $demande->id_type_intention = $request->id_type_intention;
        $demande->date_messe = $request->date_messe;
        $demande->heure_messe = $request->heure_messe;
        $demande->lieu_messe = $request->lieu_messe;
        $demande->intentions = $request->intentions;
        $demande->save();

        // Redirection vers la page de paiement
        return redirect()->route('formPaiement', ['id_demande' => $demande->id]);
    }

    public function liste_demande_messe()
    {
        // Récupérer toutes les demandes de messe
        $demandes = DemandeMesse::with('user', 'typeMesse', 'typeIntention')->get();
        return $demandes;
    }

    public function mesDemandesMesses()
    {
        // Récupère les demandes de messe associées à cet utilisateur
        $demandeMesses = DemandeMesse::with(['typeMesse', 'typeIntention'])
            ->where('id_user', Auth::id())->get();
        // dd($demandeMesses);

        return response()->json($demandeMesses);
    }

    // Modification des information 
    public function update_demande_messe(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_demande_messe' => 'required|integer|exists:demande_messes,id',
            'intention' => 'required|required',
            'montant' => 'required|numeric',
            'status' => 'required|string',
            'recu' => 'nullable|string',
            'date_demande' => 'required|date',
            'id_type_intention' => 'required|exists:type_intentions,id',
            'id_messe' => 'required|exists:messes,id',
            'id_user' => 'required|exists:users,id',
        ]);

        // Mise à jour de demande messe
        $modif_demande_messe = DemandeMesse::find($request->id_demande_messe);
        $modif_demande_messe->intention = $request->modif_intention;
        $modif_demande_messe->montant = $request->modif_montant;
        $modif_demande_messe->status = $request->modif_status;
        $modif_demande_messe->recu = $request->modif_recu;
        $modif_demande_messe->date_demande = $request->modif_date_demande;
        $modif_demande_messe->id_type_intention = $request->modif_id_type_intention;
        $modif_demande_messe->id_messe = $request->modif_id_messe;
        $modif_demande_messe->id_user = $request->modif_id_user;
        $modif_demande_messe->save();
        return true;

        return response()->json(['success' => true, 'message' => 'Demande Messe mis à jour avec succès.']);
    }

    // Suppression de messe
    public function supp_demande_messe($id)
    {
        DB::table("demande_messes")->where("id", $id)->delete();
        return true;
    }

    public function info_type_messe()
    {
        $type_de_messes = DB::table('type_messes')->orderBy('lib_type_messe')->get();
        $type_intentions = DB::table('type_intentions')->orderBy('lib_type_intention')->get();
        return view('Espaces.Messe.formDemandeMesse', compact('type_de_messes', 'type_intentions'));
    }

    public function listeDemandesMessesJourSuivant()
    {
        $demain = Carbon::tomorrow()->toDateString();

        $demandesMesses = DB::table('demande_messes')
            ->join('users', 'users.id', '=', 'demande_messes.id_user')
            ->join('type_intentions', 'type_intentions.id', '=', 'demande_messes.id_type_intention')
            ->whereDate('date_messe', '=', $demain)
            ->select('demande_messes.*', 'users.name', 'type_intentions.lib_type_intention as type_intention')
            ->get();

        // Renvoie les données sous forme de JSON pour AJAX
        return response()->json($demandesMesses);
    }

    // Ajoute cette ligne en haut du fichier

    public function genererPdfDemandesMessesJourSuivant()
    {
        $demain = Carbon::tomorrow()->toDateString();

        $demandesMesses = DB::table('demande_messes')
            ->join('users', 'users.id', '=', 'demande_messes.id_user')
            ->join('type_intentions', 'type_intentions.id', '=', 'demande_messes.id_type_intention')
            ->whereDate('date_messe', '=', $demain)
            ->select('demande_messes.*', 'users.name', 'type_intentions.lib_type_intention as type_intention')
            ->get();

        // Générez la vue pour le fichier PDF
        $pdf = PDF::loadView('Espaces.Messe.demandes_messes_pdf', compact('demandesMesses'));

        // Télécharger le fichier PDF
        return $pdf->download('demandes_messes_jour_suivant.pdf');
    }


    public function genererWordDemandesMessesJourSuivant()
    {
        $demain = Carbon::tomorrow()->toDateString();

        $demandesMesses = DB::table('demande_messes')
            ->join('users', 'users.id', '=', 'demande_messes.id_user')
            ->join('type_intentions', 'type_intentions.id', '=', 'demande_messes.id_type_intention')
            ->whereDate('date_messe', '=', $demain)
            ->select('demande_messes.*', 'users.name', 'type_intentions.lib_type_intention as type_intention')
            ->get();

        // Créer un nouveau document Word
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Ajouter un titre
        $section->addTitle('Liste des demandes de messe pour le ' . $demain);

        // Ajouter le tableau
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText('Type d\'intention');
        $table->addCell(4000)->addText('Description');
        $table->addCell(2000)->addText('Nom de l\'utilisateur');

        foreach ($demandesMesses as $demande) {
            $table->addRow();
            $table->addCell(2000)->addText($demande->type_intention);
            $table->addCell(4000)->addText($demande->intentions);
            $table->addCell(2000)->addText($demande->name);
        }

        // Générer et télécharger le fichier Word
        $fileName = 'demandes_messes_jour_suivant.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $phpWord->save($temp_file, 'Word2007');

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
