@extends('layouts.adminlte')

@section('content')
<div class="container bg-light my-3">
  <a href="{{ url('/categories/create') }}" class="btn btn-sm btn-success my-2">Create</a>
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

<script type="text/javascript">
 var $j = jQuery.noConflict();
 $j(function () {
       
     var table = $j('.data-table').DataTable({
         processing: true,
         serverSide: true,
          /*ordering: false,*/
          iDisplayLength: 10,
          retrieve: true,
         ajax: "{{ route('categories.index') }}",
         columns: [

              {data: "DT_RowIndex", name: 'DT_RowIndex',searchable: false, orderable: false},
              {data: 'name' , name: 'name'},
             {data: 'action', name: 'action'},
         ],
          responsive: true,
     });
       
   });
</script>

@endsection
