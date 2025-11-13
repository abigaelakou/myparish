<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\PaiementCatechese;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Mpdf\Mpdf;

class InscriptionCatecheseApiController extends Controller
{
    /**
     * Créer une inscription catéchétique
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'annee_catechetique' => 'required|string',
            'date_inscription' => 'required|date',
            'id_catechumene' => 'required|exists:catechumenes,id',
            'id_niveau' => 'required|exists:niveau_catechetiques,id',
            'id_session' => 'required|exists:session_catecheses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        DB::beginTransaction();
        try {
            $inscription = Inscription::create([
                'annee_catechetique' => $request->annee_catechetique,
                'date_inscription' => $request->date_inscription,
                'id_catechumene' => $request->id_catechumene,
                'id_user' => Auth::id(),
                'id_niveau' => $request->id_niveau,
                'id_session' => $request->id_session,
                'paroisse_id' => auth()->user()->paroisse_id,
            ]);

            // Paiement initial vide
            PaiementCatechese::create([
                'id_inscription' => $inscription->id,
                'montant' => 0,
                'mode_paiement' => null,
                'transaction_id' => null,
                'contact' => null,
                'payment_status' => 'En attente',
                'date_paiement' => now(),
                'paroisse_id' => auth()->user()->paroisse_id ?? null,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Inscription effectuée avec succès.',
                'inscription' => $inscription
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création inscription : ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur serveur lors de l’inscription.',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Enregistrer un paiement et générer le reçu PDF
     */
    //  public function payerInscription(Request $request)
    // {
    //     try {
    //         Log::info('Données reçues pour paiement :', $request->all());

    //         $validated = $request->validate([
    //             'id_inscription' => 'required|exists:inscriptions,id',
    //             'montant' => 'required|numeric|min:1',
    //             'mode_paiement' => 'required|string|max:255',
    //             'contact' => 'nullable|string|max:255',
    //             'payment_status' => 'required|in:En attente,Payé,Échec',
    //         ]);

    //         $paiement = PaiementCatechese::firstOrNew([
    //             'id_inscription' => $validated['id_inscription'],
    //         ]);

    //         $paiement->montant = $validated['montant'];
    //         $paiement->mode_paiement = $validated['mode_paiement'];
    //         $paiement->contact = $validated['contact'] ?? null;
    //         $paiement->payment_status = $validated['payment_status'];
    //         $paiement->date_paiement = now();
    //         $paiement->paroisse_id = auth()->user()->paroisse_id ?? null;
    //         $paiement->save();

    //         // Charger toutes les relations pour le PDF
    //         $paiement = PaiementCatechese::with([
    //             'inscription.catechumene',
    //             'inscription.niveau',
    //             'inscription.session'
    //         ])->find($paiement->id);

    //         // Dossiers nécessaires
    //         $recuDir = storage_path('app/public/recus');
    //         $tmpDir  = storage_path('app/public/tmp');

    //         if (!file_exists($recuDir)) mkdir($recuDir, 0775, true);
    //         if (!file_exists($tmpDir)) mkdir($tmpDir, 0775, true);

    //         // Génération du HTML
    //         $html = view('Espaces.Catechese.recu_paiement', ['recu' => $paiement])->render();

    //         // Configuration mPDF
    //         $mpdf = new Mpdf([
    //             'mode' => 'utf-8',
    //             'format' => 'A4',
    //             'tempDir' => $tmpDir,
    //             'default_font' => 'dejavusans',
    //             'margin_left' => 10,
    //             'margin_right' => 10,
    //             'margin_top' => 10,
    //             'margin_bottom' => 10,
    //         ]);

    //         $mpdf->SetDisplayMode('fullpage');
    //         $mpdf->WriteHTML($html);

    //         // Sauvegarde du PDF
    //         $filename = 'recu_inscription_' . $paiement->id . '.pdf';
    //         $path = $recuDir . '/' . $filename;
    //         $mpdf->Output($path, \Mpdf\Output\Destination::FILE);

    //         // ✅ Générer une URL publique directe
    //         $url = asset('storage/recus/' . $filename);

    //         return response()->json([
    //             'message' => 'Paiement enregistré avec succès.',
    //             'recu_url' => $url,
    //         ], 201);

    //     } catch (\Exception $e) {
    //         Log::error('Erreur payerInscription : ' . $e->getMessage());
    //         return response()->json([
    //             'error' => 'Erreur serveur lors du paiement.',
    //             'details' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function payerInscription(Request $request)
{
    try {
        Log::info('Données reçues pour paiement :', $request->all());

        $validated = $request->validate([
            'id_inscription' => 'required|exists:inscriptions,id',
            'montant' => 'required|numeric|min:1',
            'mode_paiement' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'payment_status' => 'required|in:En attente,Payé,Échec',
        ]);

        $paiement = PaiementCatechese::firstOrNew([
            'id_inscription' => $validated['id_inscription'],
        ]);

        $paiement->montant = $validated['montant'];
        $paiement->mode_paiement = $validated['mode_paiement'];
        $paiement->contact = $validated['contact'] ?? null;
        $paiement->payment_status = $validated['payment_status'];
        $paiement->date_paiement = now();
        $paiement->paroisse_id = auth()->user()->paroisse_id ?? null;
        $paiement->save();

        // Charger toutes les relations pour le PDF
        $paiement = PaiementCatechese::with([
            'inscription.catechumene',
            'inscription.niveau',
            'inscription.session'
        ])->find($paiement->id);

        // Dossiers nécessaires
        $recuDir = storage_path('app/public/recus');
        $tmpDir  = storage_path('app/public/tmp');

        if (!file_exists($recuDir)) mkdir($recuDir, 0775, true);
        if (!file_exists($tmpDir)) mkdir($tmpDir, 0775, true);

        // Génération du HTML
        $html = view('Espaces.Catechese.recu_paiement', ['recu' => $paiement])->render();

        // Configuration mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'tempDir' => $tmpDir,
            'default_font' => 'dejavusans',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        // Sauvegarde du PDF
        $filename = 'recu_inscription_' . $paiement->id . '.pdf';
        $path = $recuDir . '/' . $filename;
        $mpdf->Output($path, \Mpdf\Output\Destination::FILE);

        // ✅ Générer une URL publique directe
        $url = asset('storage/recus/' . $filename);

        // ✅ Enregistrer le lien dans la BDD
        $paiement->update(['recu_url' => $url]);

        return response()->json([
            'message' => 'Paiement enregistré avec succès.',
            'recu_url' => $url,
        ], 201);

    } catch (\Exception $e) {
        Log::error('Erreur payerInscription : ' . $e->getMessage());
        return response()->json([
            'error' => 'Erreur serveur lors du paiement.',
            'details' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Télécharger le reçu PDF
     */
  public function downloadRecu($id)
    {
        try {
            $paiement = PaiementCatechese::findOrFail($id);

            // Vérification du propriétaire
            if ($paiement->inscription->id_user !== auth()->id()) {
                abort(403, 'Accès non autorisé à ce reçu.');
            }

            $filename = 'recu_inscription_' . $paiement->id . '.pdf';
            $dir = storage_path('app/public/recus');
            $path = $dir . '/' . $filename;

            if (!file_exists($dir)) mkdir($dir, 0775, true);

            // Génération PDF si inexistant
            if (!file_exists($path)) {
                $html = view('Espaces.Catechese.recu_paiement', ['recu' => $paiement])->render();
                $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('app/public/tmp')]);
                Log::info('HTML reçu pour reçu paiement ID ' . $paiement->id, ['html' => $html]);
                $mpdf->WriteHTML($html);
                $mpdf->Output($path, \Mpdf\Output\Destination::FILE);
            }

            // Retourner le PDF directement
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur téléchargement reçu : ' . $e->getMessage());
            return response()->json([
                'error' => 'Impossible de télécharger le reçu.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Récupérer les infos d'un paiement
     */
    public function getPaiementInfo($id)
    {
        $inscription = Inscription::with([
            'catechumene',
            'niveau',
            'session',
            'paiement'
        ])->find($id);

        if (!$inscription) {
            return response()->json(['error' => 'Inscription non trouvée.'], 404);
        }

        $paiement = $inscription->paiement;

        return response()->json([
            'inscription_id' => $inscription->id,
            'date_inscription' => $inscription->date_inscription,
            'annee_catechetique' => $inscription->annee_catechetique,
            'catéchumène' => $inscription->catechumene->name ?? null,
            'niveau' => $inscription->niveau->lib_niveau ?? null,
            'session' => $inscription->session->lib_session_catechese ?? null,
            'paiement' => [
                'montant' => $paiement->montant ?? 0,
                'status' => $paiement->payment_status ?? 'Non défini',
                'mode_paiement' => $paiement->mode_paiement ?? null,
                'contact' => $paiement->contact ?? null,
            ]
        ]);
    }

    /**
     * Lister tous les paiements
     */
//   public function listePaiements()
//     {
//         $paiements = PaiementCatechese::with([
//             'inscription.catechumene',
//             'inscription.niveau',
//             'inscription.session'
//         ])->orderBy('created_at', 'desc')->get();

//         $paiements = $paiements->map(function ($p) {
//             $filename = 'recu_inscription_' . $p->id . '.pdf';
//             $path = storage_path('app/public/recus/' . $filename);

//             if (file_exists($path)) {
//                 $p->recu_url = asset('storage/recus/' . $filename);
//             } else {
//                 $p->recu_url = null;
//             }

//             return $p;
//         });

//         return response()->json([
//             'paiements' => $paiements
//         ]);
//     }

    /**
 * Lister les paiements de connecté
 */
public function listePaiements()
{
    try {
        // Récupérer l'utilisateur connecté
        $userId = auth()->id();

        // Charger tous les paiements dont l'inscription appartient à l'utilisateur connecté
        $paiements = PaiementCatechese::with([
            'inscription.catechumene',
            'inscription.niveau',
            'inscription.session'
        ])
        ->whereHas('inscription', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        // Vérifier si le PDF existe et ajouter recu_url
        $paiements = $paiements->map(function ($p) {
            $filename = 'recu_inscription_' . $p->id . '.pdf';
            $path = storage_path('app/public/recus/' . $filename);

            $p->recu_url = file_exists($path) ? asset('storage/recus/' . $filename) : null;

            return [
                'id' => $p->id,
                'id_inscription' => $p->id_inscription,
                'inscription' => [
                    'catechumene' => [
                        'name' => $p->inscription->catechumene->name ?? 'Inconnu',
                    ],
                    'niveau' => [
                        'lib_niveau' => $p->inscription->niveau->lib_niveau ?? 'N/A',
                    ],
                    'session' => [
                        'lib_session_catechese' => $p->inscription->session->lib_session_catechese ?? 'N/A',
                    ],
                    'date_inscription' => $p->inscription->date_inscription,
                ],
                'montant' => $p->montant,
                'payment_status' => $p->payment_status,
                'recu_url' => $p->recu_url,
            ];
        });

        return response()->json([
            'paiements' => $paiements
        ], 200);

    } catch (\Exception $e) {
        Log::error('Erreur listePaiements : ' . $e->getMessage());
        return response()->json([
            'error' => 'Impossible de récupérer les paiements.',
            'details' => $e->getMessage()
        ], 500);
    }
}

}