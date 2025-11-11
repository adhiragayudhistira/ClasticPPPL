@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Drop-off Points</h1>
    <a href="{{ route('dropoff.create') }}" class="btn btn-success">Find Drop-off</a>
</div>
@endsection