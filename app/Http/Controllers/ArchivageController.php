<?php

namespace App\Http\Controllers;

use App\Models\Archivage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchivageController extends Controller
{

    public function store_archivage(Request $request)
    {
        // Validation du formulaire
        $request->validate([
            'lib_document' => 'required|string|max:255',
            'date_archivage' => 'required|date',
            'fichier' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', // Accepter plusieurs types de fichiers
            'paroisse_id' => 'required|exists:paroisses,id',

        ]);

        // Gestion du fichier uploadé
        $filePath = $request->file('fichier')->store('archives', 'public'); // Stockage dans le répertoire 'archives' de public

        // Enregistrement dans la base de données
        Archivage::create([
            'lib_document' => $request->lib_document,
            'date_archivage' => $request->date_archivage,
            'fichier' => $filePath,
            'id_user' => Auth::id(),
            'paroisse_id' => auth()->user()->paroisse_id
        ]);

        return redirect()->back()->with('success', 'Document archivé avec succès!');
    }

    public function listDocuments()
    {
        // Récupération des documents archivés
        $documents = Archivage::with('user')
            ->where('paroisse_id', auth()->user()->paroisse_id)
            ->get();
        return $documents;
    }

    public function download($id)
    {
        // Récupérer le document
        $document = Archivage::findOrFail($id)
            ->where('paroisse_id', auth()->user()->paroisse_id);

        // Télécharger le fichier
        return Storage::disk('public')->download($document->fichier);
    }
}