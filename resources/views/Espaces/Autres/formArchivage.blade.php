@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire d'archivage de documents</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Archivage</li>
                        <li class="breadcrumb-item active"> Formulaire d'archivage</li>
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
                        <h4>Documents </h4>
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
                        <form class="row g-3" action="{{ route('store_archivage') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label for="lib_evenement">Titre du document:</label>
                                <input type="text" class="form-control" id="lib_document" name="lib_document" required>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label for="date_archivage">Date d'archivage:</label>
                                <input type="date" class="form-control" id="date_archivage" name="date_archivage"
                                    required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="fichier">Fichier :</label>
                                <input type="file" class="form-control" id="fichier" name="fichier" required>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-warning" type="submit">Archiver</button>
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