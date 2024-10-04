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
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">>
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Membre Mouvement</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout de membre mouvement</li>
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
                        <h4>Membre Mouvement</h4>
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
                        <form class="row g-3" action="{{ route('create_membre_mouv') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Nom et prénom(s)</label>
                                <input class="form-control" name="name_membre" id="validationTooltip01" type="text"
                                    placeholder="Hélène Amey" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Contact</label>
                                <input class="form-control" name="contact" id="validationTooltip02" type="text"
                                    placeholder="0700000000" required="">
                                <div class="valid-tooltip">Bon!</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Role</label>
                                <select class="form-select" id="role_membre validationTooltip04" name="role_membre"
                                    required="">
                                    <option value="">choisir...</option>
                                    <option value="MEMBRE SIMPLE">MEMBRE SIMPLE</option>
                                    <option value="RESPONSABLE">RESPONSABLE</option>
                                    <option value="MEMBRE BUREAU">MEMBRE BUREAU</option>
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Mouvement</label>
                                <select class="form-select" id="id_mouvement validationTooltip04" name="id_mouvement"
                                    required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($mouvements as $mouvement)
                                    <option id="select_profil{{ $mouvement->id }}" value="{{ $mouvement->id }}">
                                        {{ $mouvement->lib_mouvement }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Date d'inscription</label>
                                <input class="form-control" name="date_inscription" id="date_inscription" type="date"
                                    placeholder="" required="">
                            </div>
                            <div class="col-12">
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
</script>
@endsection

@section('page-js')

<script src="{{asset('js/pages_js/mouvement.js')}}"></script>
@endsection