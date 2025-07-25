@extends('layouts.userview')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/wishlistIndex.css') }}">

    {{-- ===== For Pagination UI ===== --}}
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">

    <div class="wishlist-container">
        <h1 class="wishlist-title">Your Wishlist</h1>

        @if ($wishlist->count() > 0)
            <table class="wishlist-table">
                <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Book Cover</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wishlist as $item)
                        <tr class="row">
                            <td data-label="Book Name">{{ $item->book->title }}</td>
                            <td data-label="Book Cover">
                                @if ($item->book->photo)
                                    <img src="{{ asset('storage/photos/' . $item->book->photo) }}" alt="Book Cover"
                                        class="book-cover">
                                @endif
                            </td>
                            <td data-label="Date Added">{{ $item->created_at->format('F d, Y') }}</td>
                            <td data-label="Actions" class="action">
                                <div class="gp-button">
                                    <a href="{{ url("/books/show/$item->id") }}" class="see-btn"><i class="ri-eye-fill"></i></a>
                                <form method="POST" action="{{ route('wishlist.remove', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn"><i class="ri-delete-bin-line"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-wishlist">
                <p>Your wishlist is currently empty.</p>
            </div>
        @endif
        <div class="pagination mb-3">
            {{ $wishlist->links() }}
        </div>
    </div>

@endsection
