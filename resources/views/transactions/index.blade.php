@extends('layouts.app')
@section('title', 'Transactions')

@section('content')
<h1 class="mb-4">Transactions</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Type</th>
            <th>Points</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->user->name }}</td>
            <td>{{ ucfirst($t->transaction_type) }}</td>
            <td>{{ $t->points_earned }}</td>
            <td>{{ $t->transaction_date?->format('d M Y') }}</td>
            <td><span class="badge bg-{{ $t->status == 'completed' ? 'success' : 'warning' }}">{{ $t->status }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection