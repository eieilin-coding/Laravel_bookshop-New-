@extends('layouts.adminlte')

@section('content')
    <div class="container bg-light py-3">
        @if ($errors->any())
            <div class="alert alert-warning">
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        @endif
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold">Category</label>
                    <select name="category_id" id="category_id" class="form-select form-control">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($book->category_id == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="author_id" class="form-label fw-semibold">Author</label>
                    <select name="author_id" id="author_id" class="form-select form-control">
                        <option value="">-- Select Author --</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" @selected($book->author_id == $author->id)>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label fw-semibold">Book Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}">
                </div>

                <div class="col-md-6">
                    <label for="publisher" class="form-label fw-semibold">Publisher</label>
                    <input type="text" name="publisher" id="publisher" class="form-control"
                        value="{{ $book->publisher }}">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="published_date" class="form-label fw-semibold">Published Date</label>
                    <input type="date" name="published_date" id="published_date" class="form-control"
                        value="{{ $book->published_date }}">
                </div>

                <div class="col-md-6">
                    <label for="book_photo" class="form-label fw-semibold">Book Cover (Photo)</label>
                    <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Max: 5MB (JPG, PNG, GIF)</small>

                    @if ($book->photo)
                        <div class="mt-2">
                            <strong>Current Cover:</strong><br>
                            <img src="{{ asset('storage/photos/' . $book->photo) }}" alt="Book Cover" width="100"
                                height="100">
                        </div>
                    @endif

                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ $book->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="book_pdf" class="form-label fw-semibold">Upload Book PDF</label>
                <input type="file" id="pdf" name="pdf" class="form-control" accept="application/pdf">
                <small class="text-muted">Max: 20MB (PDF only)</small>

                @if ($book->file)
                    <div class="mt-2">
                        <strong>Current PDF:</strong><br>
                        <a href="{{ asset('storage/files/' . $book->file) }}" target="_blank">{{$book->file}}</a>
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-primary " name="update">Update</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
            </div>

        </form>
    </div>
@endsection
