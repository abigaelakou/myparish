@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Liste des évenements</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste des évènements</li>
                        <li class="breadcrumb-item active">Evènements </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar" id="liste_des_evenements">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- Modification --}}
    <div class="modal fade" id="editEvenementModal" tabindex="-1" role="dialog" aria-labelledby="editEvenementModal"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification d'Evènement
                    </h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_evenement') }}" id="editEvenementForm">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <input type="hidden" name="id_evenement" id="id_evenement">
                                <label class="form-label" for="validationTooltip01">Titre Evènement</label>
                                <input class="form-control" name="modif_lib_evenement" id="modif_lib_evenement"
                                    type="text" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Date Evènement</label>
                                <input class="form-control" name="modif_date_evement" id="modif_date_evement"
                                    type="date" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Heure Evènement</label>
                                <input class="form-control" name="modif_heure_evenement" id="modif_heure_evenement"
                                    type="time" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-12 position-relative">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="modif_description"
                                    name="modif_description"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">LISTE DES EVENEMENTS AU PROGRAMME</h1>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar" id="liste_des_evenements_non_rea">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    console.log('JavaScript loaded');
</script> --}}
@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/evenement.js')}}"></script>
@endsection