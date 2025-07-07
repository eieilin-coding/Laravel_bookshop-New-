@extends('auth.home')

@section('content')
    <div class="app-content-header mt-2">
        <div class="app-content">
            <div class="container mt-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }} </td>
                            <td>{{ $user->email }} </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning update-btn text-black"
                                        data-bs-toggle="modal" data-bs-target="#updateUserModal"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                        Ban
                                    </button>                    
                                    <a href="{{ $user->id }}" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
         {{ $users->links() }}
    </div>
@endsection
