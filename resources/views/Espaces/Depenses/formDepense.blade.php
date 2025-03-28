@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Dépenses</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Formulaire dépenses</li>
                        <li class="breadcrumb-item active"> Dépenses</li>
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
                        <h4>Dépenses </h4>
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
                        <form class="row g-3" action="{{ route('storeDepense') }}" method="POST">
                            @csrf
                            <div class="col-md-12 position-relative">
                                <label for="description">Description de la dépense:</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="montant">Montant de la dépense:</label>
                                <input type="number" class="form-control" id="montant" name="montant" required>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label for="date_depense">Date de la dépense:</label>
                                <input type="date" class="form-control" id="date_depense" name="date_depense" required>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <h4>La liste des dépenses mensuelle</h4>
        <hr>
        {{-- LISTE DEPENSE MENSUELLE --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_depenses_mensuelles">

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

@section('scripts')
<script src="{{asset('js/pages_js/depense.js')}}"></script>
@endsection