@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Send Newsletter</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.send-newsletter') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send to {{ $subscribers->count() }} Subscribers</button>
                    </form>

                    <hr>

                    <h4>Subscribers List</h4>
                    <ul class="list-group mt-3">
                        @foreach($subscribers as $subscriber)
                            <li class="list-group-item">{{ $subscriber->email }} (since {{ $subscriber->verified_at->format('M d, Y') }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection