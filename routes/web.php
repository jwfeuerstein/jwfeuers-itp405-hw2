<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\EloquentController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');

Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');


Route::get('/playlists', [PlaylistController::class, 'pindex'])->name('playlists.pindex');
Route::get('/playlists/{id}', [PlaylistController::class, 'pshow'])->name('playlists.pshow');
Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlists.update');

Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
Route::get('/tracks/new', [TrackController::class, 'create'])->name('tracks.create');
Route::post('/tracks', [TrackController::class, 'store'])->name('tracks.store');

Route::get('/eloquent', [EloquentController::class, 'index'])->name('eloquent.index');
Route::get('/eloquent/create', [EloquentController::class, 'create'])->name('eloquent.create');
Route::post('/eloquent', [EloquentController::class, 'store'])->name('eloquent.store');
Route::get('/eloquent/{id}/edit', [EloquentController::class, 'edit'])->name('eloquent.edit');
Route::post('/eloquent/{id}', [EloquentController::class, 'update'])->name('eloquent.update');
