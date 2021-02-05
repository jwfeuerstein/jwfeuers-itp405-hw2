@extends('layouts.main')

@section('title')
    Playlist: {{$playlist->name}}
@endsection

@section('content')
    <a href="/playlists" class="d-block mb-3">Back to Playlists</a>
    <p>Total tracks: {{count($tracks)}}</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Track</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
            <tr>
                <td>{{$track->name}}</td>
                <td>{{$track->album}}</td>
                <td>{{$track->artist}}</td>
                <td>{{$track->genre}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection