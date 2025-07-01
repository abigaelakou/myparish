@extends('layouts.master')

@section('main-content')
<style>
    /* Styles pour l'impression */
    @media print {
        body * {
            visibility: hidden;
        }

        .print-area,
        .print-area * {
            visibility: visible;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
        }

        .no-print {
            display: none !important;
        }
    }
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Espace classes</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Classe catéchetique</li>
                        <li class="breadcrumb-item active"> Gestion des classes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Créer Une classe </h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form class="row g-3" action="{{ route('store_classe_catechese') }}" method="POST">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label class="id_niveau">Niveau catechèse</label>
                                <select class="form-select" id="id_niveau" name="id_niveau" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($list_niveaux as $list_niveau)
                                    <option value="{{ $list_niveau->id }}">
                                        {{ $list_niveau->lib_niveau }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="id_session">Session catechèse</label>
                                <select class="form-select" id="id_session" name="id_session" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($list_sessions as $list_session)
                                    <option value="{{ $list_session->id }}">
                                        {{ $list_session->lib_session_catechese }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="lib_classe_cate">Libellé classe:</label>
                                <input type="text" class="form-control" id="lib_classe_cate" name="lib_classe_cate">
                            </div>

                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- AFFICHAGE DES LISTE DES CLASSES --}}
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Imprimer une liste classe </h5>
                    </div>
                    <div class="card-body">
                        <h3>Sélectionner un niveau et une session</h3>

                        <form id="form-selection" method="GET">
                            <div class="row">
                                <div class="col-md-6 position-relative">
                                    <label for="niveau">Niveau :</label>
                                    <select class="form-select" name="niveau" id="niveau">
                                        <option value="">Sélectionner un niveau</option>
                                        @foreach($list_niveaux as $list_niveau)
                                        <option value="{{ $list_niveau->id }}">{{ $list_niveau->lib_niveau }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <label for="session">Session :</label>
                                    <select class="form-select" name="session" id="session">
                                        <option value="">Sélectionner une session</option>
                                        @foreach($list_sessions as $list_session)
                                        <option value="{{ $list_session->id }}">{{ $list_session->lib_session_catechese
                                            }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class=" btn btn-primary no-print mt-2">Afficher la liste</button>
                        </form>

                        <div id="result-list" class="print-area">
                            <!-- La liste des catéchumènes sera affichée ici -->
                        </div>
                        <button onclick="printList()" class="btn btn-secondary no-print" style="display:none"
                            id="printButton">Imprimer la liste</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des decision finales-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Liste des classes crées</h3>
                        <div class="table-responsive custom-scrollbar" id="liste_classe_catechese">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Container-fluid starts-->

{{-- MODAL DE MODIFICATION --}}
<div class="modal fade modal-lg" id="editClasseModal" tabindex="-1" role="dialog" aria-labelledby="editClasseModal"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0">Modification Infos Classe</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate="" method="POST"
                        action="{{ route('update_classe') }}" id="editClasseForm">
                        @csrf
                        <input type="hidden" id="id_classe" name="id_classe">
                        <div class="col-md-4 position-relative">
                            <label class="modif_id_niveau">Niveau catechèse</label>
                            <select class="form-select" id="modif_id_niveau" name="modif_id_niveau" required="">
                                <option selected="" disabled="" value="">choisir...</option>
                                @foreach ($list_niveaux as $list_niveau)
                                <option value="{{ $list_niveau->id }}">
                                    {{ $list_niveau->lib_niveau }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-tooltip">Faites un choix svp.</div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label class="modif_id_session">Session catechèse</label>
                            <select class="form-select" id="modif_id_session" name="modif_id_session" required="">
                                <option selected="" disabled="" value="">choisir...</option>
                                @foreach ($list_sessions as $list_session)
                                <option value="{{ $list_session->id }}">
                                    {{ $list_session->lib_session_catechese }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-tooltip">Faites un choix svp.</div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="modif_lib_classe_cate">Libellé classe:</label>
                            <input type="text" class="form-control" id="modif_lib_classe_cate"
                                name="modif_lib_classe_cate">
                        </div>

                        <div class="col-12">
                            <button class="btn btn-secondary" type="submit">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 

// Affichage de la liste
document.getElementById('form-selection').addEventListener('submit', function(e) {
e.preventDefault(); // Empêche la soumission classique du formulaire
var niveau = document.getElementById('niveau').value;
var session = document.getElementById('session').value;

if (!niveau || !session) {
alert("Veuillez sélectionner un niveau et une session.");
return;
}

fetch(`/liste-catechumenes?niveau=${niveau}&session=${session}`)
.then(response => response.json())
.then(data => {
if (data.length > 0) {
// Trier les catéchumènes par ordre alphabétique de leur nom
data.sort((a, b) => a.name.localeCompare(b.name));

// Titre pour le tableau
var niveauText = document.getElementById('niveau').selectedOptions[0].text;
var sessionText = document.getElementById('session').selectedOptions[0].text;
var result = `<h2>Liste des Catéchumènes ${niveauText} ${sessionText}</h2>`;

// Générer le tableau
result += `
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>N°</th>
            <th>Nom et Prénom</th>
        </tr>
    </thead>
    <tbody>`;

        // Remplir le tableau avec les catéchumènes
        data.forEach((catechumene, index) => {
        result += `
        <tr>
            <td>${index + 1}</td>
            <td>${catechumene.name}</td>
        </tr>`;
        });

        result += `
    </tbody>
</table>`;

document.getElementById('printButton').style.display = "block"; // Afficher le bouton d'impression
} else {
result = '<p>Aucun catéchumène affecté à cette classe.</p>';
document.getElementById('printButton').style.display = "none"; // Cacher le bouton d'impression
}
document.getElementById('result-list').innerHTML = result;
})
.catch(error => {
console.error('Erreur:', error);
document.getElementById('result-list').innerHTML = '<p>Une erreur s\'est produite. Veuillez réessayer plus tard.</p>';
});
});

// Fonction pour ouvrir la liste dans une nouvelle fenêtre et l'imprimer
function printList() {
var printContents = document.getElementById('result-list').innerHTML;
var niveauText = document.getElementById('niveau').selectedOptions[0].text;
var sessionText = document.getElementById('session').selectedOptions[0].text;

var newWindow = window.open('', '_blank'); // Ouvrir une nouvelle fenêtre
newWindow.document.write(`
<html>

<head>
    <title>Liste des Catéchumènes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Liste des Catéchumènes ${niveauText} ${sessionText}</h2>
    ${printContents}
</body>

</html>
`);

newWindow.document.close(); // Fermer le document
newWindow.focus(); // Mettre en focus la nouvelle fenêtre
newWindow.print(); // Ouvrir la fenêtre d'impression
newWindow.close(); // Fermer la fenêtre après impression
}
</script>
@endsection

@section('scripts')
<script src="{{asset('js/pages_js/catechumene.js')}}" defer></script>
@endsection