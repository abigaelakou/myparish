<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueAction;
use App\Models\Notification;
use App\Models\Paroisse;
use App\Models\ParoisseKycDocument;
use App\Models\User;
use App\Notifications\BienvenueAdminParoisse;
use App\Notifications\ParoisseStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ParoisseController extends Controller
{
    //

    public function createSuperAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $superAdmin = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'id_type_utilisateur' => 1, // ID 1 pour Super Admin
        ]);

        return redirect()->route('form_super_admin')->with('success', 'Super Admin créé avec succès.');
    }

    public function liste_des_super_admins()
    {
        $liste_sup_admin = DB::table('users')
            ->join('type_utilisateurs', 'users.id_type_utilisateur', '=', 'type_utilisateurs.id')
            ->select('users.*', 'type_utilisateurs.lib_type_utilisateur')
            ->where('users.id_type_utilisateur', '=', '1') // Filtrer TYPE UTILISATEUR
            ->get();
        // dd($liste_sup_admin);
        // exit();
        return $liste_sup_admin;
    }


  // CREATION DE PAROISSE
    public function createParoisse(Request $request)
    {
        $validatedData = $request->validate([
            'nom_paroisse' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:paroisses,email',
            'contact' => 'string|max:15|unique:paroisses,contact',
            'adresse' => 'required|string',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'admin_contact' => 'required|string|max:15|unique:users,contact',
            'wallet_type' => 'required|string',
            'wallet_contact' => 'required|string',
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'payment_provider_url' => 'required|string',

            // Validation des fichiers KYC
            'document_rccm' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'document_identite' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $paroisse = Paroisse::create([
                'nom_paroisse' => $validatedData['nom_paroisse'],
                'email' => $validatedData['email'],
                'contact' => $validatedData['contact'],
                'adresse' => $validatedData['adresse'],
                'wallet_type' => $validatedData['wallet_type'],
                'wallet_contact' => $validatedData['wallet_contact'],
                'api_key' => $validatedData['api_key'],
                'api_secret' => $validatedData['api_secret'],
                'payment_provider_url' => $validatedData['payment_provider_url'],
            ]);

            // Stockage des fichiers KYC
            $rccmPath = $request->file('document_rccm')->store('kyc_docs');
            $identitePath = $request->file('document_identite')->store('kyc_docs');

            // Enregistrement dans la table KYC
            ParoisseKycDocument::insert([
                [
                    'paroisse_id' => $paroisse->id,
                    'type_document' => 'rccm',
                    'chemin_fichier' => $rccmPath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'paroisse_id' => $paroisse->id,
                    'type_document' => 'identite',
                    'chemin_fichier' => $identitePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // Création utilisateur admin, envoi mail, etc.
            $defaultPassword = Str::random(10);
            $adminUser = User::create([
                'name' => $validatedData['admin_name'],
                'email' => $validatedData['admin_email'],
                'contact' => $validatedData['admin_contact'],
                'password' => Hash::make($defaultPassword),
                'id_type_utilisateur' => 2,
                'paroisse_id' => $paroisse->id,
                'must_change_password' => true,
            ]);
            $adminUser->notify(new BienvenueAdminParoisse(
                $adminUser->name,
                $paroisse->nom_paroisse,
                $adminUser->email,
                $defaultPassword
            ));

            HistoriqueAction::create([
                'paroisse_id' => $paroisse->id,
                'user_id' => auth()->id(),
                'action' => 'Création de paroisse',
                'details' => 'Paroisse ' . $paroisse->nom_paroisse . ' créée.',
            ]);

            DB::commit();

            return redirect()->route('formAddParoisse')->with('success', 'Paroisse et utilisateur admin créés avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }
    }
    public function liste_des_paroisses()
        {
            $liste_paroisse = DB::table('paroisses')->get();
            return $liste_paroisse;
        }

    // Changer le statut d'une paroisse
    public function update_status_paroisse($paroisse_id, $status_code)
    {
        try {
            if (!in_array($status_code, [0, 1])) {
                return response()->json(['error' => 'Code de statut invalide.'], 400);
            }

            $paroisse = Paroisse::find($paroisse_id);
            if (!$paroisse) {
                return response()->json(['error' => 'Paroisse non trouvée.'], 404);
            }

            $paroisse->update(['status' => $status_code]);

            if ($paroisse->users && $paroisse->users->count()) {
                Notification::send($paroisse->users, new ParoisseStatusChanged($paroisse));
            }

            HistoriqueAction::create([
                'paroisse_id' => $paroisse->id,
                'user_id' => auth()->id(),
                'action' => 'Changement de statut',
                'details' => 'Statut changé à ' . ($status_code == 1 ? 'actif' : 'inactif') . ' pour la paroisse ' . $paroisse->nom_paroisse,
            ]);

            return response()->json(['success' => 'Statut mis à jour avec succès.']);
        } catch (\Throwable $th) {
            Log::error('Erreur update_status_paroisse : ' . $th->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour du statut.'], 500);
        }
    }

    public function update_paroisse(Request $request)
    {
        Log::info($request->all());

        $data = $request->validate([
            'id_paroisse' => 'required|integer|exists:paroisses,id',
            'modif_nom_paroisse' => 'required|string',
            'modif_adresse' => 'required|string',
            'modif_contact' => 'required|',
            'modif_email' => 'required|string',
        ]);

        $modif_paroisse = Paroisse::where('id', $data['id_paroisse'])
            ->firstOrFail();

        // Mise à jour paroisse
        $modif_paroisse->update([
            'nom_paroisse' => $data['modif_nom_paroisse'],
            'adresse' => $data['modif_adresse'],
            'contact' => $data['modif_contact'],
            'email' => $data['modif_email'],

        ]);

        return response()->json(['success' => true, 'message' => 'Paroisse mise à jour avec succès.']);
    }

    // Affichage des historiques 
    public function showHistorique($id)
    {
        $paroisse = Paroisse::findOrFail($id);
        $historique = $paroisse->historiqueActions()->with('user')->get();
        return $historique;
        // return view('paroisses.historique', compact('paroisse', 'historique'));
    }
    // ***************************Gestion des Utilisateurs par paroisse****************************

    // Liste des utilisateurs par paroisse
    public function listUsersByParoisse()
    {
        $paroisses = Paroisse::with('users')->orderBy('nom_paroisse')->get();
        return $paroisses;
    }

    // TABLEAU DE BORD SUPER ADMIN

    public function dashboardStats()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        // Nombre total de paroisses actives et inactives
        $totalParoissesActives = Paroisse::where('status', 1)->count();
        $totalParoissesInactives = Paroisse::where('status', 0)->count();
        
        $totalParoissesSemaine = Paroisse::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        // Nombre total d'utilisateurs par rôle
        $usersByRole = User::select('id_type_utilisateur', DB::raw('count(*) as total'))
            ->groupBy('id_type_utilisateur')
            ->with('typeUtilisateur') // Charge les libellés des types
            ->get();

        $nombre_super_admin = DB::table("users")
            ->join('type_utilisateurs', 'users.id_type_utilisateur', '=', 'type_utilisateurs.id')
            ->where('type_utilisateurs.lib_type_utilisateur', '=', 'SUPER ADMIN')
            ->count();


            $donnee = [
                "totalParoissesActives" => $totalParoissesActives,
                "totalParoissesInactives" => $totalParoissesInactives,
                "usersByRole" => $usersByRole,
                "nombre_super_admin"=>$nombre_super_admin,
                "totalParoissesSemaine"=>$totalParoissesSemaine
            ];
    
            return $donnee;
        // return view('dashboard.stats', compact('totalParoissesActives', 'totalParoissesInactives', 'usersByRole'));
    }
}
