@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Créa Compte Paroisse</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Paroisse</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout Paroisse</li>
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
                        <form class="row g-3" action="{{ route('create_paroisse') }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                        <div class="col-md-6">
                            <label>Pays</label>
                            <select id="pays_id" class="form-control" required>
                                <option value="">-- Sélectionnez un pays --</option>
                                @foreach($pays as $p)
                                    <option value="{{ $p->id }}">{{ $p->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Diocèse</label>
                            <select id="diocese_id" name="diocese_id" class="form-control" required>
                                <option value="">-- Sélectionnez un diocèse --</option>
                            </select>
                        </div>


                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="nom_paroisse">Nom Paroisse</label>
                                <input class="form-control" name="nom_paroisse" type="text"
                                    placeholder="Paroisse Saint Pierre" required="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="adresse">Adresse </label>
                                <input class="form-control" name="adresse" type="text" placeholder="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="contact">Contact</label>
                                <input class="form-control" name="contact" type="number" placeholder="0700000000">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="email">Adresse Email</label>
                                <input class="form-control" name="email" type="email" placeholder="admin@domain.com"
                                    required="">
                            </div>
                            <div class="card-header">
                                <h4>Documents paroisse</h4>
                            </div>
                            <div class="col-md-6">
                                <label for="document_rccm">Document RCCM / NIF (PDF ou image)</label>
                                <input class="form-control" type="file" name="document_rccm" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-md-6">
                                <label for="document_identite">Pièce d'identité du curé / responsable</label>
                                <input class="form-control" type="file" name="document_identite" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>


                            <div class="card-header">
                                <h4>Création de l'utilisateur admin associé à la paroisse</h4>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Nom et prénom(s)</label>
                                <input class="form-control" name="admin_name" id="admin_name" type="text"
                                    placeholder="Joseph Kouamé" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Contact</label>
                                <input class="form-control" name="admin_contact" id="admin_contact" type="number"
                                    placeholder="0700000000" required="">
                                <div class="valid-tooltip">Bon!</div>
                            </div>
                        
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Adresse Email</label>
                                <input class="form-control" name="admin_email" id="admin_email" type="email"
                                    placeholder="pesamof475@gmail.com" required="">
                            </div>
                            <div class="card-header">
                                <h4>Création du portefeuille à la paroisse</h4>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="wallet_type">Type portefeuille</label>
                                <input class="form-control" name="wallet_type" id="wallet_type" type="text"
                                    placeholder="" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="wallet_contact">Contact du portefeuille</label>
                                <input class="form-control" name="wallet_contact" id="wallet_contact" type="text"
                                    placeholder="ex: Orange Money, MTN MoMo" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="api_key">L'api associé</label>
                                <input class="form-control" name="api_key" id="api_key" type="text"
                                    placeholder="" required="">
                            </div>
                             <div class="col-md-4 position-relative">
                                <label class="form-label" for="api_secret">Clé secrète associée</label>
                                <input class="form-control" name="api_secret" id="api_secret" type="password"
                                    placeholder="" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="payment_provider_url">L'url service Provider</label>
                                <input class="form-control" name="payment_provider_url" id="payment_provider_url" type="text"
                                    placeholder="" required="">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Créer la paroisse</button>
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
    document.getElementById('pays_id').addEventListener('change', function() {
    let paysID = this.value;

    fetch('/dioceses-by-pays/' + paysID)
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('diocese_id');
            select.innerHTML = '<option value="">-- Sélectionnez un diocèse --</option>';

            data.forEach(function(diocese) {
                select.innerHTML += `<option value="${diocese.id}">${diocese.nom}</option>`;
            });
        });
});
</script>

@endsection

@section('page-js')
@section('scripts')

@endsection