@extends('layouts.adminlte')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <div class="container bg-light my-3">
        <button type="button" class="btn btn-sm btn-outline-success mb-2" data-bs-toggle="modal"
            data-bs-target="#createAuthorModal">
            Create
        </button>
        <table class="table table-bordered data-table ">
            <thead>
                <tr>
                    <th>Sr No</th>

                    <th>Author Name</th>

                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <!-- Create Author Modal -->
    <div class="modal" id="createAuthorModal" tabindex="-1" aria-labelledby="createAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAuthorModalLabel">Create New Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('authors.store') }}" id="createAuthorForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="authorName" class="form-label">Author Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="authorName"
                                name="name" placeholder="Enter author name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            {{-- @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error )
                                       <li>{{ $error }}</li> 
                                    @endforeach
                                </ul>
                            </div>
                            @endif --}}
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Author Modal -->
    <div class="modal " id="updateAuthorModal" tabindex="-1" aria-labelledby="updateAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAuthorModalLabel">Update Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="updateAuthorForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="updateAuthorId" name="id">
                        <div class="mb-3">
                            <label for="updateAuthorName" class="form-label">Author Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="updateAuthorName" name="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.editAuthor', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#updateAuthorId').val(id);
            $('#updateAuthorName').val(name);
            $('#updateAuthorForm').attr('action', `/authors/update/${id}`);
        });
    </script>
    @if(session('errors'))
        <script>
            $('#createAuthorModal').modal('show');
        </script>
    @endif
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(function() {

            var table = $j('.data-table').DataTable({
                processing: true,
                serverSide: true,
                /*ordering: false,*/
                iDisplayLength: 10,
                retrieve: true,
                ajax: "{{ route('authors.index') }}",
                columns: [

                    {
                        data: "DT_RowIndex",
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                responsive: true,
            });

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@endsection
