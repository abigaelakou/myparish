@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formualaire d'ajout</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Messe</li>
                        <li class="breadcrumb-item active"> Formulaire de création messe</li>
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
                        <form class="row g-3" action="{{ route('create_messe') }}" method="POST">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Type de messe</label>
                                <select class="form-select" id="id_type_messe" name="id_type_messe" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($type_de_messes as $type_de_messe)
                                    <option id="select_profil{{ $type_de_messe->id }}" value="{{ $type_de_messe->id }}">
                                        {{ $type_de_messe->lib_type_messe }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Date Messe</label>
                                <input class="form-control" name="date_messe" id="date_messe" type="date" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Lieu Messe</label>
                                <input class="form-control" name="lieu_messe" id="lieu_messe" type="text" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Heure</label>
                                <input class="form-control" name="heure_messe" id="heure_messe" type="time" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="validationTooltip04">Celebrant</label>
                                <select class="form-select" id="id_celebrant" name="id_celebrant" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($celebrants as $celebrant)
                                    <option value="{{ $celebrant->id }}">
                                        {{ $celebrant->name }} - {{ $celebrant->lib_type_utilisateur }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Créer la messe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_toutes_messes">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL MODIFICATION --}}
        <div class="modal fade" id="editMesseModal" tabindex="-1" role="dialog" aria-labelledby="editMesseModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                        <h3 class="modal-header justify-content-center border-0">Modification de messe</h3>
                        <div class="modal-body">
                            <form class="row g-3 needs-validation" novalidate="" method="POST"
                                action="{{ route('update_messe') }}" id="form_modif_messe">
                                @csrf
                                <div class="col-md-4 position-relative">
                                    <input type="hidden" name="id_messe" id="id_messe">
                                    <label class="form-label" for="validationTooltip04">Type de messe</label>
                                    <select class="form-select" id="modif_id_type_messe" name="modif_id_type_messe"
                                        required="">
                                        <option selected="" disabled="" value="">choisir...</option>
                                        @foreach ($type_de_messes as $type_de_messe)
                                        <option id="select_profil{{ $type_de_messe->id }}"
                                            value="{{ $type_de_messe->id }}">
                                            {{ $type_de_messe->lib_type_messe }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">Faites un choix svp.</div>
                                </div>
                                <div class="col-md-4 position-relative">
                                    <label class="form-label" for="exampleFormControlInput1">Date Messe</label>
                                    <input class="form-control" name="modif_date_messe" id="modif_date_messe"
                                        type="date" required="">
                                </div>
                                <div class="col-md-4 position-relative">
                                    <label class="form-label" for="exampleFormControlInput1">Lieu Messe</label>
                                    <input class="form-control" name="modif_lieu_messe" id="modif_lieu_messe"
                                        type="text" required="">
                                </div>
                                <div class="col-md-4 position-relative">
                                    <label class="form-label" for="exampleFormControlInput1">Heure</label>
                                    <input class="form-control" name="modif_heure_messe" id="modif_heure_messe"
                                        type="time" required="">
                                </div>
                                <div class="col-md-4 position-relative">
                                    <label class="form-label" for="validationTooltip04">Celebrant</label>
                                    <select class="form-select" id="modif_id_celebrant" name="modif_id_celebrant"
                                        required="">
                                        <option selected="" disabled="" value="">choisir...</option>
                                        @foreach ($celebrants as $celebrant)
                                        <option value="{{ $celebrant->id }}">
                                            {{ $celebrant->name }} - {{ $celebrant->lib_type_utilisateur }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">Faites un choix svp.</div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Valider</button>
                                </div>
                            </form>
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
<script src="{{asset('js/pages_js/messe.js')}}"></script>
@endsection