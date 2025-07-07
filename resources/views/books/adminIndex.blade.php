 @extends('auth.home')

 @section('content')
 <div class="app-content-header">
     <div class="app-content">
         <div class="container mt-0">
             <a href="{{ url('/books/create') }}" class="btn btn-sm btn-outline-success my-2">Create</a>
             <div class="table-responsive">
                 <table class="table table-striped table-bordered">
                     <tr>
                         <th>Title</th>
                         <th>Author</th>
                         <th>Category</th>
                         <th>Photo</th>
                         <th>File</th>
                         <th>Action</th>
                     </tr>

                      @foreach ($books as $book)
                     <tr>
                         <td>{{ $book->title }}</td>
                         <td>{{ $book->author->name }}</td>
                         <td>{{ $book->category->name }}</td>
                         <td>{{ $book->photo }}</td>
                         <td>{{ $book->file }}</td>
                         <td>
                             <div class="btn-group">
                                 <a href="{{ url("/books/edit/$book->id") }}"
                                     class="btn btn-sm btn-outline-primary">Update</a>
                                 <a href="{{ url("/books/show/$book->id") }}"
                                     class="btn btn-sm btn-outline-info">View</a>
                                 @if ($book->temp_delete)
                                 <a href="{{ url("/books/hide_book/$book->id") }}"
                                     class="btn btn-sm btn-outline-warning text-black"
                                     onclick="return confirm('Are you sure?')">Hide</a>
                                 @else
                                 <a href="{{ url("/books/show_book/$book->id") }}"
                                     class="btn btn-sm btn-success text-white"
                                     onclick="return confirm('Are you sure?')">Show</a>
                                 @endif
                                 <a href="{{ url("/books/delete/$book->id") }}" class="btn btn-sm btn-outline-danger"
                                     onclick="return confirm('Are you sure?')">Delete</a>
                             </div>
                         </td>
                     </tr>
                     @endforeach
                 </table>
             </div>
         </div>
     </div>
     {{ $books->links() }}
     <!--end::Container-->
 </div>
 @endsection
