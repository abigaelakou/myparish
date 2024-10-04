@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Tableau des utilisateurs</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste des utilisateurs</li>
                        <li class="breadcrumb-item active">Tableau des utilisateurs</li>
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
                    <div class="card-header pb-0 card-no-border">
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive custom-scrollbar" id="liste_utilisateurs">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL DE MODIFICATION --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification d'utilisateur</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_user') }}" id="editUserForm">
                            @csrf
                            <div class="col-md-6">
                                <input type="hidden" name="id_user" id="id_user">
                                <label class="form-label" for="validationCustom01">Nom & Prénom(s)</label>
                                <input class="form-control" id="modif_name" type="text" required="" name="modif_name">
                                <div class="valid-feedback">Bon!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom03">Email</label>
                                <input class="form-control" id="modif_email" type="email" required=""
                                    name="modif_email">
                                <div class="valid-feedback">Bon!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom04">Contact</label>
                                <input class="form-control" id="modif_contact" type="text" required=""
                                    name="modif_contact">
                                <div class="valid-feedback">Bon!</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip06">Profil</label>
                                <select class="form-select" id="modif_id_type_utilisateur"
                                    name="modif_id_type_utilisateur" value="" required="">
                                    <option value="1">ADMIN</option>
                                    <option value="2">CURE</option>
                                    <option value="3">RESPONSABLE</option>
                                    <option value="4">PRETRE</option>
                                    <option value="5">PAROISSIEN</option>
                                    <option value="6">SECRETAIRE</option>
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-12">
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
{{-- <script>
    console.log('JavaScript loaded');
</script> --}}
@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/users.js')}}"></script>
@endsection