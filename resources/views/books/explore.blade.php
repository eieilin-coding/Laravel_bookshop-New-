@extends('layouts.userview')

@section('content')
    <section class="featured section" id="featured">
            <div class="featured__container container">
                <div class="featured__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach ($books as $book)
                            <article class="featured__card swiper-slide">
                                @if ($book->photo)
                                    <img src=" {{ asset('storage/photos/' . $book->photo) }}" alt="image"
                                        class="featured__img">
                                @endif
                                <h2 class="featured__title">{{ $book->title }}</h2>
                                {{-- <h2 class="featured__title">Featured Book</h2> --}}
                                <div class="featured__prices">
                                    <span class="featured__discount">$11.99</span>
                                    {{-- <span class="featured__price">$19.99</span> --}}
                                </div>
                                <button class="button">Add To Card</button>
                                <div class="featured__actions">
                                    <button><i class="ri-search-line"></i></button>
                                    <button><i class="ri-heart-3-line"></i></button>
                                    <a href="{{ url("/books/show/$book->id") }}"><i class="ri-eye-line"></i></a>
                                    {{-- <button><i class="ri-eye-line"></i></button> --}}
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
            </div>
        </section>
@endsection
