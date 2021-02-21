<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function pindex()
    {
        $playlists = DB::table('playlists')
            ->get([
                'id',
                'name',
            ]);

        return view('playlists.pindex', [
            'playlists' => $playlists,
        ]);
    }

    public function pshow($id)
    {
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();

        $tracks = DB::table('playlists')
            ->where('playlists.id', '=', $id)
            ->join('playlist_track', 'playlists.id', '=', 'playlist_track.playlist_id')
            ->join('tracks', 'playlist_track.track_id', '=', 'tracks.id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.name',
                'albums.title as album',
                'artists.name as artist',
                'genres.name as genre'
            ]);

        return view('playlists.pshow', [
            'playlist' => $playlist,
            'tracks' => $tracks,
        ]);
    }

    public function edit($id)
    {
        $playlist = DB::table('playlists')->where('id', '=', $id)->first();
        return view('playlists.edit', [
            'playlist' => $playlist,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:30|unique:playlists,name'
        ]);
        $playlist = DB::table('playlists')->where('id', '=', $id)->first();

        DB::table('playlists')->where('id', '=', $id)->update([
            'name' => $request->input('name')
        ]);

        return redirect()
            ->route('playlists.pindex')
            ->with('success', "{$playlist->name} was successfully renamed to {$request->input('name')}");
    }
}
