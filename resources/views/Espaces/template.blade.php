@extends('layouts.master')
@section('main-content')
<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Globale</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Statistiques </li>
                        <li class="breadcrumb-item active">Globale</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">

        @if(Auth::check())
        @if(Auth::user()->id_type_utilisateur == 1)

        <!-- *************************** LES ACCES SUPER ADMINS********************************************* -->

        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Super Admins</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_super_ad">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Paroisses Actives</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_paroisse_act">0 </h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroisses Inactives</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroisse_inactive">0</h2><span
                                            class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#add-square"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nvlle
                                    paroisse inscrite</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_new_paroisse">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#edit-2"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @elseif(Auth::user()->id_type_utilisateur == 2)
        <!-- *************************** LES ACCES ADMIN ******************************-->

        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#add-square"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nbre Docs
                                    Archivés</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_doc_archive">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#edit-2"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE DON --}}
        <h4>Statistique des dons</h4>
        <hr>
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
                        @for ($i=2023; $i<=date("Y"); $i++) @if ($i==date("Y")) <option value="{{ $i }}" selected>{{ $i
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
        <div class="row">
            <div class="col-xl-4 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <ul class="product-costing">
                            <li class="product-cost">
                                <div class="product-icon bg-primary-light">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                    </svg>
                                </div>
                                <div><span class="f-w-500 f-14 mb-0">Total Dons reçus</span>
                                    <h2 class="f-w-600" id="nbre_total_don_recu">0</h2>
                                </div>
                            </li>
                            {{-- <li> <span class="f-light f-14 f-w-500">We have sale +18.2k this week.</span></li> --}}
                        </ul>
                        <ul class="product-costing">
                            <li class="product-cost">
                                <div class="product-icon bg-warning-light">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#people')}}"></use>
                                    </svg>
                                </div>
                                <div><span class="f-w-500 f-14 mb-0">Total Montant En caisse</span>
                                    <h2 class="f-w-600" id="dons_recus">0 F</h2>
                                </div>
                            </li>
                            {{-- <li> <span class="f-light f-14 f-w-500">We have total +3.5k visitors this week.</span>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_dons">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE CATECHESE --}}
        <h4>Statistique Catéchèse pour l'année en cours</h4>
        <hr>
        <div class="row">
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="card">
                    <div class="card-header total-revenue card-no-border">
                        <h4>Nombre catéchumènes par session</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Enfant:</span>
                                        <h2 class="f-w-600" id="nombre_enfants">
                                        </h2>
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Jeune: </h2>
                                        </span>
                                        <h2 class="f-w-600" id="nombre_jeunes">
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Adulte : </span>
                                        <h2 class="f-w-600" id="nombre_adultes">0
                                        </h2>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#box-add"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nombre catechumène</h6>
                                        <h2 class="text-strong" id="nombre_catechumene_inscris_annee_en_cours"></h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Montant total généré </h6>

                                        <h2 class="text-strong" id="montant_total_genere_par_catechese_annee_encours">
                                        </h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h4>Statistique financière</h4>
        <hr>
        {{-- STATISTIQUE start_montant_total_annee_encours --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card product-widget">
                    <div class="card-body new-product">
                        <div class="product-cost">
                            <div class="add-product">
                                <div class="product-icon bg-light-primary">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-1">Montant total pour l'année encours </h6>
                                    <h2 class="text-strong" id="montant_total_pour_lannee">0</h2>
                                </div>
                            </div>
                            <div class="product-icon">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card product-widget">
                    <div class="card-body new-product">
                        <div class="product-cost">
                            <div class="add-product">
                                <div class="product-icon bg-light-primary">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-1">Montant total des dépenses pour l'année </h6>
                                    <h2 class="text-strong" id="montantTotalDepenseAnneEncours">0</h2>
                                </div>
                            </div>
                            <div class="product-icon">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card product-widget">
                <div class="card-body new-product">
                    <div class="product-cost">
                        <div class="add-product">
                            <div class="product-icon bg-light-primary">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                </svg>
                            </div>
                            <div>
                                <h6 class="mb-1">Montant total en caise pour l'année </h6>
                                <h2 class="text-strong" id="reste_en_caisse">0</h2>
                            </div>
                        </div>
                        <div class="product-icon">
                            <svg>
                                <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>
        <!-- *************************** LES ACCES CURE ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 3)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#add-square"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nbre Docs
                                    Archivés</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_doc_archive">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#edit-2"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE DON --}}
        <h4>Statistique des dons</h4>
        <hr>
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
                        @for ($i=2023; $i<=date("Y"); $i++) @if ($i==date("Y")) <option value="{{ $i }}" selected>{{ $i
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
        <div class="row">
            <div class="col-xl-4 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <ul class="product-costing">
                            <li class="product-cost">
                                <div class="product-icon bg-primary-light">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                    </svg>
                                </div>
                                <div><span class="f-w-500 f-14 mb-0">Total Dons reçus</span>
                                    <h2 class="f-w-600" id="nbre_total_don_recu">0</h2>
                                </div>
                            </li>
                            {{-- <li> <span class="f-light f-14 f-w-500">We have sale +18.2k this week.</span></li> --}}
                        </ul>
                        <ul class="product-costing">
                            <li class="product-cost">
                                <div class="product-icon bg-warning-light">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#people')}}"></use>
                                    </svg>
                                </div>
                                <div><span class="f-w-500 f-14 mb-0">Total Montant En caisse</span>
                                    <h2 class="f-w-600" id="dons_recus">0 F</h2>
                                </div>
                            </li>
                            {{-- <li> <span class="f-light f-14 f-w-500">We have total +3.5k visitors this week.</span>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_dons">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE CATECHESE --}}
        <h4>Statistique Catéchèse pour l'année en cours</h4>
        <hr>
        <div class="row">
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="card">
                    <div class="card-header total-revenue card-no-border">
                        <h4>Nombre catéchumènes par session</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Enfant:</span>
                                        <h2 class="f-w-600" id="nombre_enfants">
                                        </h2>
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Jeune: </h2>
                                        </span>
                                        <h2 class="f-w-600" id="nombre_jeunes">
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Adulte : </span>
                                        <h2 class="f-w-600" id="nombre_adultes">0
                                        </h2>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#box-add"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nombre catechumène</h6>
                                        <h2 class="text-strong" id="nombre_catechumene_inscris_annee_en_cours"></h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Montant total généré </h6>

                                        <h2 class="text-strong" id="montant_total_genere_par_catechese_annee_encours">
                                        </h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h4>Statistique financière</h4>
        <hr>
        {{-- STATISTIQUE start_montant_total_annee_encours --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card product-widget">
                    <div class="card-body new-product">
                        <div class="product-cost">
                            <div class="add-product">
                                <div class="product-icon bg-light-primary">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-1">Montant total pour l'année encours </h6>
                                    <h2 class="text-strong" id="montant_total_pour_lannee">0</h2>
                                </div>
                            </div>
                            <div class="product-icon">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card product-widget">
                    <div class="card-body new-product">
                        <div class="product-cost">
                            <div class="add-product">
                                <div class="product-icon bg-light-primary">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-1">Montant total des dépenses pour l'année </h6>
                                    <h2 class="text-strong" id="montantTotalDepenseAnneEncours">0</h2>
                                </div>
                            </div>
                            <div class="product-icon">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card product-widget">
                <div class="card-body new-product">
                    <div class="product-cost">
                        <div class="add-product">
                            <div class="product-icon bg-light-primary">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                </svg>
                            </div>
                            <div>
                                <h6 class="mb-1">Montant total en caise pour l'année </h6>
                                <h2 class="text-strong" id="reste_en_caisse">0</h2>
                            </div>
                        </div>
                        <div class="product-icon">
                            <svg>
                                <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>
        <!-- *************************** LES ACCES RESPONSABLE MVT ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 4)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#add-square"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************** LES ACCES PRETRE ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 5)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#add-square"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nbre Docs
                                    Archivés</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_doc_archive">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#edit-2"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE CATECHESE --}}
        <h4>Statistique Catéchèse pour l'année en cours</h4>
        <hr>
        <div class="row">
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="card">
                    <div class="card-header total-revenue card-no-border">
                        <h4>Nombre catéchumènes par session</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Enfant:</span>
                                        <h2 class="f-w-600" id="nombre_enfants">
                                        </h2>
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Jeune: </h2>
                                        </span>
                                        <h2 class="f-w-600" id="nombre_jeunes">
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Adulte : </span>
                                        <h2 class="f-w-600" id="nombre_adultes">0
                                        </h2>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#box-add"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nombre catechumène</h6>
                                        <h2 class="text-strong" id="nombre_catechumene_inscris_annee_en_cours"></h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************** LES ACCES PAROISSIEN ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 6)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************** LES ACCES SECRETAIRE******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 7)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#tick-circle')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nbre Docs
                                    Archivés</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_doc_archive">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#edit-2')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE CATECHESE --}}
        <h4>Statistique Catéchèse pour l'année en cours</h4>
        <hr>
        <div class="row">
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="card">
                    <div class="card-header total-revenue card-no-border">
                        <h4>Nombre catéchumènes par session</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Enfant:</span>
                                        <h2 class="f-w-600" id="nombre_enfants">
                                        </h2>
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Jeune: </h2>
                                        </span>
                                        <h2 class="f-w-600" id="nombre_jeunes">
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Adulte : </span>
                                        <h2 class="f-w-600" id="nombre_adultes">0
                                        </h2>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#box-add"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nombre catechumène</h6>
                                        <h2 class="text-strong" id="nombre_catechumene_inscris_annee_en_cours"></h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************** NON PAROISSIEN ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 8)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="../assets/svg/icon-sprite.svg#tick-circle"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************** RESPONSABLE CATECHESE ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 9)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#tick-circle')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nbre Docs
                                    Archivés</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_doc_archive">0</h2><span class="f-12 f-w-400">
                                        </span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#edit-2')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE CATECHESE --}}
        <h4>Statistique Catéchèse pour l'année en cours</h4>
        <hr>
        <div class="row">
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="card">
                    <div class="card-header total-revenue card-no-border">
                        <h4>Nombre catéchumènes par session</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Enfant:</span>
                                        <h2 class="f-w-600" id="nombre_enfants">
                                        </h2>
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Jeune: </h2>
                                        </span>
                                        <h2 class="f-w-600" id="nombre_jeunes">
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Adulte : </span>
                                        <h2 class="f-w-600" id="nombre_adultes">0
                                        </h2>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#box-add"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nombre catechumène</h6>
                                        <h2 class="text-strong" id="nombre_catechumene_inscris_annee_en_cours"></h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Montant total généré </h6>

                                        <h2 class="text-strong" id="montant_total_genere_par_catechese_annee_encours">
                                        </h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************** VICE RESPO CONSEIL PAROISSIAL ******************************-->
        @elseif(Auth::user()->id_type_utilisateur == 10)
        {{-- STATISTIQUE GLOBALE --}}
        <div class="row size-column">
            <div class="col-xxl-9 box-col-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Mouvts/Groupes</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_mouvement">0 </h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#tick-circle')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Non Paroissiens</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nombre_non_paroissien">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-2"><span class="f-light f-w-500 f-14">Nbre Docs
                                    Archivés</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600" id="nbre_doc_archive">0</h2><span
                                            class="f-12 f-w-400"></span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#edit-2')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE DON --}}
        <h4>Statistique des dons</h4>
        <hr>
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
                        @for ($i=2023; $i<=date("Y"); $i++) @if ($i==date("Y")) <option value="{{ $i }}" selected>{{ $i
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
        <div class="row">
            <div class="col-xl-4 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <ul class="product-costing">
                            <li class="product-cost">
                                <div class="product-icon bg-primary-light">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                    </svg>
                                </div>
                                <div><span class="f-w-500 f-14 mb-0">Total Dons reçus</span>
                                    <h2 class="f-w-600" id="nbre_total_don_recu">0</h2>
                                </div>
                            </li>
                            {{-- <li> <span class="f-light f-14 f-w-500">We have sale +18.2k this week.</span></li> --}}
                        </ul>
                        <ul class="product-costing">
                            <li class="product-cost">
                                <div class="product-icon bg-warning-light">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#people')}}"></use>
                                    </svg>
                                </div>
                                <div><span class="f-w-500 f-14 mb-0">Total Montant En caisse</span>
                                    <h2 class="f-w-600" id="dons_recus">0 F</h2>
                                </div>
                            </li>
                            {{-- <li> <span class="f-light f-14 f-w-500">We have total +3.5k visitors this week.</span>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar" id="liste_dons">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STATISTIQUE CATECHESE --}}
        <h4>Statistique Catéchèse pour l'année en cours</h4>
        <hr>
        <div class="row">
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="card">
                    <div class="card-header total-revenue card-no-border">
                        <h4>Nombre catéchumènes par session</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Enfant:</span>
                                        <h2 class="f-w-600" id="nombre_enfants">
                                        </h2>
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Jeune: </h2>
                                        </span>
                                        <h2 class="f-w-600" id="nombre_jeunes">
                                    </div>
                                </li>

                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#activity')}}"></use>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Adulte : </span>
                                        <h2 class="f-w-600" id="nombre_adultes">0
                                        </h2>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6 box-col-6">
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#box-add')}}"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nombre catechumène</h6>
                                        <h2 class="text-strong" id="nombre_catechumene_inscris_annee_en_cours"></h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#arrow-down')}}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card product-widget">
                        <div class="card-body new-product">
                            <div class="product-cost">
                                <div class="add-product">
                                    <div class="product-icon bg-light-primary">
                                        <svg>
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#receipt-disscount')}}">
                                            </use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Montant total généré </h6>

                                        <h2 class="text-strong" id="montant_total_genere_par_catechese_annee_encours">
                                        </h2>
                                    </div>
                                </div>
                                <div class="product-icon">
                                    <svg>
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#arrow-down')}}"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h4>Statistique financière</h4>
        <hr>
        {{-- STATISTIQUE start_montant_total_annee_encours --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card product-widget">
                    <div class="card-body new-product">
                        <div class="product-cost">
                            <div class="add-product">
                                <div class="product-icon bg-light-primary">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-1">Montant total pour l'année encours </h6>
                                    <h2 class="text-strong" id="montant_total_pour_lannee">0</h2>
                                </div>
                            </div>
                            <div class="product-icon">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card product-widget">
                    <div class="card-body new-product">
                        <div class="product-cost">
                            <div class="add-product">
                                <div class="product-icon bg-light-primary">
                                    <svg>
                                        <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-1">Montant total des dépenses pour l'année </h6>
                                    <h2 class="text-strong" id="montantTotalDepenseAnneEncours">0</h2>
                                </div>
                            </div>
                            <div class="product-icon">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card product-widget">
                <div class="card-body new-product">
                    <div class="product-cost">
                        <div class="add-product">
                            <div class="product-icon bg-light-primary">
                                <svg>
                                    <use href="../assets/svg/icon-sprite.svg#receipt-disscount"></use>
                                </svg>
                            </div>
                            <div>
                                <h6 class="mb-1">Montant total en caise pour l'année </h6>
                                <h2 class="text-strong" id="reste_en_caisse">0</h2>
                            </div>
                        </div>
                        <div class="product-icon">
                            <svg>
                                <use href="../assets/svg/icon-sprite.svg#arrow-down"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Evènements à venir</h4>
        <hr>
        <div class="col-xl-12 col-sm-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar" id="liste_evenement">

                    </div>
                </div>
            </div>
        </div>

        @else
        {{ redirect('/guest') }}
        @endif
        @endif
    </div>
</div>
@endsection

@section('page-js')

@section('scripts')
<script src="{{asset('js/pages_js/statistique.js')}}"></script>
@endsection
@endsection