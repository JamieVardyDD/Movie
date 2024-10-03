<?php
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'index']);
Route::post('/upload-movie', [MovieController::class, 'store']);
Route::get('/movies/search', [MovieController::class, 'search']);
Route::get('/', [MovieController::class, 'index']);  // Home route to display popular movies
Route::get('/movie/{id}', [MovieController::class, 'getMovieDetails']);  //