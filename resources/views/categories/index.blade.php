@extends('layouts.adminlte')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <div class="container bg-light my-3">
        <button type="button" class="btn btn-sm btn-outline-success mb-2" data-bs-toggle="modal"
            data-bs-target="#createCategoryModal">
            Create
        </button>
        <table class="table table-bordered data-table ">
            <thead>
                <tr>
                    <th>Sr No</th>

                    <th>Category Name</th>

                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Create Category Modal -->
    <div class="modal" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.store') }}" id="createCategoryForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name"
                                placeholder="Enter category name">
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

    <!-- Update Category Modal -->
    <div class="modal " id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="updateCategoryForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="updateCategoryId" name="id">
                        <div class="mb-3">
                            <label for="updateCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="updateCategoryName" name="name">
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
        $(document).on('click', '.editCategory', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#updateCategoryId').val(id);
            $('#updateCategoryName').val(name);
            $('#updateCategoryForm').attr('action', `/categories/update/${id}`);
        });
    </script>


    </script>
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(function() {

            var table = $j('.data-table').DataTable({
                processing: true,
                serverSide: true,
                /*ordering: false,*/
                iDisplayLength: 10,
                retrieve: true,
                ajax: "{{ route('categories.index') }}",
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

    <script>
        // Handle create form submission
        $('#createCategoryForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('categories.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createCategoryModal').modal('hide');
                    $('.data-table').DataTable().ajax.reload();
                    alert('Category created successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '\n';
                        });
                        alert(errorMessage);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
    </script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@endsection
