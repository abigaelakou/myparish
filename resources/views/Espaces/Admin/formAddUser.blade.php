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
                        <li class="breadcrumb-item"> Utilisateurs</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout d'utilisateur</li>
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
                        <h4>Utilisateur</h4>
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
                        <form class="row g-3" action="{{ route('create_user') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Nom et prénom(s)</label>
                                <input class="form-control" name="name" id="validationTooltip01" type="text"
                                    placeholder="Joseph Kouamé" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Contact</label>
                                <input class="form-control" name="contact" id="validationTooltip02" type="text"
                                    placeholder="0700000000" required="">
                                <div class="valid-tooltip">Bon!</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="inputPassword2">Mot de passe</label>
                                <input class="form-control" name="password" id="inputPassword2" type="password"
                                    required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="inputPassword2">Confirmez le mot de passe</label>
                                <input class="form-control" name="password_confirmation" id="password_confirmation"
                                    type="password" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Adresse Email</label>
                                <input class="form-control" name="email" id="email" type="email"
                                    placeholder="pesamof475@gmail.com" required="">
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Profil</label>
                                <select class="form-select" id="id_type_utilisateur validationTooltip04"
                                    name="id_type_utilisateur" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($type_utilisateurs as $type_utilisateur)
                                    <option id="select_profil{{ $type_utilisateur->id }}"
                                        value="{{ $type_utilisateur->id }}">
                                        {{ $type_utilisateur->lib_type_utilisateur }}
                                    </option>
                                    @endforeach
                                </select>


                                <div class="invalid-tooltip">Faites un choix svp.</div>
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

<script src="{{asset('js/pages_js/users.js')}}"></script>
@endsection