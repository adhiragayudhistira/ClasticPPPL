@extends('layouts.app')

@section('title', '- Jemput Plastik')

@section('content')
<div class="container">
    <h2 class="text-primary mb-4">Jemput Plastik</h2>
    <form action="{{ route('pickup.store') }}" method="POST" class="card p-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Plastik</label>
            <select name="plastic_type" class="form-select" required>
                <option value="PET">PET (Botol Air Mineral)</option>
                <option value="HDPE">HDPE (Botol Sabun)</option>
                <option value="PP">PP (Kemasan Makanan)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Estimasi Berat (kg)</label>
            <input type="number" name="weight" step="0.1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Jemput</label>
            <input type="date" name="pickup_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection