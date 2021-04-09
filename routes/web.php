<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\EloquentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaintenanceController;
use App\Jobs\SendStatistics;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAlbum;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Track;

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}

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

/*
Route::get('/mail', function () {
    //Mail::raw('What is your favorite framework?', function ($message) {
    //    $message->to('jwfeuers@usc.edu')->subject('Hello David');
    //});

    //$someAlbum = Album::first();
    //Mail::to('dtang@usc.edu')->send(new NewAlbum($someAlbum));

    //$jaggedLittlePill = Album::find(6);
    //Mail::to('itp@usc.edu')->queue(new NewAlbum($jaggedLittlePill));

    $numArtists = Artist::count();
    $numPlaylists = Playlist::count();
    $tracks = Track::all();
    $totalTime = 0;
    foreach ($tracks as $track) {
        $totalTime = $totalTime + $track->milliseconds;
    }

    $totalTime = round(($totalTime / 60000), 0);

    //$jaggedLittlePill = Album::find(6);
    SendStatistics::dispatch($numArtists, $numPlaylists, $totalTime);
});
*/



Route::post('/stats', function () {
    $numArtists = Artist::count();
    $numPlaylists = Playlist::count();
    $tracks = Track::all();
    $totalTime = 0;
    foreach ($tracks as $track) {
        $totalTime = $totalTime + $track->milliseconds;
    }

    $totalTime = round(($totalTime / 60000), 0);

    SendStatistics::dispatch($numArtists, $numPlaylists, $totalTime);

    return redirect()
        ->route('maintenance.admin')
        ->with('success', "Sent statistics email to all users.");
})->name('email.stats');


Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');


Route::middleware(['custom-auth'])->group(function () {
    Route::middleware(['check-admin'])->group(function () {
        Route::get('/admin', [MaintenanceController::class, 'admin'])->name('maintenance.admin');
        Route::post('/admin', [MaintenanceController::class, 'setAdmin'])->name('maintenance.set');
    });
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
    Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
    Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');
});

Route::middleware(['maintenance-mode'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');


    Route::get('/playlists', [PlaylistController::class, 'pindex'])->name('playlists.pindex');
    Route::get('/playlists/{id}', [PlaylistController::class, 'pshow'])->name('playlists.pshow');
    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlists.update');


    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');


    Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::get('/tracks/new', [TrackController::class, 'create'])->name('tracks.create');
    Route::post('/tracks', [TrackController::class, 'store'])->name('tracks.store');

    Route::get('/eloquent', [EloquentController::class, 'index'])->name('eloquent.index');
    Route::get('/eloquent/create', [EloquentController::class, 'create'])->name('eloquent.create');
    Route::post('/eloquent', [EloquentController::class, 'store'])->name('eloquent.store');
    Route::get('/eloquent/{id}/edit', [EloquentController::class, 'edit'])->name('eloquent.edit');
    Route::post('/eloquent/{id}', [EloquentController::class, 'update'])->name('eloquent.update');

    Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
    Route::post('/register', 'App\Http\Controllers\RegistrationController@register')->name('registration.create');
});
