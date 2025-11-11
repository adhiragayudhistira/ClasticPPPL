@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Ajukan Jemput Plastik</h1>
    <form action="{{ route('pickup.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Estimasi Berat (kg)</label>
            <input type="number" step="0.1" name="estimated_weight" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection