<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
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

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
    Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
    Route::get('/store/show/{id}', [StoreController::class, 'show'])->name('store.show');
    Route::get('/store/{id}/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::delete('/store/delete/{id}', [StoreController::class, 'destroy'])->name('store.destroy');
    Route::put('/store/update/{id}', [StoreController::class, 'update'])->name('store.update');
    Route::post('/store/store', [StoreController::class, 'store'])->name('store.store');
});