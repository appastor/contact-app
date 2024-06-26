<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NoteController;

Route::middleware(['auth'])->group(function () {
    Route::resource('contacts', ContactController::class);
    Route::post('contacts/{contact}/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
