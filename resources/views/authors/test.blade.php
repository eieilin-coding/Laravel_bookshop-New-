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
            <tbody></tbody>
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
                            <input type="text" class="form-control" id="authorName" name="name" placeholder="Enter author name">
                            <span class="text-danger error-text name_error"></span>
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
    <div class="modal" id="updateAuthorModal" tabindex="-1" aria-labelledby="updateAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAuthorModalLabel">Update Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="updateAuthorForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="updateAuthorId" name="id">
                        <div class="mb-3">
                            <label for="updateAuthorName" class="form-label">Author Name</label>
                            <input type="text" class="form-control" id="updateAuthorName" name="name">
                            <span class="text-danger error-text name_error"></span>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
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

            // Handle edit button click
            $(document).on('click', '.editAuthor', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                $('#updateAuthorId').val(id);
                $('#updateAuthorName').val(name);
                $('#updateAuthorForm').attr('action', '/authors/' + id);
                
                // Clear previous errors
                $('#updateAuthorForm').find('.error-text').text('');
                $('#updateAuthorModal').modal('show');
            });

            // Handle create form submission
            $('#createAuthorForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                
                // Clear previous errors
                form.find('.error-text').text('');
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == 'success') {
                            $('#createAuthorModal').modal('hide');
                            form.trigger('reset');
                            table.ajax.reload();
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(prefix, val) {
                                form.find('span.'+prefix+'_error').text(val[0]);
                            });
                        } else {
                            toastr.error('An error occurred');
                        }
                    }
                });
            });

            // Handle update form submission
            $('#updateAuthorForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                let url = form.attr('action');
                
                // Clear previous errors
                form.find('.error-text').text('');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == 'success') {
                            $('#updateAuthorModal').modal('hide');
                            table.ajax.reload();
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(prefix, val) {
                                form.find('span.'+prefix+'_error').text(val[0]);
                            });
                        } else {
                            toastr.error('An error occurred');
                        }
                    }
                });
            });

            // Reset create form when modal is closed
            $('#createAuthorModal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
                $(this).find('.error-text').text('');
            });
        });
    </script>
@endsection