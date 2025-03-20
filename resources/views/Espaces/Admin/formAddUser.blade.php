@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Utilisateurs</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Utilisateurs</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout d'utilisateur</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Utilisateur</h4>
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
                        <form class="row g-3" action="{{ route('create_user') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Nom et prénom(s)</label>
                                <input class="form-control" name="name" id="validationTooltip01" type="text"
                                    placeholder="Joseph Kouamé" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Contact</label>
                                <input class="form-control" name="contact" id="validationTooltip02" type="number"
                                    placeholder="0700000000" required="">
                                <div class="valid-tooltip">Bon!</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="inputPassword2">Mot de passe</label>
                                <input class="form-control" name="password" id="inputPassword2" type="password"
                                    required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="inputPassword2">Confirmez le mot de passe</label>
                                <input class="form-control" name="password_confirmation" id="password_confirmation"
                                    type="password" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Adresse Email</label>
                                <input class="form-control" name="email" id="email" type="email"
                                    placeholder="pesamof475@gmail.com" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Profil</label>
                                <select class="form-select" id="id_type_utilisateur" name="id_type_utilisateur"
                                    required>
                                    <option selected="" disabled="" value="">Choisir un profil...</option>
                                    @foreach ($type_utilisateurs as $type_utilisateur)
                                    <option value="{{ $type_utilisateur->id }}">{{
                                        $type_utilisateur->lib_type_utilisateur }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Veuillez sélectionner un profil.</div>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="paroisse_id">Paroisse</label>
                                <select class="form-select" id="paroisse_id" name="paroisse_id" required>
                                    <option selected="" disabled="" value="">Choisir une paroisse...</option>
                                    @foreach ($paroisses as $paroisse)
                                    <option value="{{ $paroisse->id }}">{{ $paroisse->libelle_paroisse }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Veuillez sélectionner une paroisse.</div>
                            </div>
                            {{-- BOX TYPE TYPE_USER==PAROISSIEN --}}
                            <div id="paroissien_fields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4 position-relative">
                                        <label class="form-label" for="sexe">Sexe</label>
                                        <select id="sexe_paroissien" name="sexe_p" class="form-select">
                                            <option value="...">Choisir</option>
                                            <option value="Homme">Homme</option>
                                            <option value="Femme">Femme</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 position-relative">
                                        <label class="form-label" for="situation_matrimoniale">Situation
                                            matrimoniale</label>
                                        <select id="situation_matrimoniale" name="situation_matrimoniale"
                                            class="form-select">
                                            <option value="...">Choisir</option>
                                            <option value="MARIE(E)">MARIE(E)</option>
                                            <option value="CELIBATAIRE">CELIBATAIRE</option>
                                            <option value="CONCUBINAGE">CONCUBINAGE</option>
                                            <option value="DIVORCE">DIVORCE</option>
                                        </select>

                                    </div>

                                    <div class="col-md-4 position-relative">
                                        <label class="form-label" for="date_naiss">Date de naissance</label>
                                        {{-- <input type="date" id="date_naiss" name="date_naiss" class="form-control">
                                        --}}
                                        <input type="text" id="date_naiss" name="date_naiss" class="form-control"
                                            placeholder="JJ-MM-AAAA">
                                    </div>

                                    <div class="col-md-4 position-relative">
                                        <label class="form-label" for="sacrement_recu">Sacrement(s) reçu(s)</label>
                                        <select id="sacrement_recu" name="sacrement_recu[]" multiple
                                            class="form-control">
                                            <option value="2">ADMIN</option>
                                            <option value="3">CURE</option>
                                            <option value="4">RESPONSABLE</option>
                                            <option value="5">PRETRE</option>
                                            <option value="6">PAROISSIEN</option>
                                            <option value="7">SECRETAIRE</option>
                                            <option value="8">NON PAROISSIEN</option>
                                            <option value="9">RESPONSABLE CATECHESE</option>
                                            <option value="10">VICE RESPO CONSEIL PAROISSIAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- FIN BOX TYPE_USER==PAROISSIEN --}}
                            {{-- BOX TYPE TYPE_USER==NON_PAROISIEN --}}
                            <div id="non_paroissien_fields" style="display: none;">
                                <div class="col-md-4 position-relative">
                                    <label class="form-label" for="sexe">Sexe</label>
                                    <select id="sexe_non_paroissien" name="sexe_np" class="form-select">
                                        <option value="...">Choisir</option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                </div>
                            </div>
                            {{-- FIN BOX TYPE_USER== NON_PAROISSIEN --}}
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 
    
document.addEventListener('DOMContentLoaded', function() {
console.log("Script chargé");

// Appliquer Inputmask après le chargement du document
$('#date_naiss').inputmask('99-99-9999', { placeholder: "JJ-MM-AAAA" });

// Gestion des sélections de type utilisateur
var select = document.getElementById('id_type_utilisateur');
var paroissienFields = document.getElementById('paroissien_fields');
var nonParoissienFields = document.getElementById('non_paroissien_fields');

if (select) {
// Débogage : Afficher toutes les valeurs du select
Array.from(select.options).forEach(option => console.log("Option Value:", option.value));

// Ajouter un événement lorsque la sélection change
select.addEventListener('change', function() {
// Cacher les deux sections par défaut
paroissienFields.style.display = 'none';
nonParoissienFields.style.display = 'none';

// Afficher les champs selon la valeur sélectionnée
if (this.value === '3' || this.value === '5' || this.value === '6' || this.value === '8' || this.value === '9') {
paroissienFields.style.display = 'block';
} else if (this.value === '7') {
nonParoissienFields.style.display = 'block';
}
});
}
});
</script>



@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/users.js')}}"></script>
@endsection