@extends('layouts.main')

@section('title', 'Playlists')

@section('content')
    <table>
        
        <thead>
            <tr>
                <th>Select a Playlist:</th>
                {{--
                <th>Date</th>
                <th>Customer</th>
                <th colspan="2">Total</th>
                --}}
            </tr>
        </thead>
        <tbody>
            @foreach($playlists as $playlist)
            <tr>
                <td>
                    <a href="{{route('playlists.pshow', ['id' => $playlist->id])}}">
                        {{$playlist->name}}
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection