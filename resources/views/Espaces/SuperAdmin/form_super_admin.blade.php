@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Super Utilisateur</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Utilisateurs</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout d'un super Utilisateur</li>
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
                        <form class="row g-3" action="{{ route('create_super_admin') }}" method="POST">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="name">Nom et prénom(s)</label>
                                <input class="form-control" name="name" type="text" placeholder="Joseph Kouamé"
                                    required="">
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="email">Adresse Email</label>
                                <input class="form-control" name="email" type="email" placeholder="admin@domain.com"
                                    required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="contact">Contact</label>
                                <input class="form-control" name="contact" type="number" placeholder="0700000000"
                                    required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="password">Mot de passe</label>
                                <input class="form-control" name="password" type="password" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="password_confirmation">Confirmez le mot de passe</label>
                                <input class="form-control" name="password_confirmation" type="password" required="">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Créer le Super Admin</button>
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
<script src="{{asset('js/pages_js/users.js')}}"></script>
@endsection