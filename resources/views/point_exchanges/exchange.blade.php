@extends('layouts.app')

@section('content')

<style>
/* Sembunyiin bottom nav di layout */
    .fixed, [class*="bottom"], [class*="nav"] { display: none !important; }
</style>

<div class="wrapper exchange-page">

    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white px-6 py-6">
        <div class="flex items-center mb-2">
            <a href="{{ route('profile') }}" class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Exchange Points</h1>
        </div>
        <p class="text-teal-100 text-sm">Convert your collected points into balance easily</p>
    </div>

    <div class="px-6 py-8">

        <!-- Points Balance -->
        <div class="bg-gradient-to-b from-teal-400 to-teal-500 rounded-3xl p-6 text-white shadow-lg mb-8">
            <p class="text-sm opacity-90 mb-2">Your Points Balance</p>
            <h2 class="text-4xl font-bold mb-1">2,500</h2>
            <p class="text-xs opacity-75">Points available</p>
        </div>

        <!-- Exchange Card -->
        <div class="main-card bg-white border border-gray-100">
            <div class="p-6">

                <h3 class="text-lg font-bold text-gray-800 mb-6">Exchange Points</h3>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Points to Exchange</label>
                    <input type="number" id="pointsInput" placeholder="Enter amount" min="100"
                           class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:outline-none text-gray-800 font-medium text-lg">
                    <p class="text-xs text-gray-500 mt-2">Minimum exchange: 100 points</p>
                </div>

                <div class="bg-teal-50 rounded-xl p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">You will receive:</span>
                        <span class="text-lg font-bold text-teal-600" id="rupiahAmount">Rp 0</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">1 Point = Rp 100</p>
                </div>

                <h3 class="text-base font-bold text-gray-800 mb-4">Withdraw</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button type="button" class="method-btn border-2 border-teal-400 text-teal-600 rounded-xl py-3 font-bold">Dana</button>
                    <button type="button" class="method-btn border-2 border-teal-400 text-teal-600 rounded-xl py-3 font-bold">Gopay</button>
                    <button type="button" class="method-btn border-2 border-teal-400 text-teal-600 rounded-xl py-3 font-bold">OVO</button>
                    <button type="button" class="method-btn border-2 border-teal-400 text-teal-600 rounded-xl py-3 font-bold">Bank</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="authModal" class="modal-bg">
    <div class="modal-box">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Authentication</h2>
        <input type="text" id="bankNumber" placeholder="Enter your bank card number">
        <p class="text-sm text-gray-600 mb-3">Amount of fund in exchange of <span id="pointsDisplay">0</span> points</p>
        <p class="text-lg font-bold text-teal-600 mb-4" id="amountDisplay">Rp 0</p>
        <button id="proceedBtn">Proceed</button>
    </div>
</div>

<script>
    const input = document.getElementById('pointsInput');
    const rupiah = document.getElementById('rupiahAmount');
    const methods = document.querySelectorAll('.method-btn');
    const modal = document.getElementById('authModal');
    const pointsDisplay = document.getElementById('pointsDisplay');
    const amountDisplay = document.getElementById('amountDisplay');
    const bankNumber = document.getElementById('bankNumber');
    const proceedBtn = document.getElementById('proceedBtn');

    let selectedMethod = null;

    // Update nominal
    input.addEventListener('input', function() {
        const points = parseInt(this.value) || 0;
        rupiah.textContent = points >= 100
            ? 'Rp ' + (points * 100).toLocaleString('id-ID')
            : 'Rp 0';
    });

// Pilih metode
methods.forEach(btn => {
    btn.addEventListener('click', function() {
        methods.forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        selectedMethod = this.textContent.trim();

        const points = parseInt(input.value) || 0;
        if (!points || points < 100) {
            alert("Please enter at least 100 points before selecting withdraw method.");
            return;
        }

        // Tampilkan modal
        pointsDisplay.textContent = points.toLocaleString('id-ID');
        amountDisplay.textContent = 'Rp ' + (points * 100).toLocaleString('id-ID');
        modal.style.display = 'flex'; // ini udah bener
    });
});

    // Klik Proceed
    proceedBtn.addEventListener('click', function() {
        const cardNum = bankNumber.value.trim();
        if (cardNum === '' || cardNum.length < 8) {
            alert('Please enter a valid card number.');
            return;
        }

        // Simpan data (simulasi)
        sessionStorage.setItem('withdrawMethod', selectedMethod);
        sessionStorage.setItem('withdrawPoints', input.value);
        sessionStorage.setItem('bankNumber', cardNum);

        // Tutup modal dan redirect
        modal.style.display = 'none';
        window.location.href = '/points/success';
    });
    
    // Klik luar modal = close
    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.style.display = 'none';
    });
</script>
@endsection