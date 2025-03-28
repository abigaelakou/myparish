@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Enregistrement de catechumène</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Ajout de catechumène</li>
                        <li class="breadcrumb-item active">Enregistrement de catechumène</li>
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
                        <h4>Info catechumène </h4>
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
                        <form class="row g-3" action="{{ route('store_catechumene') }}" method="POST">
                            @csrf
                            <div class="col-md-3 position-relative">
                                <label for="name">Nom & Prénom(s):</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="contact">Contact:</label>
                                <input type="number" class="form-control" id="contact" name="contact">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="montant">Email:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="sacrement_recu">Sacrements reçus:</label>
                                <select class="form-select" id="sacrement_recu" name="sacrement_recu[]" multiple
                                    required>
                                    <option value="AUCUN">AUCUN</option>
                                    <option value="BAPTEME">BAPTEME</option>
                                    <option value="CONFIRMATION">CONFIRMATION</option>
                                    <option value="EUCHARISTIE">EUCHARISTIE</option>
                                    <option value="MARIAGE">MARIAGE</option>
                                    <option value="ONCTION DES MALADES">ONCTION DES MALADES</option>
                                    <option value="RECONCILIATION">RECONCILIATION</option>
                                </select>
                            </div>

                            {{-- <h4>Info Parents</h4> --}}
                            <div class="card-header">
                                <h4>Info Parents </h4>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="nom_prenom_pere">Nom & Prénom(s) Père:</label>
                                <input type="text" class="form-control" id="nom_prenom_pere" name="nom_prenom_pere"
                                    required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="contact_pere">Contact Père:</label>
                                <input type="number" class="form-control" id="contact_pere" name="contact_pere">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="nom_prenom_mere">Nom & Prénom(s) Mère:</label>
                                <input type="text" class="form-control" id="nom_prenom_mere" name="nom_prenom_mere"
                                    required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="contact_mere">Contact Mère:</label>
                                <input type="number" class="form-control" id="contact_mere" name="contact_mere">
                            </div>

                            {{-- <h4>Info Parain/Maraine</h4> --}}
                            <div class="card-header">
                                <h4>Info Parain/Maraine</h4>
                            </div>
                            <div class="col-md-5 position-relative">
                                <label for="nom_prenom_parain">Nom & Prénom(s) :</label>
                                <input type="text" class="form-control" id="nom_prenom_parain" name="nom_prenom_parain">
                            </div>
                            <div class="col-md-5 position-relative">
                                <label for="contact_parain">Contact :</label>
                                <input type="number" class="form-control" id="contact_parain" name="contact_parain">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Ajouter</button>
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

@endsection