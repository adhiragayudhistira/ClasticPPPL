@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Riwayat Jemput</h1>
    <a href="{{ route('pickup.create') }}" class="btn btn-success mb-3">Ajukan Jemput</a>

    @if($pickups->count() > 0)
        <div class="row">
            @foreach($pickups as $pickup)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Alamat:</strong> {{ $pickup->address }}</p>
                        <p><strong>Berat:</strong> {{ $pickup->estimated_weight / 1000 }} kg</p>
                        <span class="badge bg-{{ $pickup->status == 'pending' ? 'warning' : 'success' }}">
                            {{ ucfirst($pickup->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>Belum ada jemput. Ajukan sekarang!</p>
    @endif
</div>
@endsection