@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Affectations</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Affect. Classe et Catechiste</li>
                        <li class="breadcrumb-item active"> Formulaire d'affectation</li>
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
                        <h4>Formulaire d'affectation d'une classe </h4>
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
                        <form action="{{ route('affecter.catechumene') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 position-relative">
                                    <label class="id_catechumene">Sélectionner un catéchumène</label>
                                    <select class="form-select" id="id_catechumene" name="id_catechumene" required="">
                                        <option value="">-- Choisir un catéchumène --</option>
                                        @foreach ($catechumenes as $catechumene)
                                        <option value="{{ $catechumene->id }}">{{ $catechumene->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">Faites un choix svp.</div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <label class="id_classe">Sélectionner une classe</label>
                                    <select class="form-select" id="id_classe" name="id_classe" required="">
                                        <option value="">-- Choisir une classe --</option>
                                        @foreach ($classes as $classe)
                                        <option value="{{ $classe->id }}">{{ $classe->lib_classe_cate }} ({{
                                            $classe->niveau->lib_niveau }} - {{
                                            $classe->session->lib_session_catechese }})</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">Faites un choix svp.</div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button class="btn btn-primary" type="submit">Affecter</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Liste des decision finales-->
    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_decision_final">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


</div>


<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 
</script>

@endsection

@section('scripts')
<script src="{{asset('js/pages_js/catechumene.js')}}" defer></script>
@endsection