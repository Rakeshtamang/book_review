<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book-detail/{id}', [HomeController::class, 'detail'])->name('book-detail');
Route::post('/save-review', [HomeController::class, 'saveReview'])->name('save-review');

// Account Routes
Route::group(['prefix' => 'account'], function () {
    // Guest Middleware Routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('register', [AccountController::class, 'register'])->name('account.register');
        Route::post('register', [AccountController::class, 'RegisterUser'])->name('account.RegisterUser');
        
        Route::get('login', [AccountController::class, 'login'])->name('account.login');
        Route::post('login', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    // Auth Middleware Routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateprofile');
        Route::get('logout', [AccountController::class, 'logout'])->name('account.logout');

        // Book Routes
        Route::get('book', [BookController::class, 'index'])->name('book-list.index');
        Route::get('book/create', [BookController::class, 'create'])->name('book.create');
        Route::post('book/store', [BookController::class, 'store'])->name('book.store');
        Route::get('book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
        Route::post('book/edit/{id}', [BookController::class, 'update'])->name('book.update');
        Route::delete('book/delete/{id}', [BookController::class, 'delete'])->name('book.delete');

        // Review Routes
        Route::get('review', [ReviewController::class, 'index'])->name('account.adminreviews');
        Route::get('review/{id}', [ReviewController::class, 'edit'])->name('account.reviews.edit');
        Route::post('review/{id}', [ReviewController::class, 'updateReview'])->name('account.reviews.update');
        Route::post('review/delete', [ReviewController::class, 'deleteReview'])->name('account.reviews.deleteReview');

Route::get('myreview', [AccountController::class, 'myReviews'])->name('myreviews.myReviews');
Route::get('myreview/{id}/edit', [AccountController::class, 'editMyReview'])->name('myreviews.editMyReview');

Route::post('myreview/{id}/update', [AccountController::class, 'updateMyReview'])->name('account.reviews.updateReview');
 Route::post('myreview/{id}/delete', [AccountController::class, 'deleteMyReview'])->name('myreviews.deleteMyReview');

        
    });
});