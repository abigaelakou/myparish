@extends('layouts.master')

@section('main-content')

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Tableau des mouvements</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Liste des mouvements</li>
                        <li class="breadcrumb-item active">Tableau des mouvements</li>
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
                                    <div class="table-responsive custom-scrollbar" id="liste_des_mouvements">

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
    <div class="modal fade" id="editRencontreModal" tabindex="-1" role="dialog" aria-labelledby="editRencontreModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification de Mouvement</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_rencontre') }}" id="editRencontreMouvForm">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <input type="hidden" name="id_rencontre" id="id_rencontre">
                                <input type="hidden" name="id_mouvement" id="id_mouvement">
                                <label class="form-label" for="validationTooltip01">Nom Mouvement</label>
                                <input class="form-control" name="lib_mouvement" id="lib_mouvement" type="text"
                                    required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="inputPassword2">Date de création</label>
                                <input class="form-control" name="date_creation" id="date_creation" type="date"
                                    required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Description</label>
                                <textarea name="description" id="description" cols="30" rows="4" required></textarea>
                            </div>
                            <div id="rencontres">
                                <div class="rencontres">
                                    <div class="row">
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="inputPassword2">Jour de rencontres</label>
                                            <input class="form-control" name="rencontres[0][jour]" id="jour" type="text"
                                                required="">
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="exampleFormControlInput1">Heure de
                                                début</label>
                                            <input class="form-control" name="rencontres[0][heure_debut]"
                                                id="heure_debut" type="time" required="">
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="exampleFormControlInput1">Heure de
                                                fin</label>
                                            <input class="form-control" name="rencontres[0][heure_fin]" id="heure_fin"
                                                type="time" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary" id="addRencontre">Ajouter une
                                    rencontre</button>
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
    document.getElementById('addRencontre').addEventListener('click', function() {
    var rencontreCount = document.querySelectorAll('.rencontre').length;
    var newRencontre = document.createElement('div');
    newRencontre.classList.add('rencontre');
    newRencontre.innerHTML = `
    <div class="row">
        <div class="col-md-4 position-relative">
            <label for="jour">Jour</label>
            <input class="form-control" type="text" name="rencontres[${rencontreCount}][jour]" required>
        </div>
        <div class="col-md-4 position-relative">
            <label for="heure_debut">Heure de début</label>
            <input class="form-control" type="time" name="rencontres[${rencontreCount}][heure_debut]" required>
        </div>
        <div class="col-md-4 position-relative">
            <label for="heure_fin">Heure de fin</label>
            <input class="form-control" type="time" name="rencontres[${rencontreCount}][heure_fin]" required>
        </div>
    </div>
    `;
    document.getElementById('rencontres').appendChild(newRencontre);
    });
</script>
@endsection

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/mouvement.js')}}"></script>
@endsection