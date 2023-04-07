<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::resource('boards', BoardController::class);
// Route::get('boards', [ BoardController::class, 'index' ])->name('boards.index');
Route::prefix('boards')->middleware(['auth'])
    ->controller(BoardController::class)
    ->name('boards.')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}', 'update')->name('update');
        Route::post('/{id}/destroy', 'destroy')->name('destroy');
    });

Route::prefix('users')->middleware(['auth'])
    ->controller(UserController::class)
    ->name('users.')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
