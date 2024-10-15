<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="{{ asset('assets/images/logo/logo2.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo2.png') }}" type="image/x-icon">
    <title>PAROISSE SMART</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets_presentation/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_presentation/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_presentation/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_presentation/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_presentation/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets_presentation/css/main.css')}}" rel="stylesheet">
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">

            <a href="/" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">Paroisse Smart</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Acceuil</a></li>
                    <li><a href="#about">Fonctionnalités</a></li>
                    <li><a href="#services">Processus d'utilisation</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">Tester </a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="{{ asset('assets_presentation/img/banner2.jpg')}}" alt="" data-aos="fade-in" class="">

            <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2>Paroisse Smart</h2>
                        <p>Est une application de gestion de paroisse qui vous facilitera la vie!</p>
                        <a href="{{ route('login') }}" class="btn-get-started">Tester ?</a>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 position-relative align-self-start order-lg-last order-first"
                        data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('assets_presentation/img/connection.png')}}" class="img-fluid" alt="">
                        <img src="{{ asset('assets_presentation/img/tableau_bord.png')}}" class="img-fluid" alt=""><img
                            src="{{ asset('assets_presentation/img/evenement.png')}}" class="img-fluid" alt="">
                        {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                            class="glightbox pulsating-play-btn"></a> --}}
                    </div>

                    <div class="col-lg-6 content order-last  order-lg-first" data-aos="fade-up" data-aos-delay="100">
                        <h3>Fonctionnalités</h3>
                        <p>
                            L'application de gestion de paroisse, traite plusieurs fonctionnalités, notamment les
                            demandes de messes,
                            la catéchèse, les dons, les dépenses, les statistiques, la programmation de messes, les
                            mouvements etc.
                        </p>
                        <ul>
                            <li>
                                <i class="bi bi-diagram-3"></i>
                                <div>
                                    <h5>Gestion des utilisateurs</h5>
                                    <p>Cet espace permet aux administreurs de créer le compte des paroissioens
                                        en
                                        fonction de leur type (responsable de mouvement, paroissien, responsable
                                        catechese). Ils pouront aussi bloquer les accès d'un paroissien qui n'est plus
                                        sur la paroisse.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <i class="bi bi-fullscreen-exit"></i>
                                <div>
                                    <h5>Espace catéchèse</h5>
                                    <p>
                                        Dans cet espaces, vous gerez la catéchèse dans son entièreté. En fonction de vos
                                        accès, vous pourrez soit faire uniquement l'inscription
                                        d'un catéchumène préalablement enregistré comme tel (payé par mobile money),
                                        soit
                                        imprimer la liste des classe, affecté les catechumènes à leur salle, voir la
                                        liste des catechumènes inscrits...
                                    </p>
                                </div>
                            </li>
                            <li>
                                <i class="bi bi-broadcast"></i>
                                <div>
                                    <h5>Tableau de bord</h5>
                                    <p>En fonction du type utilisateur et depuis votre position, vous pourrez voir
                                        certaines statistiques: nombre
                                        de paroissiens utilisant l'application,
                                        la statistique financière de la paroisse, la statistique de la catéchèse, des
                                        dons, des évènements à venir
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </section><!-- /About Section -->
        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section dark-background">

            <img src="{{ asset('assets_presentation/img/catechese.png')}}" alt="">

            <div class="container">

                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-9 text-center text-xl-start">
                        <h3>La technologie au service de votre paroisse</h3>
                        <p>Une application qui gère toutes vos questions.</p>
                    </div>
                    <div class="col-xl-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="{{ route('login') }}">Tester</a>
                    </div>
                </div>

            </div>

        </section><!-- /Call To Action Section -->

        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Processus d'utilisation</h2>
                <p>L'utilisation de notre application est très simple:</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item  position-relative">
                            <div class="icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Avoir un compte utilisateur</h3>
                            </a>
                            <p>Demandez aux personnes ressources de votre paroisse de vous créer un compte !</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Se connecter</h3>
                            </a>
                            <p>Avoir la connection internet,avec les informations qu'ils auront donnés notamment le nom
                                de domaine de la paroisse, votre email et mot de passe, connectez vous, accedez à votre
                                espace et savourez!</p>
                        </div>
                    </div><!-- End Service Item -->


                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-bounding-box-circles"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Autres aspects</h3>
                            </a>
                            <p>Modifier son mot de passe, se deconnecter, faire tout ce que son accès te permet de faire
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Envie de nous contacter pour plus d'info ? N'hésitez pas à le faire, nous sommes là pour vous!</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-5">

                        <div class="info-wrap">
                            {{-- <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Address</h3>
                                    <p>A108 Adam Street, New York, NY 535022</p>
                                </div>
                            </div><!-- End Info Item --> --}}

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Téléphone</h3>
                                    <p>+225 49 17 43 34</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email </h3>
                                    <p>contact@paroissesmart.com</p>
                                </div>
                            </div><!-- End Info Item -->
                            {{--
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
                                frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <label for="name-field" class="pb-2">Votre nom et prénoms</label>
                                    <input type="text" name="name" id="name-field" class="form-control" required="">
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">Votre Email</label>
                                    <input type="email" class="form-control" name="email" id="email-field" required="">
                                </div>

                                <div class="col-md-12">
                                    <label for="subject-field" class="pb-2">Sujet</label>
                                    <input type="text" class="form-control" name="subject" id="subject-field"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Message</label>
                                    <textarea class="form-control" name="message" rows="5" id="message-field"
                                        required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Chargement</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Envoyez Message</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="{{ route('login') }}" class="logo d-flex align-items-center">
                        <span class="sitename">Paroisse Smart</span>
                    </a>
                    <p>Une application de gestion de paroisse.</p>
                    <div class="social-links d-flex mt-4">
                        {{-- <a href=""><i class="bi bi-twitter-x"></i></a> --}}
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Liens </h4>
                    <ul>
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Fonctionnalité</a></li>
                        <li><a href="#">Processus d'utilisation</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Terme d'utilisaton</a></li>
                        {{-- <li><a href="#">Privacy policy</a></li> --}}
                    </ul>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Autres services</h4>
                    <ul>
                        <li><a href="#">Création de site internet</a></li>
                        <li><a href="#">Création d'application web</a></li>
                        <li><a href="#">Grafique</a></li>
                        {{-- <li><a href="#">C</a></li>
                        <li><a href="#">Graphic Design</a></li> --}}
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Nous contactez</h4>
                    {{-- <p>A108 Adam Street</p> --}}
                    <p>Abidjan</p>
                    <p>Cote d'Ivoire</p>
                    <p class="mt-4"><strong>Phone:</strong> <span>+225 49 17 43 34</span></p>
                    <p><strong>Email:</strong> <span>contact@paroissesmart.com</span></p>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Paroisse Smart</strong> <span>Tout droit
                    Reservé!</span>
            </p>

        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets_presentation/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets_presentation/vendor/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets_presentation/js/main.js')}}"></script>

</body>

</html>