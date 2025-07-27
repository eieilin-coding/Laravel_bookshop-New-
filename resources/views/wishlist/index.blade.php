@extends('layouts.userview')

@section('content')

    {{-- ===== For Pagination UI ===== --}}
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">

    <div class="wishlist-container">
        <h1 class="wishlist-title">Your Wishlist</h1>

        @if ($wishlist->count() > 0)
            <section class="featured section" id="featured">
                <div class="featured__container container">
                    <div class="featured__grid">
                        @foreach ($wishlist as $item)
                            <article class="featured__card">
                                @if ($item->book->photo)
                                    <img src="{{ asset('storage/photos/' . $item->book->photo) }}" alt="image"
                                        class="featured__img">
                                @endif
                                <h2 class="featured__title">{{ $item->book->title }}</h2>
                                <div class="card-details">
                                    <p class="card-date">Added on: {{ $item->created_at->format('F d, Y') }}</p>
                                </div>
                                <div class="featured__actions">
                                    {{-- <button class="wishlist-btn" data-book-id="{{ $item->book->id }}"
                                        data-book-title="{{ $item->book->title }}">
                                        <i class="ri-heart-3-line "></i>
                                    </button> --}}
                                    <form method="POST" action="{{ route('wishlist.remove', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-btn"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                    <a href="{{ url("/books/show/$item->book_id") }}"><i class="ri-eye-line"></i></a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="pagination">
                        {{ $wishlist->links() }}
                    </div>
                </div>
            </section>
        @else
            <div class="empty-wishlist">
                <p>Your wishlist is currently empty.</p>
            </div>
        @endif

    </div>
@endsection
