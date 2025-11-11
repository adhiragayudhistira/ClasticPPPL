@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Find Drop-off Point</h1>
    <form action="{{ route('dropoff.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection