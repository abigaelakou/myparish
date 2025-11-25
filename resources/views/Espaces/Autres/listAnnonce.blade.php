@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Liste des annonces</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste des annonces</li>
                        <li class="breadcrumb-item active">Annonces </li>
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
                            <div class="table-responsive custom-scrollbar" id="liste_des_annonces">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- Modification --}}
    <div class="modal fade" id="editAnnonceModal" tabindex="-1" role="dialog" aria-labelledby="editAnnonceModal"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification d'annonce
                    </h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_annonce') }}" id="editAnnonceForm">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <input type="hidden" name="id_annonce" id="id_annonce">
                                <label class="form-label" for="validationTooltip01">Titre annonce</label>
                                <input class="form-control" name="modif_titre" id="modif_titre"
                                    type="text" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>

                            <div class="col-md-12 position-relative">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="modif_contenu"
                                    name="modif_contenu"></textarea>
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


{{-- <script>
    console.log('JavaScript loaded');
</script> --}}
@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/annonce.js')}}"></script>
@endsection