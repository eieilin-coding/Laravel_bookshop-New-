{{-- resources/views/explore.blade.php --}}

@extends('layouts.userview')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css">
       
    
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
                        <div class="featured__actions">
                            <button class="wishlist-btn" data-book-id="{{ $book->id }}" data-book-title="{{ $book->title }}">
                                <i class="ri-heart-3-line"></i>
                            </button>
                            <a href="{{ url("/books/show/$book->id") }}"><i class="ri-eye-line"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pagination">
                {{ $books->links() }}
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
    
@endsection