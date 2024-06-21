<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LikeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::post('/like/{album_id}', [LikeController::class, 'like'])->name('like.save');

    Route::prefix('album')->name('album.')->group(function () {
        Route::get('/', [AlbumController::class, 'index'])->name('index');
        Route::get('/home', [AlbumController::class, 'home'])->name('home');
        Route::get('/create', [AlbumController::class, 'create'])->name('create');
        Route::post('/save', [AlbumController::class, 'save'])->name('save');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__.'/auth.php';
