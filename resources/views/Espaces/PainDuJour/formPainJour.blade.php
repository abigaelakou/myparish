@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire de creation pain du Jour</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Pain Du jour</li>
                        <li class="breadcrumb-item active"> Formulaire de Pain Du Jour</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                @if ($painAujourdhui)
                <div class="alert alert-info">
                    <strong>Pain du jour déjà publié pour aujourd’hui.</strong>
                    <span class="badge bg-{{ $painAujourdhui->est_auto ? 'secondary' : 'success' }}">
                        {{ $painAujourdhui->est_auto ? 'Automatique' : 'Manuel' }}
                    </span>
                </div>

                @if ($painAujourdhui->est_auto)
                    <form method="GET" action="{{ route('remplacer_pain_auto', $painAujourdhui->id) }}">
                        <button class="btn btn-warning mb-3" type="submit">Remplacer le message automatique</button>
                    </form>
                @endif
            @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Pain Du Jour </h4>
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
                        <form class="row g-3" action="{{ route('store_pain_jour') }}" method="POST">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label for="titre">Titre du Pain Jour:</label>
                                <input type="text" class="form-control" id="titre" name="titre"
                                    required>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label for="date_pain">Date P J:</label>
                                <input type="date" class="form-control" id="date_pain" name="date_pain" required>
                            </div>
                            
                            <div class="col-md-12 position-relative">
                                <label for="contenu">Contenu du Pain Du Jour:</label>
                                <textarea class="form-control" id="contenu" name="contenu"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning" type="submit">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->

    <hr class="mt-5 mb-4">

<h5>Historique des Pains du Jour</h5>
<form method="GET" action="{{ route('formPainJour') }}" class="row g-3 mb-3">
    <div class="col-auto">
        <label for="filtre_date" class="col-form-label">Filtrer par date :</label>
    </div>
    <div class="col-auto">
        <input type="date" name="filtre_date" id="filtre_date" class="form-control"
               value="{{ request('filtre_date') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        <a href="{{ route('formPainJour') }}" class="btn btn-secondary">Réinitialiser</a>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Titre</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pains as $pain)
            <tr>
                <td>{{ \Carbon\Carbon::parse($pain->date_pain)->format('d/m/Y') }}</td>
                <td>{{ $pain->titre }}</td>
                <td>
                    <span class="badge bg-{{ $pain->est_auto ? 'secondary' : 'success' }}">
                        {{ $pain->est_auto ? 'Automatique' : 'Manuel' }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Aucun message publié pour le moment.</td>
            </tr>
        @endforelse
    </tbody>
    <div class="mt-3">
        {{ $pains->withQueryString()->links() }}
    </div>

</table>

</div>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 
</script>

@endsection

@section('scripts')
<script src="{{asset('js/pages_js/pain.js')}}"></script>
@endsection