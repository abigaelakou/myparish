@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>ESPACE CATECHESE</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Espace catechèse</li>
                        <li class="breadcrumb-item active">Infos catechèse</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->

    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <a href="{{ route('formInscriptionKT') }}" class="btn btn-primary">Inscription</a>
                <a href="{{ route('affectation_catechumene') }}" class="btn btn-secondary">Affectation</a>
                <a href="{{ route('formDecisionCatechumene') }}" class="btn btn-primary">Décision de fin d'année</a>
                <a href="{{ route('formClasse') }}" class="btn btn-secondary">Espace classe</a>
                <a href="{{ route('formCatechumene') }}" class="btn btn-primary">Attestation </a>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <hr>
    <h3 class="text-center">Liste des catéchumènes inscris pour l'année catéchétique en cours</h3>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="catechumene_inscris">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3 class="text-center">Liste des catéchumènes en retard de paiement d'inscription</h3>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="catechumene_inscris_attente">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-md" id="editPaiementModal" tabindex="-1" role="dialog" aria-labelledby="editPaiementModal"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <div class="modal-body">
                    <h2>Suite d'inscription</h2>
                    <form class="row g-3" action="{{ route('validation_paiementCatechese') }} " method="POST"
                        id="editPaiementForm">
                        @csrf
                        <input type="hidden" name="id_inscription" id="id_inscription">

                        <div class="col-md-4 position-relative">
                            <label for="montant">Montant à payer :</label>
                            <input type="number" class="form-control" name="montant" value="" step="0.01" id="montant"
                                required>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="contact">Numéro de téléphone :</label>
                            <input type="tel" class="form-control" name="contact" value="" pattern="[0-9]{8,14}"
                                required title="Veuillez entrer un numéro de téléphone valide entre 8 et 14 chiffres">
                            @error('contact')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 position-relative">
                            <label for="mode_paiement">Mode de paiement :</label>
                            <select class="form-select" name="mode_paiement" required>
                                <option value="" disabled selected>Choisissez un mode de paiement</option>
                                <option value="moov">Moov</option>
                                <option value="orange">Orange</option>
                                <option value="mtn">MTN</option>
                                <option value="wave">Wave</option>
                            </select>
                            @error('mode_paiement')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button class="btn btn-secondary" type="submit">Payer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<!-- Modale pour afficher le reçu -->
<div class="modal fade" id="recuModal" tabindex="-1" aria-labelledby="recuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recuModalLabel">Reçu de Paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h1>Reçu de Paiement</h1>
                    <div class="info">
                        <label>Nom et Prénom:</label>
                        <p id="modalNomPrenom"></p>
                    </div>

                    <div class="info">
                        <label>Montant:</label>
                        <p id="modalMontant"></p>
                    </div>

                    <div class="info">
                        <label>Contact:</label>
                        <p id="modalContact"></p>
                    </div>

                    <div class="info">
                        <label>Date de Paiement:</label>
                        <p id="modalDatePaiement"></p>
                    </div>
                    <div class="footer">
                        <p>Merci pour votre paiement.</p>
                        <p>Veuillez envoyer ce reçu au secrétariat pour récupérer vos manuels.</p>
                        <a href="#" id="modalDownloadLink" class="button">Télécharger le Reçu</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 
</script> --}}

@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/catechumene.js')}}"></script>
@endsection