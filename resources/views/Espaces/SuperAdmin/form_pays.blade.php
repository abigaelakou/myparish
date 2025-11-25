@extends('layouts.master')

@section('main-content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Création Pays</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Pays</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout de pays</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
<div class="container-fluid">
    <h3>Ajouter un Pays</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('pays.store') }}">
        @csrf

        <div class="form-group">
            <label>Nom du pays</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Code (optionnel)</label>
            <input type="text" name="code" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Enregistrer</button>
    </form>

    <hr>

    <h4>Liste des pays</h4>
    <ul>
        @foreach(\App\Models\Pays::orderBy('nom')->get() as $p)
            <li>{{ $p->nom }} ({{ $p->code }})</li>
        @endforeach
    </ul>
</div>
@endsection
