@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Misi Kamu</h1>

    @if($missions->count() > 0)
        <div class="row">
            @foreach($missions as $mission)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $mission->title }}</h5>
                        <p class="card-text">{{ $mission->description }}</p>
                        <span class="badge bg-{{ $mission->is_completed ? 'success' : 'warning' }}">
                            {{ $mission->is_completed ? 'Selesai' : 'Belum Selesai' }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>Belum ada misi. Coba kumpulkan plastik!</p>
    @endif
</div>
@endsection