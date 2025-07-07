
@extends("layouts.app")

@section("content")
    <div class="container" style="max-width: auto">
         <h4 class="mt-2 text-center">
        Available Books
    </h4>

    <div class="container mt-4">
        <div class="row">
            @foreach ($books as $book)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm d-flex flex-column book">
                        @if ($book->photo)
                        <img src="{{ asset('storage/photos/' . $book->photo) }}" class=" book-card-img"
                            style="max-width: 100%,height:400px;" class="img-fluid rounded shadow" loading="lazy" alt="<?= htmlspecialchars($book->title) ?>">
                        @endif
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h6 class="card-title"><?= htmlspecialchars($book->title) ?></h6>
                            <a href="{{ url("/books/show/$book->id") }}" class="btn btn-outline-primary mt-auto" style="width: 115px;">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
         {{ $books->links() }}
    </div>
@endsection