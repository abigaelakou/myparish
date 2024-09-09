@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formualire d'ajout</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Type/messe et intention </li>
                        <li class="breadcrumb-item active"> Formulaire de Type/messe et intention</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
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
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Type Messe</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('create_type_messe') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="validationTooltip01">Type messe</label>
                                <input class="form-control" name="lib_type_messe" id="validationTooltip01" type="text"
                                    placeholder="Messe dominicale" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Liste des type Messes</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_des_type_messe">

                        </div>
                    </div>
                    {{-- Modification --}}
                    <div class="modal fade" id="editTypeMesseModal" tabindex="-1" role="dialog"
                        aria-labelledby="editTypeMesseModal" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                    <h3 class="modal-header justify-content-center border-0">Modification de Type Messe
                                    </h3>
                                    <div class="modal-body">
                                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                                            action="{{ route('update_type_messe') }}" id="editTypeMesseForm">
                                            @csrf
                                            <div class="col-md-6 position-relative">
                                                <input type="hidden" name="id_type_messe" id="id_type_messe">
                                                <label class="form-label" for="validationTooltip01">Nom
                                                    Type Messe</label>
                                                <input class="form-control" name="modif_lib_type_messe"
                                                    id="modif_lib_type_messe" type="text" required="">
                                                <div class="valid-tooltip">Bon !</div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit">Modifier</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Type Intention de messe</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('create_type_intention') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="validationTooltip01">Type Intention</label>
                                <input class="form-control" name="lib_type_intention" id="validationTooltip01"
                                    type="text" placeholder="Action de graces" required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Liste des type d'intension de messes</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_type_intention_messe">

                        </div>
                    </div>

                    {{-- Modification --}}
                    <div class="modal fade" id="editTypeIntentionModal" tabindex="-1" role="dialog"
                        aria-labelledby="editTypeIntentionModal" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                    <h3 class="modal-header justify-content-center border-0">Modification de Mouvement
                                    </h3>
                                    <div class="modal-body">
                                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                                            action="{{ route('update_type_intention') }}" id="editTypeIntentionForm">
                                            @csrf
                                            <div class="col-md-6 position-relative">
                                                <input type="hidden" name="id_type_intention" id="id_type_intention">
                                                <label class="form-label" for="validationTooltip01">Nom
                                                    Type Intention</label>
                                                <input class="form-control" name="modif_lib_type_intention"
                                                    id="modif_lib_type_intention" type="text" required="">
                                                <div class="valid-tooltip">Bon !</div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit">Modifier</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
<script src="{{asset('js/pages_js/type_messe_intention.js')}}"></script>
@endsection