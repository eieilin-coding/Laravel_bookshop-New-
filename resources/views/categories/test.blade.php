@extends('layouts.adminlte')

@section('content')
<div class="container my-3">
    <button class="btn btn-success mb-2" id="createNewCategory">Create Category</button>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Category Name</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Create/Edit Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="categoryForm">
      @csrf
      <input type="hidden" name="id" id="category_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="categoryModalLabel">Create Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- DataTables & Script -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    const table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('categories.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Show create modal
    $('#createNewCategory').click(function () {
        $('#categoryForm').trigger("reset");
        $('#category_id').val('');
        $('#categoryModalLabel').text("Create Category");
        let modal = new bootstrap.Modal(document.getElementById('categoryModal'));
        modal.show();
    });

    // Show edit modal
    $(document).on('click', '.editCategory', function () {
        var id = $(this).data('id');
        $.get("{{ url('categories/edit') }}/" + id, function (data) {
            $('#categoryModalLabel').text("Edit Category");
            $('#category_id').val(data.id);
            $('#name').val(data.name);
            let modal = new bootstrap.Modal(document.getElementById('categoryModal'));
            modal.show();
        });
    });

    // Save category
    $('#categoryForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('categories.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function () {
                let modalEl = document.getElementById('categoryModal');
                bootstrap.Modal.getInstance(modalEl).hide();
                table.ajax.reload();
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // Delete category
    $(document).on('click', '.deleteCategory', function () {
        var id = $(this).data('id');
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "{{ url('categories/delete') }}/" + id,
                method: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function () {
                    table.ajax.reload();
                }
            });
        }
    });
});
</script>
@endsection
