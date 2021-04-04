@extends('layouts.main')

@section('title', 'Settings')

@section('content')
<form action="{{route('maintenance.set')}}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-check-label" for="maintenance" class="form-label">Set Maintenance Mode</label>
        <input class="form-check-input" type="checkbox" name="maintenance" id="maintenance" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">
        Save
    </button>
</form>
<br/>
<br/>
<br/>
<br/>
<form action="{{route('email.stats')}}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        Email Stats to Users
    </button>
</form>

@endsection