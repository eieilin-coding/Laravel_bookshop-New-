@extends('auth.home')

@section('content')
    <div class="app-content-header">
        <div class="app-content">
            <div class="container mt-0">
                <button type="button" class="btn btn-sm btn-outline-success my-2" data-bs-toggle="modal"
                    data-bs-target="#createCategoryModal">
                    Create
                </button>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Author Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($authors as $author)
                        <tr>
                            <td>{{ $author->name }} </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary update-btn"
                                        data-bs-toggle="modal" data-bs-target="#updateauthorModal"
                                        data-id="{{ $author->id }}" data-name="{{ $author->name }}">
                                        Update
                                    </button>                    
                                    <a href="{{ $author->id }}" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        {{ $authors->links() }}
    </div>
@endsection
