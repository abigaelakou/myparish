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
    <link rel="icon" href="{{ asset('assets/images/logo/logo2.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo2.png') }}" type="image/x-icon">
    <title>PAROISSE SMART</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="../../css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
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
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7"><img class="bg-img-cover bg-center"
                    src="{{ asset('assets/images/login/loginImage.png') }}" alt="looginpage"></div>
            <div class="col-xl-5 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div><a class="logo text-start" href="index.html"><img class="img-fluid for-dark"
                                    src="{{ asset('assets/images/logo/logo.png') }}" alt="looginpage"><img
                                    class="img-fluid for-light" src="{{ asset('assets/images/logo/logo2.png') }}"
                                    alt="looginpage"
                                    style="max-width: 60%; max-height: 80px; margin-right:auto; margin-left:auto; margin-top:8%;display:block;"></a>
                        </div>
                        <div class="login-main">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <h4>Se connecter à son compte </h4>
                                <p>Entrez votre email et mot de passe</p>
                                <!--*********** Email Address **************** -->
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" name="email" id="email" type="email"
                                        value="{{ old('email') }}" required autofocus placeholder="exemple@gmail.com">

                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <!--*********** Password *************** -->
                                <div class="form-group">
                                    <label class="col-form-label">Mot de passe</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" id="password" type="password" name="password"
                                            value="{{ old('password') }}" placeholder="*********" required
                                            autocomplete="current-password">
                                        {{-- <div class="show-hide"><span class="show"> </span></div> --}}
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                </div>
                                <!-- ********** Se rappeler de moi ****************-->
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="remember_me" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Se rappeler de moi?</label>
                                    </div>
                                    <button class="btn btn-primary btn-block w-100" type="submit">Connexion</button>
                                    <!-- ********** Mot de passe oublié ***************** -->
                                    @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <!-- feather icon js-->
        <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <!-- Plugins JS start-->
        <!-- calendar js-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('assets/js/script.js') }}"></script>
    </div>
</body>

</html>