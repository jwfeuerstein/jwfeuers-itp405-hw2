@extends('layouts.email')

@section('content')
    <h1>Statistics</h1>
    <p>There are {{ $numArtists }} artists.</p>
    <p>There are {{ $numPlaylists }} playlists.</p>
    <p>The total time of all songs is {{$totalTime}} minutes.</p>
@endsection