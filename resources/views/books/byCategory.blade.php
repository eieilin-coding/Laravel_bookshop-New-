@extends('layouts.userview')

@section('content')

 <link rel="stylesheet" href="{{ asset('css/explore.css') }}">

    <section class="featured section" id="featured">
        <div class="featured__container container">
            <div class="featured__grid">
                @foreach ($books as $book)
                    <article class="featured__card">
                        @if ($book->photo)
                            <img src="{{ asset('storage/photos/' . $book->photo) }}" alt="image" class="featured__img">
                        @endif
                        <h2 class="featured__title">{{ $book->title }}</h2>
                        <div class="featured__prices">
                            <span class="featured__discount">$11.99</span>
                        </div>
                        <button class="button">Add To Card</button>
                        <div class="featured__actions">
                            {{-- <button><i class="ri-search-line"></i></button> --}}
                            <button><i class="ri-heart-3-line"></i></button>
                            <a href="{{ url("/books/show/$book->id") }}"><i class="ri-eye-line"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            {{-- <div class="pagination">
                {{ $books->links() }}
            </div> --}}
        </div>
    </section>

@endsection