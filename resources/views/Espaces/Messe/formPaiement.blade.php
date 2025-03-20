@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire demande messe</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Demande Messe</li>
                        <li class="breadcrumb-item active"> Formulaire de demande messe</li>
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
                        <h4>Messe</h4>
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
                        <form action="{{ route('processPaiement') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_demande" value="{{ $demande->id }}">

                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant à payer</label>
                                <input type="number" name="montant" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Numéro de téléphone</label>
                                <input type="text" name="contact" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="moyen_paiement" class="form-label">Moyen de paiement</label>
                                <select name="moyen_paiement" class="form-select" required>
                                    <option value="moov">Moov</option>
                                    <option value="orange">Orange</option>
                                    <option value="mtn">MTN</option>
                                    <option value="wave">Wave</option>
                                </select>
                            </div>
                            <button class="btn btn-secondary" onclick="history.back()">Retour</button>
                            <button type="submit" class="btn btn-primary">Payer</button>
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