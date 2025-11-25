@extends('layouts.master')

@section('main-content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Création Diocese</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Diocese</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout de diocese</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
<div class="container-fluid">
    <h3>Ajouter un Diocèse</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('dioceses.store') }}">
        @csrf

        <div class="form-group">
            <label>Pays</label>
            <select name="pays_id" class="form-control" required>
                <option value="">-- Choisir un pays --</option>
                @foreach(\App\Models\Pays::orderBy('nom')->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label>Nom du diocèse</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <button class="btn btn-primary mt-3">Enregistrer</button>
    </form>

    <hr>

    <h4>Liste des diocèses</h4>

    <ul>
        @foreach(\App\Models\Diocese::with('pays')->orderBy('nom')->get() as $d)
            <li>
                {{ $d->nom }}  
                — <strong>{{ $d->pays->nom }}</strong>
            </li>
        @endforeach
    </ul>

</div>
@endsection
