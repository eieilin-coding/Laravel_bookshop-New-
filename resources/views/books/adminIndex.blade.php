 @extends('layouts.adminlte')

 @section('content') 
                 
     <div class="container bg-light my-3">
         <a href="{{ url('/books/create') }}" class="btn btn-sm btn-outline-success my-2">Create</a>

         <table class="table table-bordered data-table ">
             <thead>
                 <tr>
                     <th>Sr No</th>
                     <th>Title</th>
                     <th>Author</th>
                     <th>Category</th>
                     <th>Photo</th>
                     <th>File</th>
                     <th width="130px">Action</th>
                 </tr>
             </thead>
             <tbody>


             </tbody>
         </table>
     </div>

     <script type="text/javascript">
         var $j = jQuery.noConflict();
         $j(function() {

             var table = $j('.data-table').DataTable({
                 processing: true,
                 serverSide: true,
                 /*ordering: false,*/
                 iDisplayLength: 10,
                 retrieve: true,
                 ajax: "{{ route('books.adminIndex') }}",
                 columns: [

                     { data: "DT_RowIndex",name: 'DT_RowIndex',searchable: false,orderable: false },
                     { data: 'title', name: 'title' },
                     { data: 'author.name', name: 'author.name', render: function(data, type, row) {
                        return row.author ? row.author.name : '';} },
                     { data: 'category.name', name: 'category.name', render: function(data, type, row) {
                        return row.category ? row.category.name : '';} },
                     { data: 'photo', name: 'photo' },
                     { data: 'file', name: 'file' },
                     { data: 'action',  name: 'action' },

                 ],
                 responsive: true,
             });

         });
     </script>
 @endsection
