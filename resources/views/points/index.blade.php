@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Riwayat Poin</h1>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-lg font-bold">
            {{ number_format($totalPoints) }} PTS
        </div>
    </div>

    @if($transactions->count() > 0)
        <div class="space-y-3">
            @foreach($transactions as $tx)
            <div class="bg-white p-4 rounded-lg shadow-sm border flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $tx->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-gray-600">{{ $tx->weight / 1000 }} kg plastik</p>
                </div>
                <span class="text-green-600 font-bold">+{{ $tx->points_earned }} PTS</span>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">Belum ada poin. Mulai kumpulkan plastik!</p>
        </div>
    @endif
</div>
@endsection