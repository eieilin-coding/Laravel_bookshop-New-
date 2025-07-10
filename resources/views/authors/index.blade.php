@extends('auth.home')

@section('content')
  <div class="container">
  <h2></h2>
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

<script type="text/javascript">
 var $j = jQuery.noConflict();
 $j(function () {
       
     var table = $j('.data-table').DataTable({
         processing: true,
         serverSide: true,
          /*ordering: false,*/
          iDisplayLength: 25,
          retrieve: true,
         ajax: "{{ route('authors.index') }}",
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
