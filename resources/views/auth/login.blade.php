@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
 <!--==================== LOGIN ====================-->
    <div class="#" style="padding-top: 100px;" >
        <form action="{{ route('authenticate') }}" method="post" class="login__form grid">
            @csrf
            <h3 class="login__title">Log In</h3>
            <div class="login__group grid">
                <div>
                    <label for="login-email" class="login__label">Email</label>
                    <input type="email" placeholder="Write your email" id="login-email"
                        class="login__input @error('email') is-invalid @enderror" name="email" id="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="login-pass" class="login__label">Password</label>
                    <input type="password" placeholder="Enter your password" id="login-pass"
                        class="login__input @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <span class="login__signup">
                        You do not have an account? <a href="{{ route('register') }}">Sign up</a>
                    </span>
                    <a href="#" class="login__forgot">
                        You forgot your password
                    </a>
                    <input type="submit" class="login__button button" value="Login" id="login-button">

                </div>
            </div>
        </form>
    </div>
@endsection