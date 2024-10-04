@extends('layouts.master')

@section('main-content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Formulaire des décision fin d'année</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Décision Fin d'année</li>
                        <li class="breadcrumb-item active"> Formulaire d'ajout</li>
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
                        {{-- <h4>Info catechumène </h4> --}}
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
                        <form class="row g-3" action="{{ route('enregistrerDecision') }}" method="POST">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label for="annee_catechetique">Année catechetique:</label>
                                <select class="form-select" id="annee_catechetique" name="annee_catechetique" readonly>
                                    <option value="{{ $anneeCatechetique_new }}">{{ $anneeCatechetique_new }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="id_catechumene">Nom catechumène</label>
                                <select class="form-select" id="id_catechumene" name="id_catechumene" required="">
                                    <option selected="" disabled="" value="">choisir...</option>
                                    @foreach ($catecheses_new as $catechumene)
                                    <option value="{{ $catechumene->id }}">
                                        {{ $catechumene->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="total_presence_catechese">Total Présence Catechèse:</label>
                                <input type="number" class="form-control" id="total_presence_catechese"
                                    name="total_presence_catechese">
                            </div>

                            <div class="col-md-3 position-relative">
                                <label for="total_presence_messes">Total Présence Messe:</label>
                                <input type="number" class="form-control" id="total_presence_messes"
                                    name="total_presence_messes" required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="total_presence_ceb">Total Présence CEB:</label>
                                <input type="number" class="form-control" id="total_presence_ceb"
                                    name="total_presence_ceb">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="moy_final">Moyenne Finale:</label>
                                <input type="text" class="form-control" id="moy_final" name="moy_final" required>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="decision_finale">Décision Finale</label>
                                <select class="form-select" id="decision_finale" name="decision_finale" required="">
                                    <option value="">choisir...</option>
                                    <option value="Admis">Admis(e)</option>
                                    <option value="Recalé">Recalé(e)</option>
                                    <option value="Abandon">Abandon</option>
                                    <option value="Clôturé">Clôturé(e)</option>
                                </select>
                                <div class="invalid-tooltip">Faites un choix svp.</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-secondary" type="submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Liste des decision finales-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_decision_final">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- catechumenes ayant fini ou abandoné --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Liste des catechumènes ayant finis ou abandonnés</h3>
                        <div class="table-responsive custom-scrollbar" id="liste_catechumne_fini_abandon">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->

{{-- MODAL DE MODIFICATION --}}
<div class="modal fade modal-lg" id="editDecisionModal" tabindex="-1" role="dialog" aria-labelledby="editDecisionModal"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0">Modification de la décision finale</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate="" method="POST"
                        action="{{ route('update_decision') }}" id="editDecisionForm">
                        @csrf
                        <input type="hidden" id="id_decisions_catechese" name="id_decisions_catechese">
                        <div class="col-md-4 position-relative">
                            <label class="modif_id_catechumene">Nom catechumène</label>
                            <select class="form-select" id="modif_id_catechumene" name="modif_id_catechumene"
                                required="">
                                <option selected="" disabled="" value="">choisir...</option>
                                @foreach ($catecheses_new as $catechumene)
                                <option value="{{ $catechumene->id }}">
                                    {{ $catechumene->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-tooltip">Faites un choix svp.</div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="modif_total_presence_catechese">Total Presence catechese:</label>
                            <input type="number" class="form-control" id="modif_total_presence_catechese"
                                name="modif_total_presence_catechese" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="modif_total_presence_messes">Total Présence Messe:</label>
                            <input type="number" class="form-control" id="modif_total_presence_messes"
                                name="modif_total_presence_messes" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="modif_total_presence_ceb">Total Presence CEB:</label>
                            <input type="number" class="form-control" id="modif_total_presence_ceb"
                                name="modif_total_presence_ceb" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="modif_moy_final">Moyenne Finale:</label>
                            <input type="text" class="form-control" id="modif_moy_final" name="modif_moy_final"
                                required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="modif_decision_finale">Sacrements reçus :</label>
                            <select class="form-select" name="modif_decision_finale" id="modif_decision_finale"
                                required>
                                <option value="">choisir...</option>
                                <option value="Admis">Admis(e)</option>
                                <option value="Recalé">Recalé(e)</option>
                                <option value="Abandon">Abandon</option>
                                <option value="Clôturé">Clôturé(e)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-secondary" type="submit">Modifier</button>
                        </div>
                    </form>
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
<script src="{{asset('js/pages_js/catechumene.js')}}" defer></script>
@endsection