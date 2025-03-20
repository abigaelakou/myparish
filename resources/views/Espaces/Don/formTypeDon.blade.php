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
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Type Don </li>
                        <li class="breadcrumb-item active"> Formulaire de Type Don</li>
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Type Don</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('create_type_don') }}" method="POST" id="">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="validationTooltip01">Type Don</label>
                                <input class="form-control" name="lib_type_don" id="validationTooltip01" type="text"
                                    placeholder="Don pour la construction de la cathédrale" required="">
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
                        <h4>Liste des type Don</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_type_dons">

                        </div>
                    </div>
                    {{-- Modification --}}
                    <div class="modal fade" id="editTypeDonModal" tabindex="-1" role="dialog"
                        aria-labelledby="editTypeDonModal" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                    <h3 class="modal-header justify-content-center border-0">Modification de Type Don
                                    </h3>
                                    <div class="modal-body">
                                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                                            action="{{ route('update_type_don') }}" id="editTypeDonForm">
                                            @csrf
                                            <div class="col-md-10 position-relative">
                                                <input type="hidden" name="id_type_don" id="id_type_don">
                                                <label class="form-label" for="validationTooltip01">Nom
                                                    Type Don</label>
                                                <input class="form-control" name="modif_lib_type_don"
                                                    id="modif_lib_type_don" type="text" required="">
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
<script src="{{asset('js/pages_js/type_don.js')}}"></script>
@endsection