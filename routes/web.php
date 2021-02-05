<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;

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
