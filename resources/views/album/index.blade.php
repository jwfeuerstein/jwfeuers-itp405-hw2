@extends('layouts.main')

@section('title', 'Albums')

@section('content')

    @if(Auth::check())
    <div class="text-end mb-3">
        <a href={{route('album.create')}}>New Album</a>
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Album</th>
                <th>Artist</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
            <tr>
                <td>
                    {{$album ->title}}
                </td>
                <td>
                    {{$album ->artist}}
                </td>
                <td>
                    {{$album ->user}}
                </td>
                @if(Auth::check())
                @if((Auth::user()->id === $album->userId) || (Auth::user()->role->slug === 'admin'))
                <td>
                    <a href="{{route('album.edit', [ 'id' => $album->id ])}}">
                        Edit
                    </a>
                </td>
                @endif
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection