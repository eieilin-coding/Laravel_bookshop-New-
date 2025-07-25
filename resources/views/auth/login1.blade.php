@extends('layouts.userview')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"/>
    
  <div class="wrapper">
    <span class="icon-close">
        <i class="fa-solid fa-xmark"></i>
    </span>
    <div class="form-box login">
        <h2>Login</h2>
        <form action="#">
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" required>
                <label>Email</label>
            </div>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                <input type="password" required>
                <label>Password</label>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" class="button">Login</button>
            <div class="login-register">
                <p>
                    Don't have an account? 
                    <a href="#" class="register-link">Register</a>
                </p>
            </div>
        </form>
    </div>

    <div class="form-box register">
        <h2>Registration</h2>
        <form action="#">
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-user"></i></span>
                <input type="text" required>
                <label>Username</label>
            </div>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" required>
                <label>Email</label>
            </div>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                <input type="password" required>
                <label>Password</label>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">I agree to the terms & conditions </label>
               
            </div>
            <button type="submit" class="button">Register</button>
            <div class="login-register">
                <p>
                    Already have an account? 
                    <a href="#" class="login-link">Login</a>
                </p>
            </div>
        </form>
    </div>
  </div>
  {{-- <script src="js/login.js"></script> --}}
  <script src="{{ asset('js/login.js') }}"> </script>


@endsection