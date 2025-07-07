<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});



Route::controller(BookController::class)->group(function() {
Route::get('/', 'index')->name('index');
Route::get('/books/index', 'index')->name('index');
Route::get('/books/adminIndex', 'adminIndex')->name('adminIndex');
Route::get('/books/show/{id}', 'show')->name('show');

Route::get('/books/create', 'create')->name('create');
Route::post('/books/create', 'store')->name('store');

Route::get('/books/edit/{id}', 'edit')->name('edit');
Route::post('/books/edit/{id}','update')->name('update');

Route::get('/books/hide_book/{id}', 'hide_book')->name('hide_book');
Route::get('/books/show_book/{id}', 'show_book')->name('show_book');
Route::get('/books/delete/{id}', 'delete')->name('delete');


});


// Route::get('/', [BookController::class,'index']);
// Route::get('/books/index', [BookController::class,'index']);
// Route::get('/books/adminIndex', [BookController::class,'adminIndex']);
// Route::get('/books/show/{id}', [BookController::class, 'show']);


Route::get('/categories/index', [CategoryController::class,'index']);

Route::get('/authors/index', [AuthorController::class,'index']);

Route::get('/users/index', [UserController::class,'index']);

// Route::get('/', function () {
//     return view('index');
// });
