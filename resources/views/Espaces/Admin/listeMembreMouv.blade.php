@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Tableau des membres</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste membres des mouvements</li>
                        <li class="breadcrumb-item active">Membres des mouvements </li>
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
                                    <div class="table-responsive custom-scrollbar" id="liste_membre">

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
    <div class="modal fade" id="modalModifMembre" tabindex="-1" role="dialog" aria-labelledby="modalModifMembre"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification d'utilisateur</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_membre_mouv') }}" id="formModifMembre">
                            @csrf
                            <div class="col-md-4">
                                <input type="hidden" name="id_membre_mouvement" id="id_membre_mouvement">
                                <label class="form-label" for="validationCustom01">Nom & Prénom(s)</label>
                                <input class="form-control" id="modif_name_membre" type="text" required=""
                                    name="modif_name_membre">
                                <div class="valid-feedback">Bon!</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="validationCustom03">Contact</label>
                                <input class="form-control" id="modif_contact" type="text" required=""
                                    name="modif_contact">
                                <div class="valid-feedback">Bon!</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Role</label>
                                <select class="form-select" id="modif_role_membre" name="modif_role_membre" required="">
                                    <option value="MEMBRE SIMPLE">MEMBRE SIMPLE</option>
                                    <option value="RESPONSABLE">RESPONSABLE</option>
                                    <option value="MEMBRE BUREAU">MEMBRE BUREAU</option>
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Mouvement</label>
                                <select class="form-select" id="modif_id_mouvement" name="modif_id_mouvement"
                                    required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($mouvements as $mouvement)
                                    <option id="modif_id_mouvement{{ $mouvement->id }}" value="{{ $mouvement->id }}">
                                        {{ $mouvement->lib_mouvement }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom04">Date d'inscription</label>
                                <input class="form-control" id="modif_date_inscription" type="date" required=""
                                    name="modif_date_inscription">
                                <div class="valid-feedback">Bon!</div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Modifier</button>
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
<script src="{{asset('js/pages_js/mouvement.js')}}"></script>
@endsection