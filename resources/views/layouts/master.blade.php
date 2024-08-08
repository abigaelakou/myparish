<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Riho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Riho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/logo/logo2.png" type="image/x-icon') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo2.png" type="image/x-icon') }}">
    <title>PAROISSE SMART</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <!-- Range slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/rangeslider/rSlider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/fullcalender.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader4"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="Search Riho .." name="q" title="" autofocus="">
                                <div class="spinner-border Typeahead-spinner" role="status"><span
                                        class="sr-only">Loading... </span></div><i class="close-search"
                                    data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"> </div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"> <a href="index.html"><img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo_dark.png')}}" alt="logo-light"><img
                                class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo.png')}}"
                                alt="logo-dark"></a>
                    </div>
                    <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>
                <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                    <div> <a class="toggle-sidebar" href="#"> <i class="iconly-Category icli"> </i></a>
                        <div class="d-flex align-items-center gap-2 ">
                            <h4 class="f-w-600">Bienvenu {{ Auth::user()->name }}</h4><img class="mt-0"
                                src="{{ asset('assets/images/hand.gif')}}" alt="hand-gif">
                        </div>
                    </div>
                    <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Nous sommes
                            heureux de vous revoir. </span></div>
                </div>
                <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                    <ul class="nav-menus">
                        <li class="d-md-none d-block">
                            <div class="form search-form mb-0">
                                <div class="input-group"> <span class="input-show">
                                        <svg id="searchIcon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#search-header')}}"></use>
                                        </svg>
                                        <div id="searchInput">
                                            <input type="search" placeholder="Search">
                                        </div>
                                    </span></div>
                            </div>
                        </li>

                        <li>
                            <div class="mode"><i class="moon" data-feather="moon"> </i></div>
                        </li>

                        <li class="profile-nav onhover-dropdown">
                            <div class="media profile-media"><img class="b-r-10"
                                    src="{{ asset('assets/images/dashboard/profile.png')}}" alt="">
                                <div class="media-body d-xxl-block d-none box-col-none">
                                    <div class="d-flex align-items-center gap-2"> <span>Alex Mora </span><i
                                            class="middle fa fa-angle-down"> </i></div>
                                    <p class="mb-0 font-roboto">Admin</p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="user-profile.html"><i data-feather="user"></i><span>My Profile</span></a>
                                </li>
                                <li><a href="letter-box.html"><i data-feather="mail"></i><span>Inbox</span></a></li>
                                <li> <a href="edit-profile.html"> <i
                                            data-feather="settings"></i><span>Settings</span></a></li>
                                <li>
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a class="btn btn-pill btn-outline-primary btn-sm" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                            Déconnexion
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details"> 
            <div class="ProfileCard-realName"></div>
            </div> 
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template">
                    <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
                </script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg">
                <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                            src="{{ asset('assets/images/logo/logo5.png')}}" alt=""
                            Style="max-width: 60%; max-height: 70px; ">></a>
                    <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                    </div>
                </div>
                <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                            src="{{ asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
                <nav class="sidebar-main">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="sidebar-menu">
                        <ul class="sidebar-links" id="simple-bar">
                            <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                        src="{{ asset('assets/images/logo/logo-icon.png')}}" alt=""></a>
                                <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                                        aria-hidden="true"></i></div>
                            </li>
                            <li class="pin-title sidebar-main-title">
                                <div>
                                    <h6>Epinglés</h6>
                                </div>
                            </li>
                            {{-- ******************* DEBUT BOX UTILISATEUR *********************** --}}
                            <li class="sidebar-main-title">
                                <div>
                                    <h6 class="lan-">Membres</h6>
                                </div>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user')}}"></use>
                                    </svg><span>Utilisateurs </span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('formAddUser') }}">Créer Nouvel</a></li>
                                    <li><a href="{{ route('listeUser') }}">Liste</a></li>
                                </ul>
                            </li>
                            {{-- ******************* FIN BOX UTILISATEUR *********************** --}}
                            {{-- **************************DEBUT BOX MOUVEMENT********************* --}}
                            <li class="sidebar-main-title">
                                <div>
                                    <h6 class="lan-">Mouvements</h6>
                                </div>
                            </li>
                            {{-- ******************* FIN BOX MOUVEMENT *********************** --}}
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                    </svg><span>Groupes </span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('formAddMouvement') }}">Créer Mouvement</a></li>
                                    <li><a href="{{ route('listeMouvement') }}">Liste</a></li>
                                    <li><a href="{{ route('formAddMembreMouvement') }}">Ajout Membre</a></li>
                                    <li><a href="{{ route('listeMembreMouv') }}">Liste Membre</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="file-manager.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                                    </svg><span>File manager</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="kanban.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                    </svg><span>kanban Board</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                                    </svg><span>Ecommerce</span></a>
                                <ul class="sidebar-submenu">
                                    <li> <a href="add-products.html">Add Products</a></li>
                                    <li><a href="product.html">Product</a></li>
                                    <li><a href="category.html">Category page</a></li>
                                    <li><a href="product-page.html">Product page</a></li>
                                    <li><a href="list-products.html">Product list</a></li>
                                    <li><a href="payment-details.html">Payment Details</a></li>
                                    <li><a href="order-history.html">Order History</a></li>
                                    <li><a class="submenu-title" href="#">Invoices<span class="sub-arrow"><i
                                                    class="fa fa-angle-right"></i></span></a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="invoice-1.html">Invoice-1</a></li>
                                            <li><a href="invoice-2.html">Invoice-2</a></li>
                                            <li><a href="invoice-3.html">Invoice-3</a></li>
                                            <li><a href="invoice-4.html">Invoice-4</a></li>
                                            <li><a href="invoice-5.html">Invoice-5</a></li>
                                            <li><a href="invoice-template.html">Invoice-6</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="cart.html">Cart</a></li>
                                    <li><a href="list-wish.html">Wishlist</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="pricing.html">Pricing </a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="letter-box.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                                    </svg><span>Letter Box </span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="email-application.html">Email App</a></li>
                                    <li><a href="email-compose.html">Email Compose</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                                    </svg><span>Chat</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="private-chat.html">Private Chat</a></li>
                                    <li> <a href="group-chat.html">Group Chat</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                    </svg><span>Users</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="user-profile.html">Users Profile</a></li>
                                    <li><a href="edit-profile.html">Users Edit</a></li>
                                    <li><a href="user-cards.html">Users Cards</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="bookmark.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-bookmark')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-bookmark')}}"> </use>
                                    </svg><span>Bookmarks</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="contacts.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-contact')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-contact')}}"> </use>
                                    </svg><span>Contacts</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="task.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-task')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-task')}}"> </use>
                                    </svg><span>Tasks</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="calendar-basic.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-calendar')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-calender')}}"></use>
                                    </svg><span>Calendar</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="social-app.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-social')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-social')}}"> </use>
                                    </svg><span>Social App</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="to-do.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-to-do')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-to-do')}}"> </use>
                                    </svg><span>To-Do</span></a></li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="search.html">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-search')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-search')}}"> </use>
                                    </svg><span>Search Result</span></a></li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Forms & Table</h6>
                                </div>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-form')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-form')}}"> </use>
                                    </svg><span>Forms</span></a>
                                <ul class="sidebar-submenu">
                                    <li> <a class="submenu-title" href="#">Form Controls <span class="sub-arrow"> <i
                                                    class="fa fa-angle-right"></i></span></a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="form-validation.html">Form Validation</a></li>
                                            <li><a href="base-input.html">Base Inputs</a></li>
                                            <li><a href="radio-checkbox-control.html">Checkbox & Radio</a></li>
                                            <li><a href="input-group.html">Input Groups</a></li>
                                            <li> <a href="input-mask.html">Input Mask</a></li>
                                            <li><a href="megaoptions.html">Mega Options</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="submenu-title" href="#">
                                            Form Widgets<span class="sub-arrow"><i
                                                    class="fa fa-angle-right"></i></span></a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="datepicker.html">Datepicker</a></li>
                                            <li><a href="touchspin.html">Touchspin</a></li>
                                            <li><a href="select2.html">Select2</a></li>
                                            <li><a href="switch.html">Switch</a></li>
                                            <li><a href="typeahead.html">Typeahead</a></li>
                                            <li><a href="clipboard.html">Clipboard</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="submenu-title" href="#">Form layout<span class="sub-arrow"><i
                                                    class="fa fa-angle-right"></i></span></a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="form-wizard.html">Form Wizard 1</a></li>
                                            <li><a href="form-wizard-two.html">Form Wizard 2</a></li>
                                            <li><a href="two-factor.html">Two Factor</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-table')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-table')}}"></use>
                                    </svg><span>Tables</span></a>
                                {{-- <ul class="sidebar-submenu">
                                    <li><a class="submenu-title" href="#">Bootstrap Tables<span class="sub-arrow"><i
                                                    class="fa fa-angle-right"></i></span></a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="bootstrap-basic-table.html">Basic Tables</a></li>
                                            <li><a href="table-components.html">Table components</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="submenu-title" href="#">Data Tables<span class="sub-arrow"><i
                                                    class="fa fa-angle-right"></i></span></a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="datatable-basic-init.html">Basic Init</a></li>
                                            <li> <a href="datatable-advance.html">Advance Init </a></li>
                                            <li> <a href="datatable-API.html">API </a></li>
                                            <li><a href="datatable-data-source.html">Data Sources</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="datatable-ext-autofill.html">Ex. Data Tables</a></li>
                                    <li><a href="jsgrid-table.html">Js Grid Table </a></li>
                                </ul> --}}
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Components</h6>
                                </div>
                            </li>
                            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title" href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#stroke-ui-kits')}}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{asset('assets/svg/icon-sprite.svg#fill-ui-kits')}}"></use>
                                    </svg><span>Ui Kits</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="typography.html">Typography</a></li>
                                    <li><a href="avatars.html">Avatars</a></li>
                                    <li><a href="helper-classes.html">helper classes</a></li>
                                    <li><a href="grid.html">Grid</a></li>
                                    <li><a href="tag-pills.html">Tag & pills</a></li>
                                    <li><a href="progress-bar.html">Progress</a></li>
                                    <li><a href="modal.html">Modal</a></li>
                                    <li><a href="alert.html">Alert</a></li>
                                    <li><a href="popover.html">Popover</a></li>
                                    <li><a href="tooltip.html">Tooltip</a></li>
                                    <li><a href="dropdown.html">Dropdown</a></li>
                                    <li><a href="according.html">Accordion</a></li>
                                    <li><a href="tab-bootstrap.html">Tabs</a></li>
                                    <li><a href="list.html">Lists</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </div>
            @yield('main-content')

            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2024 © Paroisse Smart </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jquery-->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{asset('js/pages_js/form.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.js') }}"></script>
    <script src="{{ asset('assets/js/header-slick.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <!-- Range Slider js-->
    <script src="{{ asset('assets/js/range-slider/rSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/rangeslider/rangeslider.js') }}"></script>
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
    <!-- calendar js-->
    <script src="{{ asset('assets/js/calendar/fullcalender.js') }}"></script>
    <script src="{{ asset('assets/js/calendar/custom-calendar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/dashboard_2.js') }}"></script>
    <script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{asset('assets/js/sweet-alert/app.js') }}"></script>
    <!-- Theme js-->
    <script src="{{asset('assets/js/script.js') }}"></script>
    <script src="{{asset('assets/js/theme-customizer/customizer.js')}}"></script>
    <script>
        new WOW().init();
    </script>
    @yield('scripts')
</body>

</html>