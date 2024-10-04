@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formualaire demande messe</h4>
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
                        <form class="row g-3" action="{{ route('store_demande_messe') }}" method="POST">
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
                                <label class="form-label" for="validationTooltip04">Type de intention</label>
                                <select class="form-select" id="id_type_intention" name="id_type_intention" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($type_intentions as $type_intention)
                                    <option id="select_profil{{ $type_intention->id }}"
                                        value="{{ $type_intention->id }}">
                                        {{ $type_intention->lib_type_intention }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Date de la demande</label>
                                <input class="form-control" name="date_messe" id="date_messe" type="date" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Lieu Messe</label>
                                <input class="form-control" name="lieu_messe" id="lieu_messe" type="text" required="">
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="exampleFormControlInput1">Heure Messe</label>
                                <input class="form-control" name="heure_messe" id="heure_messe" type="time" required="">
                            </div>
                            <div class="mb-3">
                                <label for="intentions" class="form-label">Intentions de la messe</label>
                                <textarea name="intentions" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Soumettre la demande</button>
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
<script src="{{asset('js/pages_js/demande_messe.js')}}"></script>
@endsection