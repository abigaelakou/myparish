<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    //
    public function stat_glogale()
    {
        $nombre_paroissien = DB::table("users")
            ->join('type_utilisateurs', 'users.id_type_utilisateur', '=', 'type_utilisateurs.id')
            ->whereIn('type_utilisateurs.lib_type_utilisateur', [
                'PAROISSIEN',
                'RESPONSABLE MVT',
                'SECRETAIRE',
                'RESPONSABLE CATECHESE',
                'VICE RESPO CONSEIL PAROISSIAL'
            ])
            ->where('users.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->count();

        $nombre_non_paroissien = DB::table("users")
            ->join('type_utilisateurs', 'users.id_type_utilisateur', '=', 'type_utilisateurs.id')
            ->where('type_utilisateurs.lib_type_utilisateur', '=', 'NON PAROISSIEN')
            ->where('users.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->count();

        $nbre_mouvement = DB::table("mouvements")
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->count();

        $nbre_doc_archive = DB::table("archivages")
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->count();

        $donnee = [
            "nombre_paroissien" => $nombre_paroissien,
            "nombre_non_paroissien" => $nombre_non_paroissien,
            "nbre_mouvement" => $nbre_mouvement,
            "nbre_doc_archive" => $nbre_doc_archive,
        ];

        return $donnee;
    }

    public function stat_dons($mois = null, $annee = null)
    {
        $mois = $mois ?? date('m');
        $annee = $annee ?? date('Y');

        $dons_recus = DB::table("dons")
            ->where('payment_status', '=', 'Payé')
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereMonth("dons.created_at", $mois)
            ->whereYear("dons.created_at", $annee)
            ->sum('montant');

        $nbre_total_don_recu = DB::table("dons")
            ->where('payment_status', '=', 'Payé')
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereMonth("dons.created_at", $mois)
            ->whereYear("dons.created_at", $annee)
            ->count();

        $list_principaux_donateurs = DB::table("dons")
            ->join('users', 'dons.donateur_id', '=', 'users.id')
            ->join('type_dons', 'dons.id_type_don', '=', 'type_dons.id')
            ->where('dons.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereMonth("dons.created_at", $mois)
            ->whereYear("dons.created_at", $annee)
            ->select(
                'users.name as nom_prenom', // Nom du donateur
                'type_dons.lib_type_don as type_don',
                'dons.montant',
                'dons.contact',
                'dons.date_don',
            )
            ->get();

        $statistiques_dons = [
            "dons_recus" => $dons_recus,
            "nbre_total_don_recu" => $nbre_total_don_recu,
            "list_principaux_donateurs" => $list_principaux_donateurs,
        ];

        return response()->json($statistiques_dons);
    }

    public function liste_evenement_a_venir()
    {
        $evenement_a_venir = DB::table('evenements')
            ->where('evenements.date_evement', ">", now())
            ->where('evenements.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->select('evenements.*')
            ->get();

        return response()->json($evenement_a_venir);
    }

    public function start_catechese()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1;
        $endYear = $startYear + 1;

        $anneeEnCours = "{$startYear}-{$endYear}";

        // Nombre de catéchumènes inscrits pour l'année en cours avec paiement validé
        $nombre_catechumene_inscris_annee_en_cours = DB::table('paiements_catechese')
            ->join('inscriptions', 'paiements_catechese.id_inscription', '=', 'inscriptions.id')
            ->join('catechumenes', 'inscriptions.id_catechumene', '=', 'catechumenes.id')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id')
            ->where('inscriptions.annee_catechetique', '=', $anneeEnCours)
            ->where('paiements_catechese.payment_status', '=', 'Payé')
            ->where('inscriptions.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->count();

        // Nombre de catéchumènes par session
        $nombre_catechese_par_session = DB::table('inscriptions')
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id')
            ->where('inscriptions.annee_catechetique', '=', $anneeEnCours)
            ->where('inscriptions.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->select('session_catecheses.lib_session_catechese', DB::raw('count(*) as total'))
            ->groupBy('session_catecheses.lib_session_catechese') // Group by session to get counts per session
            ->get();

        // Montant total généré par les catéchumènes pour l'année en cours
        $montant_total_genere_par_catechese_annee_encours = DB::table('paiements_catechese')
            ->join('inscriptions', 'paiements_catechese.id_inscription', '=', 'inscriptions.id')
            ->join('catechumenes', 'inscriptions.id_catechumene', '=', 'catechumenes.id')
            ->join('niveau_catechetiques', 'inscriptions.id_niveau', '=', 'niveau_catechetiques.id')
            ->join('session_catecheses', 'inscriptions.id_session', '=', 'session_catecheses.id')
            ->where('inscriptions.annee_catechetique', '=', $anneeEnCours)
            ->where('paiements_catechese.payment_status', '=', 'Payé')
            ->where('inscriptions.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->sum('paiements_catechese.montant');

        // Regroupement des résultats dans une seule réponse JSON
        return response()->json([
            'nombre_catechumene_inscris_annee_en_cours' => $nombre_catechumene_inscris_annee_en_cours,
            'nombre_catechese_par_session' => $nombre_catechese_par_session,
            'montant_total_genere_par_catechese_annee_encours' => $montant_total_genere_par_catechese_annee_encours
        ]);
    }

    public function start_montant_total_annee_encours()
    {
        $currentYear = now()->year; // Année en cours
        $startYear = (now()->month >= 9) ? $currentYear : $currentYear - 1;
        $endYear = $startYear + 1;

        // la période de l'année des activités (du 1er septembre de l'année de départ au 31 août de l'année suivante)
        $startDate = "{$startYear}-09-01"; // 1er septembre de l'année de départ
        $endDate = "{$endYear}-08-31";     // 31 août de l'année suivante

        // Montant des dons payés pour l'année en cours
        $montant_dons_payes = DB::table('dons')
            ->where('payment_status', '=', 'Payé')
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        // Montant des inscriptions payées pour l'année en cours
        $montant_inscriptions_payees = DB::table('paiements_catechese')
            ->join('inscriptions', 'paiements_catechese.id_inscription', '=', 'inscriptions.id')
            ->where('payment_status', '=', 'Payé')
            ->where('inscriptions.annee_catechetique', '=', "{$startYear}-{$endYear}")
            ->where('inscriptions.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->sum('montant');

        // Récupération des demandes de messe payées
        $demande_messe_payees = DB::table('demande_messes')
            ->where('statut', '=', 'payée')
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Calcul du montant total des demandes de messe payées
        $montant_demande_messe = DB::table('paiements')
            ->join('demande_messes', 'paiements.id_demande', '=', 'demande_messes.id')
            ->where('demande_messes.statut', '=', 'payée')
            ->where('demande_messes.paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereBetween('demande_messes.created_at', [$startDate, $endDate])
            ->sum('paiements.montant');

        $montantTotalDepenseAnneEncours = DB::table('depenses')
            ->where('paroisse_id', auth()->user()->paroisse_id) // Vérification de la paroisse
            ->whereBetween('date_depense', [$startDate, $endDate])
            ->sum('montant');

        // Calcul du montant total pour l'année en cours
        $montant_total_pour_lannee = $montant_dons_payes + $montant_inscriptions_payees + $montant_demande_messe;

        $reste_en_caisse = $montant_total_pour_lannee - $montantTotalDepenseAnneEncours;

        return response()->json([
            'montant_total_pour_lannee' => $montant_total_pour_lannee,
            'montantTotalDepenseAnneEncours' => $montantTotalDepenseAnneEncours,
            'reste_en_caisse' => $reste_en_caisse
        ]);
    }


    // public function list_demande_messe_du_jour(){
    //     $demande_messe_du_jour=DB::table('demande_messes')->where()
    // }
}