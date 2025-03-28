@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Tableau des catechumenes</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste des catechumènes</li>
                        <li class="breadcrumb-item active">Tableau des catechumènes</li>
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
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_des_catechumenes">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL DE MODIFICATION --}}
    <div class="modal fade modal-lg" id="editCatechumeneModal" tabindex="-1" role="dialog"
        aria-labelledby="editCatechumeneModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification Des Infos du Catéchumène</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_catechumene') }}" id="editCatechumeneForm">
                            @csrf
                            <div class="col-md-3 position-relative">
                                <input type="hidden" class="form-control" id="id_catechumene" name="id_catechumene">
                                <label for="modif_name">Nom & Prénom(s):</label>
                                <input type="text" class="form-control" id="modif_name" name="modif_name" required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="modif_contact">Contact:</label>
                                <input type="number" class="form-control" id="modif_contact" name="modif_contact">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="emodif_mail">Email:</label>
                                <input type="email" class="form-control" id="modif_email" name="modif_email">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="modif_sacrement_recu">Sacrements reçus :</label>
                                <select name="modif_sacrement_recu[]" id="modif_sacrement_recu" multiple>
                                    <option value="BAPTEME">Baptême</option>
                                    <option value="CONFIRMATION">Confirmation</option>
                                    <option value="EUCHARISTIE">Eucharistie</option>
                                    <option value="MARIAGE">Mariage</option>
                                    <option value="ONCTION DES MALADES">Onction des malades</option>
                                    <option value="RECONCILIATION">Réconciliation</option>
                                </select>
                            </div>

                            {{-- <h4>Info Parents</h4> --}}
                            <div class="card-header">
                                <h4>Info Parents </h4>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="modif_nom_prenom_pere">Nom & Prénom(s) Père:</label>
                                <input type="text" class="form-control" id="modif_nom_prenom_pere"
                                    name="modif_nom_prenom_pere" required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="modif_contact_pere">Contact Père:</label>
                                <input type="number" class="form-control" id="modif_contact_pere"
                                    name="modif_contact_pere">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="modif_nom_prenom_mere">Nom & Prénom(s) Mère:</label>
                                <input type="text" class="form-control" id="modif_nom_prenom_mere"
                                    name="modif_nom_prenom_mere" required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="modif_contact_mere">Contact Mère:</label>
                                <input type="number" class="form-control" id="modif_contact_mere"
                                    name="modif_contact_mere">
                            </div>

                            {{-- <h4>Info Parain/Maraine</h4> --}}
                            <div class="card-header">
                                <h4>Info Parain/Maraine</h4>
                            </div>
                            <div class="col-md-5 position-relative">
                                <label for="modif_nom_prenom_parain">Nom & Prénom(s) :</label>
                                <input type="text" class="form-control" id="modif_nom_prenom_parain"
                                    name="modif_nom_prenom_parain">
                            </div>
                            <div class="col-md-5 position-relative">
                                <label for="modif_contact_parain">Contact :</label>
                                <input type="number" class="form-control" id="modif_contact_parain"
                                    name="modif_contact_parain">
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
    <!-- Container-fluid Ends-->
</div>

@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/catechumene.js')}}"></script>
@endsection