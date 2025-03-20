@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Les Paroisses</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste des paroisses</li>
                        <li class="breadcrumb-item active">Les paroisses membres </li>
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
                                    <div class="table-responsive custom-scrollbar" id="liste_des_paroisses">

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
                    <h3 class="modal-header justify-content-center border-0">Modification Paroisse</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_paroisse') }}" id="formModifParoisse">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <input type="hidden" name="id_paroisse" id="id_paroisse">
                                <label class="form-label" for="nom_paroisse">Nom Paroisse</label>
                                <input class="form-control" id="modif_nom_paroisse" name="modif_nom_paroisse"
                                    type="text" placeholder="Paroisse Saint Louis" required="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="adresse">Adresse </label>
                                <input class="form-control" id="modif_adresse" name="modif_adresse" type="text"
                                    placeholder="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="contact">Contact</label>
                                <input class="form-control" id="modif_contact" name="modif_contact" type="number"
                                    placeholder="0700000000">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="email">Adresse Email</label>
                                <input class="form-control" id="modif_email" name="email" type="email"
                                    placeholder="admin@domain.com" required="">
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

@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/paroisse.js')}}"></script>
@endsection