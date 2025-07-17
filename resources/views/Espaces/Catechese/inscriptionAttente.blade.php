@extends('layouts.master')

@section('main-content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Inscription en attente</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Confirmation inscription</li>
                        <li class="breadcrumb-item active"> Inscription catechèse</li>
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
                        <h4 class="center">Confirmation d'inscription catechèse</h4>
                    </div>
                    <div class="card-body">

                        <p>Félicitations!! Votre Inscription est faite mais est en attente de paiement. Veuillez cliquer
                            sur
                            le bouton pour continuer.
                        </p>
                        <form action="{{ route('paiementCompleter') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_inscription" value="{{ $id_inscription }}">
                            <button type="submit" class="btn btn-primary">Payer son inscription</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

@endsection