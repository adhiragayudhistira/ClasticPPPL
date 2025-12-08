@extends('layouts.app')

@section('content')

<style>
/* Sembunyiin bottom nav di layout */
    .fixed, [class*="bottom"], [class*="nav"] { display: none !important; }
</style>

<div class="success-wrapper">

 <!-- Header -->
<div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white px-6 py-6 shadow-lg">
    <div class="flex items-center mb-2">
        <h1 class="text-2xl font-bold">Detail Exchange</h1>
    </div>
    <p class="text-teal-100 text-sm">Summary of your successful transaction</p>
</div>

    <!-- Content -->
    <div class="px-6 pt-4 pb-6">

        <!-- Check -->
        <div class="text-center">
            <div class="checkmark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-teal-600 mt-3 mb-1">Payment Made</h2>
            <p class="text-sm text-gray-600 mb-6">Your exchange has been processed successfully</p>
        </div>

        <!-- Info -->
        <h3 class="text-center text-gray-800 font-bold mb-4 text-lg">Information</h3>
        <div class="info-box">
            <!-- 1) Amount Received -->
            <div class="info-row">
                <span class="info-label">Amount Received:</span>
                <span class="info-value text-teal-600" id="amountReceived">Rp 0</span>
            </div>

            <!-- 2) Receiver -->
            <div class="info-row">
                <span class="info-label">Receiver:</span>
                <span class="info-value" id="receiverName">{{ Auth::user()->name }}</span>
            </div>

            <!-- 3) Code Payment -->
            <div class="info-row">
                <span class="info-label">Code Payment:</span>
                <span class="info-value" id="paymentMethod">-</span>
            </div>

            <div class="info-row">
                <span class="info-label">Location:</span>
                <span class="info-value">Surabaya, East Java</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date:</span>
                <span class="info-value" id="transactionDate">--/--/----</span>
            </div>
        </div>

        <!-- Back -->
        <div class="text-center mt-3 mb-4">
            <a href="{{ route('home') }}" class="inline-block bg-yellow-400 text-teal-900 font-bold px-6 py-2 rounded-full text-sm shadow hover:bg-yellow-300 transition">
                Back to Home
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Ambil data dari sessionStorage (sesuai dengan exchange.blade)
    const method = sessionStorage.getItem('withdrawMethod') || '-';
    const points = parseInt(sessionStorage.getItem('withdrawPoints')) || 0;

    // Hitung amount sesuai 1 poin = Rp100
    const amount = points * 100;
    const formattedAmount = 'Rp ' + amount.toLocaleString('id-ID');

    // Set tampilan
    document.getElementById('paymentMethod').textContent = method;
    document.getElementById('amountReceived').textContent = formattedAmount;

    // Format tanggal
    const date = new Date().toLocaleDateString('id-ID', { day:'2-digit', month:'2-digit', year:'numeric' });
    document.getElementById('transactionDate').textContent = date;
});
</script>
@endsection