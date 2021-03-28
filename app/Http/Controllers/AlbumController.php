<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Album;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = DB::table('albums')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->join('users', 'users.id', '=', 'albums.user_id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get([
                'albums.id',
                'albums.title',
                'artists.name AS artist',
                'users.name AS user',
                'users.id AS userId'
            ]);
        return view('album.index', [
            'albums' => $albums,
        ]);
    }

    public function create()
    {
        $artists = DB::table('artists')
            ->orderBy('name')
            ->get();
        return view('album.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id'
        ]);

        //Get the max id from that table and add 1 to it
        $seq = DB::table('albums')->max('id') + 1;

        // alter the sequence to now RESTART WITH the new sequence index from above        
        DB::select('ALTER SEQUENCE ' . 'albums' . '_id_seq RESTART WITH ' . $seq);

        DB::table('albums')->insert([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
            'user_id' => Auth::user()->id
        ]);

        return redirect()
            ->route('album.index')
            ->with('success', "Successfully created {$request->input('title')}");
    }

    public function edit($id)
    {
        $artists = DB::table('artists')
            ->orderBy('name')
            ->get();
        //$album = DB::table('albums')->where('id', '=', $id)->first();
        $album = Album::find($id);
        if (Gate::denies('edit-album', $album)) {
            abort(403);
        }

        return view('album.edit', [
            'artists' => $artists,
            'album' => $album
        ]);
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id'
        ]);

        $album = Album::find($id);
        if (Gate::denies('edit-album', $album)) {
            abort(403);
        }

        DB::table('albums')->where('id', '=', $id)->update([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist')
        ]);

        return redirect()
            ->route('album.edit', ['id' => $id])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
