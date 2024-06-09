<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('user/index', [UserController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user/show', [UserController::class, 'show']);
    Route::post('logout', [UserController::class, 'logout']);
    
    // Rute untuk menampilkan daftar buku
    Route::get('/books', [App\Http\Controllers\API\BookController::class, 'index']);

    // Rute untuk menyimpan buku baru
    Route::post('/books', [App\Http\Controllers\API\BookController::class, 'store']);

    // Rute untuk menampilkan detail buku
    Route::get('/books/{book}', [App\Http\Controllers\API\BookController::class, 'show']);

    // Rute untuk memperbarui buku yang ada
    Route::patch('/books/{book}', [App\Http\Controllers\API\BookController::class, 'update']);

    // Rute untuk menghapus buku
    Route::delete('/books/{book}', [App\Http\Controllers\API\BookController::class, 'destroy']);

    // Rute untuk memperbarui status buku
    Route::patch('/books/{book}/update-status', [App\Http\Controllers\API\BookController::class, 'updateStatus']);
});