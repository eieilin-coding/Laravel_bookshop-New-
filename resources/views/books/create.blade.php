@extends('auth.home')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-warning">
            <ol>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ol>
        </div>
    @endif
    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="category_id" class="form-label fw-semibold">Category</label>
                <select name="category_id" id="category_id" class="form-select form-control">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
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
                    <option value="{{ $author->id }}">
                        {{ $author->name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="title" class="form-label fw-semibold">Book Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title">
            </div>

            <div class="col-md-6">
                <label for="publisher" class="form-label fw-semibold">Publisher</label>
                <input type="text" name="publisher" id="publisher" class="form-control" placeholder="Enter publisher">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="published_date" class="form-label fw-semibold">Published Date</label>
                <input type="date" name="published_date" id="published_date" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="book_photo" class="form-label fw-semibold">Book Cover (Photo)</label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                <small class="text-muted">Max: 5MB (JPG, PNG, GIF)</small>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short book description"></textarea>
        </div>

        <div class="mb-4">
            <label for="book_pdf" class="form-label fw-semibold">Upload Book PDF</label>
            <input type="file" id="pdf" name="file" class="form-control" accept="application/pdf">
            <small class="text-muted">Max: 20MB (PDF only)</small>
        </div>

        <div class="d-flex justify-content-center g-5">
            <input type="submit" value="Add Book" class="btn btn-primary">
            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
        </div>

    </form>
</div>
@endsection
