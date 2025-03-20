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
                        <li class="breadcrumb-item"> Liste des dépenses</li>
                        <li class="breadcrumb-item active"> Dépenses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        {{-- LISTE DEPENSE MENSUELLE --}}
        <h4>Liste des dépenses mensuelles</h4>
        <hr>

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            @php
                            $mois=["","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Décembre"];
                            $mois_encour=date("m");
                            settype($mois_encour,"integer");

                            @endphp
                            <label for="my-select">Mois</label>
                            <select id="mois" class="form-select" name="mois">
                                @for ($i = 0; $i <=12; $i++) @if ($i==$mois_encour) <option value="{{ $i }}" selected>{{
                                    $mois[$i] }}
                                    </option>
                                    @else
                                    <option value="{{ $i }}">{{ $mois[$i] }}</option>

                                    @endif

                                    @endfor
                                    {{-- <option value="tous_les_mois">Tous les mois</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="my-select">Année</label>
                            <select id="annee" class="form-select" name="annee">
                                @for ($i=2023; $i<=date("Y"); $i++) @if ($i==date("Y")) <option value="{{ $i }}"
                                    selected>{{ $i
                                    }}
                                    </option>
                                    @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_depenses_mensuelles">

                        </div>
                    </div>
                </div>
                {{-- LISTE DEPENSE Année encours --}}
                <h4>Liste des dépenses pour l'année en cours</h4>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="listeDepensesAnneeEnCours">

                        </div>
                    </div>
                </div>

                {{-- LISTE TOUTES LES DEPENSES --}}
                <h4>Liste de toutes dépenses </h4>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="listeToutesDepenses">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    {{-- Modification --}}
    <div class="modal fade" id="editDepenseModal" tabindex="-1" role="dialog" aria-labelledby="editDepenseModal"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Modification de dépense
                    </h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('update_depense') }}" id="editDepenseForm">
                            @csrf
                            <div class="col-md-12 position-relative">
                                <input type="hidden" name="id_depense" id="id_depense">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="modif_description"
                                    name="modif_description"></textarea>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="validationTooltip01">Montant:</label>
                                <input class="form-control" name="modif_montant" id="modif_montant" type="number"
                                    required="">
                                <div class="valid-tooltip">Bon !</div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="validationTooltip01">Date Dépense:</label>
                                <input class="form-control" name="modif_date_depense" id="modif_date_depense"
                                    type="date" required="">
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
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 
</script>

@endsection

@section('scripts')
<script src="{{asset('js/pages_js/depense.js')}}"></script>
@endsection