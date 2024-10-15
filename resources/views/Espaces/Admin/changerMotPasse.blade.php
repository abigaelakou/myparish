@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire mot de passe</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Changement de Mot de Passe</li>
                        <li class="breadcrumb-item active"> Formulaire mot de passe </li>
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
                        <h4>Changer son mot de passe</h4>
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
                        <form class="row g-3" action="{{ route('update_password') }}" method="POST">
                            @csrf
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <div class="media"> <img class="img-70 rounded-circle" alt=""
                                            src="{{ asset('assets/images/dashboard/user.png')}}">
                                        <div class="media-body">
                                            <h5 class="mb-1"></h5>
                                            <p>{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ancien Mot de passe</label>
                                <input class="form-control" type="password" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nouveau Mot de passe</label>
                                <input class="form-control" type="password" value="" name="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmez le mot de passe</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation">
                            </div>
                            <div class="form-footer">
                                <button class="btn btn-primary btn-block" type="submit">Valider</button>
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