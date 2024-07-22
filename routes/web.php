<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book-detail/{id}', [HomeController::class, 'detail'])->name('book-detail');
Route::post('/save-review', [HomeController::class, 'saveReview'])->name('save-review');

Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
           Route::get('register', [AccountController::class, 'register'])->name('account.register');
        Route::post('register', [AccountController::class, 'RegisterUser'])->name('account.RegisterUser');
        
           Route::get('login', [AccountController::class, 'login'])->name('account.login');
        Route::post('login', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateprofile');
        Route::get('logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::get('book', [BookController::class, 'index'])->name('book-list.index');
        Route::get('book/create', [BookController::class, 'create'])->name('book.create');
        Route::post('book/store', [BookController::class, 'store'])->name('book.store');
         Route::get('book/edit{id}', [BookController::class, 'edit'])->name('book.edit');
          Route::post('book/edit{id}', [BookController::class, 'update'])->name('book.update');
            Route::delete('book/delete{id}', [BookController::class, 'delete'])->name('book.delete');

    });
});
