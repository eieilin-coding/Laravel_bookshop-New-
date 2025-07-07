@extends("layouts.app")
 @section("content" )


<div class="card" style="width: 18rem;">
  <img src="{{ asset('storage/photos/' . $book->photo) }}" class="card-img-top" alt="Image Photo">
  <div class="card-body">
    <h5 class="card-title">{{ $book->title }}</h5>
    <p class="card-text">{{ $book->description }}</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">{{ $book->title }}</li>
    <li class="list-group-item">A second item</li>
    <li class="list-group-item">A third item</li>
  </ul>
  <div class="card-body">
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>

@endsection