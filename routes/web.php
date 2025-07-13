<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');



Route::controller(BookController::class)->group(function() {
Route::get('/', 'index')->name('index');
Route::get('/books/index', 'index')->name('books.index');
Route::get('/books/adminIndex', 'adminIndex')->name('books.adminIndex');
Route::get('/books/adminInd', 'adminInd')->name('books.adminInd');
Route::get('/books/show/{id}', 'show')->name('books.show');

Route::get('/books/create', 'create')->name('books.create');
Route::post('/books/create', 'store')->name('books.store');

Route::get('/books/edit/{id}', 'edit')->name('books.edit');
Route::post('/books/edit/{id}','update')->name('books.update');

// Route::get('/books/hide_book/{id}', 'hide_book')->name('hide_book');
// Route::get('/books/show_book/{id}', 'show_book')->name('show_book');
Route::get('/books/delete/{id}', 'delete')->name('books.delete');


});


// Route::get('/', [BookController::class,'index']);
// Route::get('/books/index', [BookController::class,'index']);
// Route::get('/books/adminIndex', [BookController::class,'adminIndex']);
// Route::get('/books/show/{id}', [BookController::class, 'show']);


Route::get('/authors/index', [AuthorController::class,'index'])->name('authors.index');
Route::get('authors/edit/{id}', [AuthorController::class,'edit'])->name('authors.edit');
Route::get('authors/delete/{id}', [AuthorController::class,'delete'])->name('authors.delete');

Route::get('/users/index', [UserController::class,'index'])->name('users.index');
Route::get('users/suspended/{id}', [UserController::class, 'suspended'])->name('users.suspended');
Route::get('users/unsuspended/{id}', [UserController::class, 'unsuspended'])->name('users.unsuspended');
Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');


Route::get('/categories/index', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/test', [CategoryController::class, 'index'])->name('categories.test');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');


Route::post('/books/{id}/archive', [BookController::class, 'archive'])->name('books.archive');
Route::post('/books/{id}/restore', [BookController::class, 'restore'])->name('books.restore');

// Route::get('books/index1' , function() {
//     return view('books.index1');});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/books/{id}/download', [BookController::class, 'download'])->name('books.download');
    // ->middleware('auth'); // Optional auth protection
