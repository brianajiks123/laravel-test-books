<?php

use App\Http\Controllers\{
    AuthorController,
    BookController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/authors');
});

Route::resource('/authors', AuthorController::class)
    ->except('create', 'edit');
Route::resource('/books', BookController::class)
    ->except('create', 'edit');
