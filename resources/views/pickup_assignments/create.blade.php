@extends('layouts.app')
@section('title', 'Assign Pickup')

@section('content')
<h1>Assign Driver to Pickup</h1>
<form action="{{ route('pickup-assignments.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Pickup Order</label>
        <select name="pickup_order_id" class="form-select @error('pickup_order_id') is-invalid @enderror" required>
            <option value="">Select Order</option>
            @foreach(\App\Models\PickupOrder::where('status', 'pending')->get() as $order)
                <option value="{{ $order->id }}" {{ old('pickup_order_id') == $order->id ? 'selected' : '' }}>
                    #{{ $order->id }} - {{ $order->plastic_type }} ({{ $order->address }})
                </option>
            @endforeach
        </select>
        @error('pickup_order_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label>Driver</label>
        <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror" required>
            <option value="">Select Driver</option>
            @foreach(\App\Models\Driver::where('status', 'available')->get() as $driver)
                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                    {{ $driver->name }} ({{ $driver->phone_number }})
                </option>
            @endforeach
        </select>
        @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Assign</button>
    <a href="{{ route('pickup-assignments.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection