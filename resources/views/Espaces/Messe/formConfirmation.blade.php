@extends('layouts.master')

@section('main-content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Confirmation de paiement</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Demande Messe</li>
                        <li class="breadcrumb-item active"> Confirmation de paiement</li>
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
                        <h4 class="center">DEMANDE DE MESSE</h4>
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
                        <div class="container">
                            <h1>Confirmation de paiement</h1>
                            <p>Merci pour votre paiement!</p>

                            @if(isset($transactionDetails))
                            <h3>Détails de transaction:</h3>
                            <ul>
                                <li>Transaction: {{ $transactionDetails['transaction_id'] }}</li>
                                <li>Montant: {{ $transactionDetails['amount'] }}</li>
                                <li>Méthode de paiement: {{ ucfirst($transactionDetails['moyen_paiement']) }}</li>
                                <li>Date: {{ $transactionDetails['date'] }}</li>
                            </ul>
                            <a href="{{ route('formDemandeMesse') }}" class="btn btn-primary">Faire une autre
                                Demande? </a>
                            @else
                            <p>Aucun détail de transaction disponible.</p>
                            @endif
                        </div>
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