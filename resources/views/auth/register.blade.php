@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!--==================== Register ====================-->
    <div class="#" id="register-content" style="padding-top: 100px;">
        <form action="{{ route('store') }}" method="post" class="register__form grid">
            @csrf
            <h3 class="register__title">Register</h3>
            <div class="register__group grid">
                <div>
                    <label for="register-name" class="register__label">Name</label>
                    <input type="input" placeholder="Write your name" id="register-name"
                        class="register__input @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="register-email" class="register__label">Email</label>
                    <input type="email" placeholder="Write your email" id="register-email"
                        class="register__input @error('email') is-invalid @enderror" name="email" id="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="register-pass"
                        class="register__label @error('password') is-invalid @enderror">Password</label>
                    <input type="password" placeholder="Enter your password" id="register-pass"
                        class="register__input" id="password" name="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="register-pass" class="register__label @error('password') is-invalid @enderror">Confirm
                        Password</label>
                    <input type="password" placeholder="Enter confirm password" id="register-pass"
                        class="register__input" id="password_confirmation" name="password_confirmation">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <span class="register__signup">
                        Already have an account? <a href="{{ route('login') }}">Log In</a>
                    </span>

                    <input type="submit" class="register__button button" value="register" id="register-button">

                </div>
            </div>
        </form>
    </div>    
@endsection