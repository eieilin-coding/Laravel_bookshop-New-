@extends('layouts.userview')

@section('content')
    <div class="book-container" style="padding-top: 80px;">
        <!-- Book Cover -->
        <div class="book-cover">
            <img src="{{ asset($book->photo ? 'storage/photos/' . $book->photo : 'images/default-book-cover.jpg') }}"
                alt="{{ $book->title }}">
        </div>

        <!-- Book Details -->
        <div class="book-details">
            <h1>{{ $book->title }}</h1>

            <div class="book-meta">
                <p><strong>Author:</strong> {{ $book->author->name }}</p>
                <p><strong>Category:</strong> {{ $book->category->name }}</p>
                <p><strong>Published Date:</strong> {{ \Carbon\Carbon::parse($book->published_date)->format('F d, Y') }}</p>
            </div>

            <hr>

            <div class="book-description">
                <h2>Description:</h2>
                <p>{{ $book->description }}</p>
            </div>

            <div class="prices">
                <p><strong>Normal Price:</strong><span class="featured__price"> MMK{{ $book->normal_price }}</span> </p>
                <p><strong>Discount Price:</strong>MMK {{ $book->disc_price }}</p>
            </div>

            <div class="book-actions">
                {{-- @auth --}}
                {{-- Show download button for logged-in users --}}
                {{-- <a href="{{ route('books.download', $book->id) }}" class="btn btn-download"
                        download="{{ str_replace(' ', '_', $book->title) }}.pdf">
                        <i class="fas fa-download"></i> Download PDF
                    </a> --}}
                {{-- @else --}}
                {{-- Show info message for guests --}}
                {{-- <div class="btn btn-info">
                        <i class="fas fa-info-circle"></i> Only logged-in users can download.
                    </div>
                @endauth --}}

                <a href="{{ route('books.download', $book->id) }}" class="btn btn-download download-btn"
                    data-auth="{{ auth()->check() ? '1' : '0' }}"
                    data-download-url="{{ route('books.download', $book->id) }}">
                    <i class="fas fa-download"></i> Download PDF
                </a>

                {{-- Back button (always visible) --}}
                <a href="{{ route('books.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Books
                </a>
            </div>

            <div class="download-count">
                <p><strong>Downloads:</strong> {{ number_format($book->download_count) }}</p>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const isAuth = this.dataset.auth === '1';
            const downloadUrl = this.dataset.downloadUrl;

            if (!isAuth) {
                e.preventDefault();
                window.location.href = "{{ route('login') }}";
            } else {
                window.location.href = downloadUrl;
            }
        });
    });
</script>
    @push('styles')
        <style>
            body .footer {
                padding-block: 2rem !important;
                /* or 0 if you want to remove it completely */
            }
        </style>
    @endpush
@endsection
