@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Créa Compte Paroisse</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Paroisse</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout Paroisse</li>
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
                        <form class="row g-3" action="{{ route('create_paroisse') }}" method="POST">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="nom_paroisse">Nom Paroisse</label>
                                <input class="form-control" name="nom_paroisse" type="text"
                                    placeholder="Paroisse Saint Louis" required="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="adresse">Adresse </label>
                                <input class="form-control" name="adresse" type="text" placeholder="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="contact">Contact</label>
                                <input class="form-control" name="contact" type="number" placeholder="0700000000">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="email">Adresse Email</label>
                                <input class="form-control" name="email" type="email" placeholder="admin@domain.com"
                                    required="">
                            </div>
                            <div class="card-header">
                                <h4>Création de l'utilisateur admin associé à la paroisse</h4>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip01">Nom et prénom(s)</label>
                                <input class="form-control" name="admin_name" id="admin_name" type="text"
                                    placeholder="Joseph Kouamé" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip02">Contact</label>
                                <input class="form-control" name="admin_contact" id="admin_contact" type="number"
                                    placeholder="0700000000" required="">
                                <div class="valid-tooltip">Bon!</div>
                            </div>
                        
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Adresse Email</label>
                                <input class="form-control" name="admin_email" id="admin_email" type="email"
                                    placeholder="pesamof475@gmail.com" required="">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Créer la paroisse</button>
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

@endsection