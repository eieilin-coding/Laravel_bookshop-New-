@section('content')

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Welcome</h1> --}}
@endsection

@section('content')
     @yield('content')
@endsection
    
@endsection