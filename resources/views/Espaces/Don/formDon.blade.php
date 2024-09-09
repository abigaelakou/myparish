@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formualaire de don ou offrande</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dons ou offrandes</li>
                        <li class="breadcrumb-item active"> Formulaire de dons</li>
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
                        <h4>Dons </h4>
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
                        <form class="row g-3" action="{{ route('process') }}" method="POST">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="id_type_don">Type de Don:</label>
                                <select class="form-select" id="id_type_don" name="id_type_don" required>
                                    <!-- Charger dynamiquement les types de dons depuis la base de données -->
                                    @foreach($typesDons as $typeDon)
                                    <option value="{{ $typeDon->id }}">{{ $typeDon->lib_type_don }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="type_donateur">Type de Donateur:</label>
                                <select class="form-select" id="type_donateur" name="type_donateur" required>
                                    <option value="paroissien">Paroissien</option>
                                    <option value="non_paroissien">Non-Paroissien</option>
                                </select>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="montant">Montant du Don:</label>
                                <input type="number" class="form-control" id="montant" name="montant" required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="mode_paiement">Mode de Paiement:</label>
                                <select class="form-select" id="mode_paiement" name="mode_paiement" required>
                                    <option value="moov">Moov</option>
                                    <option value="orange">Orange Money</option>
                                    <option value="mtn">MTN Money</option>
                                    <option value="wave">Wave</option>
                                </select>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="contact">Contact:</label>
                                <input type="number" class="form-control" id="contact" name="contact" required>
                            </div>


                            {{-- <div class="col-md-4 position-relative">
                                <input type="hidden" class="form-control" id="donateur_id" name="donateur_id">
                                <label for="type_donateur">Nom Donateur:</label>
                                <select class="form-select" id="donateur_id" name="donateur_id">
                                    @foreach($userDons as $userDon)
                                    <option value="">Anonyme</option>
                                    <option value="{{ $userDon->id }}">{{ $userDon->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-12 position-relative">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="anonymous_donation">
                                    <input type="checkbox" id="anonymous_donation" name="anonymous_donation" value="1">
                                    Faire un don anonyme
                                </label>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Faire un don ou offrande</button>
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

@section('scripts')
<script src="{{asset('js/pages_js/messe.js')}}"></script>
@endsection