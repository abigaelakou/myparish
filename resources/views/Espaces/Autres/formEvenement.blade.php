@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire de creation d'évènement</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Evènement</li>
                        <li class="breadcrumb-item active"> Formulaire d'évènement</li>
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
                        <h4>Evenements </h4>
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
                        <form class="row g-3" action="{{ route('store_evenement') }}" method="POST">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label for="lib_evenement">Titre de l'évènement:</label>
                                <input type="text" class="form-control" id="lib_evenement" name="lib_evenement"
                                    required>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label for="date_evenement">Date d'évènement:</label>
                                <input type="date" class="form-control" id="date_evement" name="date_evement" required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="heure_evenement">Heure de l'évènement:</label>
                                <input type="time" class="form-control" id="heure_evenement" name="heure_evenement"
                                    required>
                            </div>
                            <div class="col-md-12 position-relative">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning" type="submit">Enregistrer</button>
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
<script src="{{asset('js/pages_js/evenement.js')}}"></script>
@endsection