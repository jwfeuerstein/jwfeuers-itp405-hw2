<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = DB::table('tracks')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('media_types', 'tracks.media_type_id', '=', 'media_types.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.id',
                'tracks.name',
                'albums.title AS album',
                'artists.name AS artist',
                'media_types.name AS media_type',
                'genres.name AS genre',
                'tracks.unit_price'
            ]);

        return view('tracks.index', [
            'tracks' => $tracks,
        ]);
    }

    public function create()
    {
        $albums = DB::table('albums')
            ->orderBy('title')
            ->get();
        $media_types = DB::table('media_types')
            ->get();
        $genres = DB::table('genres')
            ->orderBy('name')
            ->get();

        return view('tracks.create', [
            'albums' => $albums,
            'media_types' => $media_types,
            'genres' => $genres,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'album' => 'required|exists:albums,id',
            'media_type' => 'required|exists:media_types,id',
            'genre' => 'required|exists:genres,id',
            'unit_price' => 'required|numeric'

        ]);

        //Get the max id from that table and add 1 to it
        $seq = DB::table('tracks')->max('id') + 1;

        // alter the sequence to now RESTART WITH the new sequence index from above        
        DB::select('ALTER SEQUENCE ' . 'tracks' . '_id_seq RESTART WITH ' . $seq);

        DB::table('tracks')->insert([
            'name' => $request->input('title'),
            'album_id' => $request->input('album'),
            'media_type_id' => $request->input('media_type'),
            'genre_id' => $request->input('genre'),
            'unit_price' => $request->input('unit_price')
        ]);

        return redirect()
            ->route('tracks.index')
            ->with('success', " The track {$request->input('title')} was successfully created");
    }
}
