@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire d'inscription à la catechèse</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Enregistrement inscription</li>
                        <li class="breadcrumb-item active"> Inscription</li>
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
                        <h4>Inscription catéchèse </h4>
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
                        <form class="row g-3" action="{{ route('store_inscription') }}" method="POST">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label for="annee_catechetique">Année catechetique:</label>
                                <select class="form-select" id="annee_catechetique" name="annee_catechetique" readonly>
                                    <option value="{{ $anneeCatechetique }}">{{ $anneeCatechetique }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Nom catechumène</label>
                                <select class="form-select" id="id_catechumene" name="id_catechumene" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($catecheses as $catechumene)
                                    <option value="{{ $catechumene->id }}">
                                        {{ $catechumene->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Niveau catechetique</label>
                                <select class="form-select" id="id_niveau" name="id_niveau" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($niveau_catecheses as $niveau_catechese)
                                    <option value="{{ $niveau_catechese->id }}">
                                        {{ $niveau_catechese->lib_niveau }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Session catechetique</label>
                                <select class="form-select" id="id_session" name="id_session" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($session_catecheses as $session_catechese)
                                    <option value="{{ $session_catechese->id }}">
                                        {{ $session_catechese->lib_session_catechese }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="date_inscription">Date d'inscription:</label>
                                <input type="date" class="form-control" id="date_inscription" name="date_inscription"
                                    required>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Ajouter</button>
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
</script>

@endsection

@section('scripts')

@endsection