<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    {{-- <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">


    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css">


    <!--=============== SWIPER CSS ===============-->
    {{-- <link rel="stylesheet" href="assets/css/swiper-bundle.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">

    <!--=============== CSS ===============-->
    {{-- <link rel="stylesheet" href="assets/css/styles.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- ==== To Overwrite Style ==== -->
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Responsive book website - Bedimcode</title>
</head>

<body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="{{ route('books.index') }}" class="nav__logo">
                <i class="ri-book-3-line"></i>E-Book
            </a>
            <div class="nav__menu">
                <ul class="nav__list">


                </ul>
            </div>

            <div class="nav__actions">
                <!-- Search button -->
                <i class="ri-search-line search-button" id="search-button"></i>
                @if (Auth::check())
                    <a href="{{ route('wishlist.index') }}" class="wishlist-icon">
                        <i class="ri-heart-3-line"></i>
                        <span id="wishlist-count" class="wishlist-badge">0</span>
                    </a>
                @endif

                @auth
                    <!-- If the user is an admin -->
                    @if (auth()->user()->role_id == 1)
                        <a href="{{ route('admin.dashboard') }}" title="Admin Dashboard">
                            <i class="ri-dashboard-line"></i>
                        </a>
                    @endif

                    <!-- Logout button -->
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <i class="ri-logout-box-r-line" title="Logout"></i>
                        </button>
                    </form>
                @else
                    <!-- Login button -->
                    {{-- <i class="ri-login-circle-line login-button" id="login-button"></i> --}}
                    <i class="ri-login-circle-line btnLogin-popup" id="login-button"></i>

                    <!-- Register button -->
                    {{-- <i class="ri-user-line register-button" id="register-button"></i> --}}
                @endauth


                <!-- Theme button -->
                <i class="ri-moon-line change-theme" id="theme-button"></i>
            </div>
        </nav>
    </header>

    <!--==================== SEARCH ====================-->
    <div class="search" id="search-content">
        <form action="{{ route('books.explore') }}" method="GET" class="search__form">
            <i class="ri-search-line search__icon"></i>
            <input type="search" name="search" placeholder="What are you looking for?" class="search__input"
                value="{{ request('search') }}" onkeydown="if(event.key === 'Enter') this.form.submit()">
            {{-- <button type="submit" class="search-button" style="display: none;">Search</button> --}}
        </form>
        <i class="ri-close-line search__close" id="search-close"></i>
    </div>
    <!--==================== LOGIN ====================-->
    

    <!--==================== Register ====================-->
    

    <!--==================== MAIN ====================-->
    <main class="main">

        @yield('content')

    </main>

    <!--==================== FOOTER ====================-->
    <footer class="footer">
        <div class="footer__container container grid">
            <div>
                <a href="#" class="footer__logo">
                    <i class="ri-book-3-line"></i>E-Book
                </a>
                <p class="footer__description">
                    Find and explore the best <br>
                    eBooks from all your <br>
                    favorite writers.
                </p>
            </div>
            <div class="footer__data grid">
                <div>
                    <h3 class="footer__title">About</h3>
                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">Awards</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">FAQs</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Privacy policy</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Terms of services</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Company</h3>
                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">Blogs</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Community</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Our team</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Help center</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Contact</h3>
                    <ul class="footer__links">
                        <li>
                            <address class="footer__info">
                                Av. Hacienda <br>
                                Lima 4321, Perú
                            </address>
                        </li>
                        <li>
                            <address class="footer__info">
                                e.book@email.com <br>
                                0987-654-321
                            </address>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Social</h3>
                    <a href="https://www.facebook.com/" target="_blank" class="footer__social-link">
                        <i class="ri-facebook-circle-line"></i>
                    </a>

                    <a href="https://www.instagram.com/" target="_blank" class="footer__social-link">
                        <i class="ri-instagram-line"></i>
                    </a>

                    <a href="https://twitter.com/" target="_blank" class="footer__social-link">
                        <i class="ri-twitter-x-line"></i>
                    </a>
                </div>
            </div>
        </div>
        <span class="footer__copy">
            &#169; All Rights Reserved By BookShop
        </span>
    </footer>

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-line"></i>
    </a>

    <!--=============== SCROLLREVEAL ===============-->
    {{-- <script src="assets/js/scrollreveal.min.js"></script> --}}
    <script src="{{ asset('js/scrollreveal.min.js') }}"></script>

    <!--=============== SWIPER JS ===============-->
    {{-- <script src="assets/js/swiper-bundle.min.js"></script> --}}
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>

    <!--=============== MAIN JS ===============-->
    {{-- <script src="assets/js/main.js"></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>

    <!--=============== WishList JS ===============-->

    <script src="{{ asset('js/wishlist.js') }}"></script>
</body>

</html>
