@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formualaire paiement catechese</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Complèter</li>
                        <li class="breadcrumb-item active">Paiment inscription</li>
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
                        <h4>Suite inscription </h4>
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

                        @if (isset($paiement))
                        <form class="row g-3" action="{{ route('validation_paiementCatechese') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_inscription" value="{{ $paiement->id_inscription }}">

                            <div class="col-md-3 position-relative">
                                <label for="montant">Montant à payer :</label>
                                <input type="text" class="form-control" name="montant" value="{{ $paiement->montant }}">
                            </div>

                            <div class="col-md-3 position-relative">
                                <label for="contact">Numéro de téléphone :</label>
                                <input type="tel" class="form-control" name="contact" value="{{ old('contact') }}"
                                    pattern="[0-9]{8,14}" required
                                    title="Veuillez entrer un numéro de téléphone valide entre 8 et 14 chiffres">
                                @error('contact')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3 position-relative">
                                <label for="mode_paiement">Mode de paiement :</label>
                                <select class="form-select" name="mode_paiement" required>
                                    <option value="" disabled selected>Choisissez un mode de paiement</option>
                                    <option value="moov">Moov</option>
                                    <option value="orange">Orange</option>
                                    <option value="mtn">MTN</option>
                                    <option value="wave">Wave</option>
                                </select>
                                @error('mode_paiement')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Payer</button>
                            </div>
                        </form>
                        @else
                        <p>Les informations de paiement ne sont pas disponibles.</p>
                        @endif

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