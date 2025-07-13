 @extends('layouts.adminlte')

 @section('content')
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" rel="stylesheet"></script>
     <div class="container">
         <h2></h2>
         <a href="{{ url('/books/create') }}" class="btn btn-sm btn-outline-success my-2">Create</a>

         <table class="table table-bordered data-table ">
             <thead>
                 <tr>
                     <th>Sr No</th>
                     <th>Title</th>
                     <th>Author</th>
                     <th>Category</th>
                     <th>Status</th> <!-- Added status column -->
                     <th>Photo</th>
                     <th>File</th>
                     <th width="150px">Action</th>
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
                 ajax: "{{ route('books.adminInd') }}",
                 columns: [

                     {
                         data: "DT_RowIndex",
                         name: 'DT_RowIndex',
                         searchable: false,
                         orderable: false
                     },
                     {
                         data: 'title',
                         name: 'title'
                     },
                     {
                         data: 'author.name',
                         name: 'author.name',
                         render: function(data, type, row) {
                             return row.author ? row.author.name : '';
                         }
                     },
                     {
                         data: 'category.name',
                         name: 'category.name',
                         render: function(data, type, row) {
                             return row.category ? row.category.name : '';
                         }
                     },
                     {
                         data: 'status',
                         name: 'deleted_at',
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: 'photo',
                         name: 'photo'
                     },
                     {
                         data: 'file',
                         name: 'file'
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
 @endsection
