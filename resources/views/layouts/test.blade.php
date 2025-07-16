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

    <!--=============== SWIPER CSS ===============-->
    {{-- <link rel="stylesheet" href="assets/css/swiper-bundle.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">

    <!--=============== CSS ===============-->
    {{-- <link rel="stylesheet" href="assets/css/styles.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

   <link rel="stylesheet" href="{{ asset('css/detail.css') }}"> 
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- ==== To Overwrite Style ==== -->
   @stack('styles')

    <title>Responsive book website - Bedimcode</title>
</head>

<body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">
                <i class="ri-book-3-line"></i>E-Book
            </a>
            <div class="nav__menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link active-link">
                            <i class="ri-home-4-line"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="#featured" class="nav__link">
                            <i class="ri-book-3-line"></i>
                            <span>Featured</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="#discount" class="nav__link">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Discount</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="#new" class="nav__link">
                            <i class="ri-bookmark-line"></i>
                            <span>New Books</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="#testimonial" class="nav__link">
                            <i class="ri-message-3-line"></i>
                            <span>Testimonial</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="nav__actions">
                <!-- Search button -->
                <i class="ri-search-line search-button" id="search-button"></i>

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
                    <i class="ri-login-circle-line login-button" id="login-button"></i>

                    <!-- Register button -->
                    <i class="ri-user-line register-button" id="register-button"></i>
                @endauth


                <!-- Theme button -->
                <i class="ri-moon-line change-theme" id="theme-button"></i>
            </div>
        </nav>
    </header>

    <!--==================== SEARCH ====================-->
    <div class="search" id="search-content">
        <form action="#" class="search__form">
            <i class="ri-search-line search__icon"></i>
            <input type="search" placeholder="What are you looking for?" class="search__input">
        </form>
        <i class="ri-close-line search__close" id="search-close"></i>
    </div>

    <!--==================== LOGIN ====================-->
    <div class="login grid" id="login-content">
        <form action="" class="login__form grid">
            <h3 class="login__title">Log In</h3>
            <div class="login__group grid">
                <div>
                    <label for="login-email" class="login__label">Email</label>
                    <input type="email" placeholder="Write your email" id="login-email" class="login__input">
                </div>
                <div>
                    <label for="login-pass" class="login__label">Password</label>
                    <input type="password" placeholder="Enter your password" id="login-pass" class="login__input">
                </div>
                <div>
                    <span class="login__signup">
                        You do not have an account? <a href="#">Sign up</a>
                    </span>
                    <a href="#" class="login__forgot">
                        You forgot your password
                    </a>
                    <a href="#" type="submit" class="login__button button" id="login-button">Log In</a>
                </div>
            </div>
        </form>
        <i class="ri-close-line login__close" id="login-close"></i>
    </div>

    <!--==================== MAIN ====================-->
    <main class="main">
       
        @yield('content')
       
    </main>

  

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
</body>

</html>
