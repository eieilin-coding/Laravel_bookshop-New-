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
   
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">

     <!--=============== Wishlist CSRF Token ===============-->
     <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Responsive book website - Bedimcode</title>
</head>

<body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="{{ route('books.index') }}" class="nav__logo">                
                <i class="ri-book-3-line"></i><span id="nav__brand">E-Book</span>
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
                <a href="{{ route('login') }}" class="login-button"><i class="ri-login-circle-line"></i></a>
                    {{-- <!-- Login button -->
                    <i class="ri-login-circle-line login-button" id="login-button"></i>

                    <!-- Register button -->
                    <i class="ri-user-line register-button" id="register-button"></i> --}}
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
    <div class="login grid" id="login-content">
        <form action="{{ route('authenticate') }}" method="post" class="login__form grid">
            @csrf
            <h3 class="login__title">Log In</h3>
            <div class="login__group grid">
                <div>
                    <label for="login-email" class="login__label">Email</label>
                    <input type="email" placeholder="Write your email" id="login-email"
                        class="login__input @error('email') is-invalid @enderror" name="email" id="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="login-pass" class="login__label">Password</label>
                    <input type="password" placeholder="Enter your password" id="login-pass"
                        class="login__input @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    {{-- <span class="login__signup">
                        You do not have an account? <a href="#">Sign up</a>
                    </span> --}}
                    {{-- <a href="#" class="login__forgot">
                        You forgot your password
                    </a> --}}
                    <input type="submit" class="login__button button" value="Login" id="login-button">

                </div>
            </div>
        </form>
        <i class="ri-close-line login__close" id="login-close"></i>
    </div>


    <!--==================== Register ====================-->
    <div class="register grid" id="register-content">
        <form action="{{ route('store') }}" method="post" class="register__form grid">
            @csrf
            <h3 class="register__title">Register</h3>
            <div class="register__group grid">
                <div>
                    <label for="register-name" class="register__label">Name</label>
                    <input type="input" placeholder="Write your name" id="register-name"
                        class="register__input @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="register-email" class="register__label">Email</label>
                    <input type="email" placeholder="Write your email" id="register-email"
                        class="register__input @error('email') is-invalid @enderror" name="email" id="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="register-pass"
                        class="register__label @error('password') is-invalid @enderror">Password</label>
                    <input type="password" placeholder="Enter your password" id="register-pass"
                        class="register__input" id="password" name="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="register-pass" class="register__label @error('password') is-invalid @enderror">Confirm
                        Password</label>
                    <input type="password" placeholder="Enter confirm password" id="register-pass"
                        class="register__input" id="password_confirmation" name="password_confirmation">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    {{-- <span class="register__signup">
                        Already have an account? <a href="#">Log In</a>
                    </span> --}}

                    <input type="submit" class="register__button button" value="register" id="register-button">

                </div>
            </div>
        </form>
        <i class="ri-close-line register__close" id="register-close"></i>
    </div>
    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__data">
                    <h1 class="home__title">
                        Browse & <br>
                        Select E-Books
                    </h1>
                    <p class="home__description">
                        Find the best e-books from your favorite
                        writers, explore hundreds of books with all
                        possible categories, take advantage of the
                        50% discount and much more.
                    </p>

                    <a href="{{ route('books.explore') }}" class="button">Explore Now</a>
                </div>
                <div class="home__images">
                    <div class="home__swiper swiper">
                        <div class="swiper-wrapper">
                            <article class="home__article swiper-slide">
                                {{-- <img src="{{ asset('storage/photos/' . $book->photo) }}" class=" book-card-img"> --}}
                                {{-- <img src="{{ asset('storage/photos/home-book-1.png') }}" alt="image"
                                    class="home__img"> --}}
                                <img src="{{ asset('storage/photos/book-3.png') }}" alt="image"
                                    class="home__img">
                            </article>

                            <article class="home__article swiper-slide">
                                <img src="{{ asset('storage/photos/book-5.png') }}" alt="image"
                                    class="home__img">
                            </article>

                            <article class="home__article swiper-slide">
                                <img src="{{ asset('storage/photos/book-9.png') }}" alt="image"
                                    class="home__img">
                            </article>

                            <article class="home__article swiper-slide">
                                <img src="{{ asset('storage/photos/home-book-4.png') }}" alt="image"
                                    class="home__img">
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--==================== SERVICES ====================-->
        <section class="services section">
            <div class="services__container container grid">
                <article class="services__card">
                    <i class="ri-truck-line"></i>
                    <h3 class="services__title">Free Shipping</h3>
                    <p class="services__description">Order More Than $100</p>
                </article>

                <article class="services__card">
                    <i class="ri-lock-line"></i>
                    <h3 class="services__title">Secure Payment</h3>
                    <p class="services__description">100% Secure Payment</p>
                </article>

                <article class="services__card">
                    <i class="ri-customer-service-line"></i>
                    <h3 class="services__title">24/7 Support</h3>
                    <p class="services__description">Call us anytime</p>
                </article>

            </div>
        </section>

        <!--==================== FEATURED ====================-->
        <section class="featured section" id="featured">
            <h2 class="section__title">
                Featured Books
            </h2>
            <div class="featured__container container">
                <div class="featured__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach ($featuredBooks as $book)
                            <article class="featured__card swiper-slide">
                                @if ($book->photo)
                                    <img src=" {{ asset('storage/photos/' . $book->photo) }}" alt="image"
                                        class="featured__img">
                                @endif
                                <h2 class="featured__title">{{ $book->title }}</h2>
                                {{-- <h2 class="featured__title">Featured Book</h2> --}}
                                <div class="featured__prices">
                                    <span class="featured__discount">MMK{{ $book->disc_price }}</span>
                                    <span class="featured__price">MMK{{ $book->normal_price }}</span>
                                </div>
                                {{-- <button class="button">Add To Card</button> --}}
                                <div class="featured__actions">
                                    
                                    <button class="wishlist-btn" data-book-id="{{ $book->id }}"
                                        data-book-title="{{ $book->title }}">
                                        <i class="ri-heart-3-line"></i>
                                    </button>
                                    <a href="{{ url("/books/show/$book->id") }}"><i class="ri-eye-line"></i></a>                                   
                                </div>
                            </article>
                        @endforeach
                    </div>
                    {{-- <div class="swiper-button-prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="ri-arrow-right-s-line"></i>
                    </div> --}}
                </div>
                <a href="{{ route('books.featuredBooks') }}" class="see__more">See All Featured Books >>> </a>
            </div>
        </section>

        <!--==================== DISCOUNT ====================-->
        <section class="discount section" id="discount">
            <div class="discount__container container grid">
                <div class="discount__data">
                    <h2 class="discount__title section__title">
                        Up To 50% discount
                    </h2>
                    <p class="discount__description">
                        Take advantage of the discount days we
                        have for you, buy books from your favorite
                        writers, the more you buy, the more
                        discounts we have for you.
                    </p>

                    <a href="#" class="button">Shop Now</a>
                </div>
                <div class="discount__images">
                    <img src=" {{ asset('storage/photos/discount-book-1.png') }}" alt="image"
                        class="discount__img-1">
                    <img src="{{ asset('storage/photos/discount-book-2.png') }}" alt="image"
                        class="discount__img-2">
                </div>
            </div>
        </section>

        <!--==================== DISCOUNT ====================-->

        <section class="featured section" id="discount">
            <h2 class="section__title">
                Discount Books
            </h2>
            <div class="featured__container container">
                <div class="featured__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach ($discountBooks as $book)
                            <article class="featured__card swiper-slide">
                                @if ($book->photo)
                                    <img src=" {{ asset('storage/photos/' . $book->photo) }}" alt="image"
                                        class="featured__img">
                                @endif
                                <h2 class="featured__title">{{ $book->title }}</h2>
                                <div class="featured__prices">
                                    <span class="featured__discount">MMK{{ $book->disc_price }}</span>
                                    <span class="featured__price">MMK{{ $book->normal_price }}</span>
                                </div>
                                <div class="featured__actions">
                                    {{-- <button><i class="ri-heart-3-line"></i></button> --}}
                                    <button class="wishlist-btn" data-book-id="{{ $book->id }}"
                                        data-book-title="{{ $book->title }}">
                                        <i class="ri-heart-3-line"></i>
                                    </button>
                                    <a href="{{ url("/books/show/$book->id") }}"><i class="ri-eye-line"></i></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    {{-- <div class="swiper-button-prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="ri-arrow-right-s-line"></i>
                    </div> --}}
                </div>
                <a href="{{ route('books.discountBooks') }}" class="see__more">See All Discount Books >>> </a>
            </div>
        </section>

        <!--==================== NEW BOOKS ====================-->
        <section class="new section" id="new">
            <h2 class="section__title">
                New Books
            </h2>
            <div class="new__container container">
                <div class="new__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach ($newBooks as $book)
                            <a href="#" class="new__card swiper-slide">
                                @if ($book->photo)
                                    <img src="{{ asset('storage/photos/' . $book->photo) }}" alt="image"
                                        class="new__img">
                                @endif
                                <div>
                                    <h2 class="new__title">{{ $book->title }}</h2>                                    
                                    <div class="new__prices">
                                        {{-- <span class="new__discount">MMK{{ $book->disc_price }}</span> --}}
                                        <span class="new__discount">MMK{{ $book->normal_price }}</span>
                                    </div>
                                    <div class="new__stars">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-line"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('books.newBooks') }}" class="see__more">See All New Books >>> </a>
            </div>
        </section>

        <!--==================== JOIN ====================-->
        <section class="join section">
            <div class="join__container">
                <img src="{{ asset('storage/photos/join-bg.jpg') }}" alt="image" class="join__bg">
                <div class="join__data container grid">
                    <h2 class="join__title section__title">
                        Subscribe To Receive <br>
                        The Latest Updates
                    </h2>

                    <form action="{{ route('subscribe') }}" class="join__form" method="POST">
                        <input type="email" placeholder="Enter email" class="join__input">
                        <button type="submit" class="join__button button">Subscribe</button>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!--==================== TESTIMONIAL ====================-->
        <section class="testimonial section" id="testimonial">
            <h2 class="section__title">
                Customer Opinions
            </h2>
            <div class="testimonial__container container">
                <div class="testimonial__swiper swiper">
                    <div class="swiper-wrapper">
                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('storage/photos/testimonial-perfil-1.png') }}" alt="image"
                                class="testimonial__img">
                            <h2 class="testimonial__title">Rial Loz</h2>
                            <p class="testimonial__description">
                                The best website to buy books, the purchase
                                is very easy to make and has great discounts.
                            </p>

                            <div class="testimonial__stars">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-line"></i>
                            </div>
                        </article>

                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('storage/photos/testimonial-perfil-2.png') }}" alt="image"
                                class="testimonial__img">
                            <h2 class="testimonial__title">Rial Loz</h2>
                            <p class="testimonial__description">
                                The best website to buy books, the purchase
                                is very easy to make and has great discounts.
                            </p>

                            <div class="testimonial__stars">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-line"></i>
                            </div>
                        </article>

                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('storage/photos/testimonial-perfil-3.png') }}" alt="image"
                                class="testimonial__img">
                            <h2 class="testimonial__title">Rial Loz</h2>
                            <p class="testimonial__description">
                                The best website to buy books, the purchase
                                is very easy to make and has great discounts.
                            </p>

                            <div class="testimonial__stars">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-line"></i>
                            </div>
                        </article>

                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('storage/photos/testimonial-perfil-4.png') }}" alt="image"
                                class="testimonial__img">
                            <h2 class="testimonial__title">Rial Loz</h2>
                            <p class="testimonial__description">
                                The best website to buy books, the purchase
                                is very easy to make and has great discounts.
                            </p>

                            <div class="testimonial__stars">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-line"></i>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal-overlay" id="wishlistModalOverlay"></div>
        <div class="wishlist-modal" id="wishlistModal">
            <div class="modal-content">
                <div class="modal-icon-container" id="modalIcon">
                </div>
                <h3 class="modal-title" id="modalTitle"></h3>
                <p class="modal-message" id="modalMessage"></p>
                <div class="modal-actions">
                    <a href="{{ route('wishlist.index') }}" class="button">View Wishlist</a>
                    <button class="button close-modal" id="closeModal">Close</button>
                </div>
            </div>
        </div>
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

    <script src="{{ asset('js/wishlist.js') }}"></script>

</body>

</html>
