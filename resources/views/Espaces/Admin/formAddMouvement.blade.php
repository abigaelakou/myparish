@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formualire d'ajout</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Mouvements</li>
                        <li class="breadcrumb-item active"> Formulaire de création de mouvement</li>
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
                        <h4>Mouvement</h4>
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
                        <form class="row g-3" action="{{ route('create_mouvement') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Nom Mouvement</label>
                                <input class="form-control" name="lib_mouvement" id="validationTooltip01" type="text"
                                    placeholder="Les amis de Saint Joseph" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="inputPassword2">Date de création</label>
                                <input class="form-control" name="date_creation" id="inputPassword2" type="date"
                                    required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Description</label>
                                <textarea name="description" id="" cols="30" rows="4" required></textarea>
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
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
    
document.addEventListener('DOMContentLoaded', function () {
const addRencontreButton = document.getElementById('addRencontre');
const rencontresContainer = document.getElementById('rencontres');
let index = 1; // L'index commence à 1 car l'index 0 est déjà utilisé dans le HTML initial

addRencontreButton.addEventListener('click', function () {
const rencontreHtml = `
<div class="rencontres" data-index="${index}">
    <div class="row">
        <div class="col-md-4 position-relative">
            <label class="form-label" for="jour_${index}">Jour de rencontres</label>
            <input class="form-control" name="rencontres[${index}][jour]" id="jour_${index}" type="text" required>
        </div>
        <div class="col-md-4 position-relative">
            <label class="form-label" for="heure_debut_${index}">Heure de début</label>
            <input class="form-control" name="rencontres[${index}][heure_debut]" id="heure_debut_${index}" type="time"
                required>
        </div>
        <div class="col-md-4 position-relative">
            <label class="form-label" for="heure_fin_${index}">Heure de fin</label>
            <input class="form-control" name="rencontres[${index}][heure_fin]" id="heure_fin_${index}" type="time"
                required>
        </div>
    </div>
</div>`;
rencontresContainer.insertAdjacentHTML('beforeend', rencontreHtml);
index++;
});
});
</script>
@endsection

@section('page-js')


@endsection