<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;

class EloquentController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')
            ->get()
            ->sortBy('artist.name');
        return view('eloquent.index', [
            'albums' => $albums,
        ]);
    }

    public function create()
    {
        $artists = Artist::orderBy('name')->get();
        return view('eloquent.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id'
        ]);

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();

        return redirect()
            ->route('eloquent.index')
            ->with('success', "Successfully created {$request->input('title')}");
    }

    public function edit($id)
    {
        $artists = Artist::orderBy('name')->get();
        $album = Album::find($id);
        return view('eloquent.edit', [
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
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();

        return redirect()
            ->route('eloquent.edit', ['id' => $id])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
