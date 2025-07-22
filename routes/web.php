<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\NewsletterController;


Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::get('auth/loginRegister', 'loginRegister')->name('loginRegister');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::controller(AuthorController::class)->group(function () {
        Route::get('/authors/index', 'index')->name('authors.index');
        Route::get('/authors/test', 'index')->name('authors.test');
        Route::post('/authors/store', 'store')->name('authors.store');
        
        Route::post('/authors/update/{id}', 'update')->name('authors.update');
        Route::get('authors/delete/{id}', 'delete')->name('authors.delete');
    });
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories/index', 'index')->name('categories.index');
        Route::post('/categories/store', 'store')->name('categories.store');
        Route::post('/categories/update/{id}', 'update')->name('categories.update');
        Route::get('/categories/delete/{id}', 'delete')->name('categories.delete');
    });
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/index', 'index')->name('users.index');
        Route::get('users/suspended/{id}', 'suspended')->name('users.suspended');
        Route::get('users/unsuspended/{id}', 'unsuspended')->name('users.unsuspended');
        Route::get('/users/delete/{id}', 'delete')->name('users.delete');
    });
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::controller(BookController::class)->group(function () {
        Route::get('/books/adminIndex', 'adminIndex')->name('books.adminIndex');
        // Route::get('/books/adminInd', 'adminInd')->name('books.adminInd');

        Route::get('/books/create', 'create')->name('books.create');
        Route::post('/books/create', 'store')->name('books.store');

        Route::get('/books/edit/{id}', 'edit')->name('books.edit');
        Route::post('/books/edit/{id}', 'update')->name('books.update');

        Route::get('/books/delete/{id}', 'delete')->name('books.delete');
    });
});

Route::controller(BookController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/books/index', 'index')->name('books.index');
    Route::get('/books/show/{id}', 'show')->name('books.show');
    Route::get('/books/explore', 'explore')->name('books.explore');
    Route::get('/books/featuredBooks', 'featured')->name('books.featuredBooks');
    Route::get('/books/discountBooks', 'discount')->name('books.discountBooks');
    Route::get('/books/newBooks', 'new')->name('books.newBooks');
});

Route::controller(BookController::class)->group(function () {
    Route::get('/books/{id}/download', 'download')->name('books.download');
 });

// Route::group(['middleware' => ['auth', 'role:user|admin']], function () {
//     Route::controller(BookController::class)->group(function () {
//         Route::get('/books/{id}/download', 'download')->name('books.download');
//     });
// });

//  Route::get('/layouts/userview', function () {
//     return view('layouts.userview');
// });


Route::get('/layouts/userview', [BookController::class, 'userview'])->name('layouts.userview');


Route::get('/books/byCategory/{id}', [BookController::class, 'byCategory'])->name('books.byCategory');
Route::get('/books/byAuthor/{id}', [BookController::class, 'byAuthor'])->name('books.byAuthor');


// Subscription routes
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');
Route::get('/verify-subscription/{token}', [SubscriptionController::class, 'verify'])->name('verify-subscription');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified', 'can:admin'])->group(function () {
    Route::get('/subscribers', [NewsletterController::class, 'index'])->name('admin.subscribers');
    Route::post('/send-newsletter', [NewsletterController::class, 'send'])->name('admin.send-newsletter');
});


