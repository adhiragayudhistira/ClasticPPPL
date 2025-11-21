@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f0f9f7;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .invoice-container {
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        background: white;
    }

    /* Header */
    .invoice-header {
        background: #7dd3c0;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: white;
    }

    .back-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .invoice-header h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Content */
    .invoice-content {
        padding: 1.5rem;
    }

    /* Waste Photo */
    .waste-photo {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .waste-photo img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    /* Info Section */
    .info-section {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #4a5568;
        font-weight: 500;
    }

    .info-value {
        color: #2d3748;
        font-weight: 600;
        text-align: right;
    }

    .info-value.small {
        font-size: 0.85rem;
        font-weight: 400;
        max-width: 200px;
    }

    .section-divider {
        border-top: 1px solid #e2e8f0;
        margin: 1rem 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
    }

    /* Waste Detail */
    .waste-detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .waste-detail-row:last-child {
        margin-bottom: 0;
    }

    .waste-type {
        color: #4a5568;
    }

    .waste-weight {
        color: #2d3748;
        font-weight: 600;
    }

    /* Points Earned */
    .points-section {
        background: linear-gradient(135deg, #7dd3c0 0%, #5eb3a6 100%);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        color: white;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(125, 211, 192, 0.3);
    }

    .points-section h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .points-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }

    /* Action Buttons */
    .action-buttons {
        display: grid;
        gap: 1rem;
    }

    .action-btn {
        width: 100%;
        padding: 1rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .download-btn {
        background: white;
        color: #7dd3c0;
        border: 2px solid #7dd3c0;
    }

    .download-btn:hover {
        background: #7dd3c0;
        color: white;
    }

    .home-btn {
        background: #7dd3c0;
        color: white;
        border: none;
    }

    .home-btn:hover {
        background: #5eb3a6;
    }

    @media (max-width: 480px) {
        .invoice-container {
            max-width: 100%;
        }
    }
</style>

<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <button class="back-btn" onclick="window.history.back()">
            ←
        </button>
        <h1>Invoice</h1>
    </div>

    <!-- Content -->
    <div class="invoice-content">
        <!-- Waste Photo -->
        <div class="waste-photo">
            <img src="https://images.unsplash.com/photo-1604187351574-c75ca79f5807?w=400" alt="Plastic Waste" id="wastePhoto">
        </div>

        <!-- Transaction Code -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Kode Transaksi</span>
                <span class="info-value" id="transactionCode">AHXG87651</span>
            </div>
        </div>

        <!-- Transaction Information -->
        <div class="info-section">
            <h3 class="section-title">Transaction Information</h3>
            
            <div class="info-row">
                <span class="info-label">Driver</span>
                <span class="info-value">Oleksandr Usyk</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Customer</span>
                <span class="info-value">Thariq Apalah</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Location</span>
                <span class="info-value small">Kos Bu Yuni 4<br>Jl. Jalan No.4, Mulyorejo, Kec. Mulyorejo, Kota Surabaya, Jawa Timur 11210</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Time</span>
                <span class="info-value" id="transactionTime">12 Dec 2024, 13:00-14:00 WIB</span>
            </div>

            <div class="section-divider"></div>

            <h3 class="section-title">Waste Detail</h3>
            
            <div class="waste-detail-row">
                <span class="waste-type">HDPE</span>
                <span class="waste-weight" id="hdpeWeight">0.2kg</span>
            </div>
            
            <div class="waste-detail-row">
                <span class="waste-type">PVC</span>
                <span class="waste-weight" id="pvcWeight">0.1kg</span>
            </div>
        </div>

        <!-- Points Earned -->
        <div class="points-section">
            <h3>Points Earned</h3>
            <p class="points-value">200 PTS</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="action-btn download-btn" onclick="downloadInvoice()">
                Download Invoice
            </button>
            <a href="/" class="action-btn home-btn">
                Back to Home
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load order data from session
        const orderData = JSON.parse(sessionStorage.getItem('orderData'));
        
        if (orderData) {
            // Update photo if available
            if (orderData.photo) {
                document.getElementById('wastePhoto').src = orderData.photo;
            }

            // Update transaction time
            const today = new Date();
            const dateStr = today.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            document.getElementById('transactionTime').textContent = `${dateStr}, ${orderData.schedule} WIB`;

            // Update waste details
            if (orderData.plasticType === 'HDPE') {
                document.getElementById('hdpeWeight').textContent = orderData.weight.toFixed(1) + 'kg';
            } else if (orderData.plasticType === 'PVC') {
                document.getElementById('pvcWeight').textContent = orderData.weight.toFixed(1) + 'kg';
            }
        }

        // Generate random transaction code
        const transactionCode = 'AHXG' + Math.floor(Math.random() * 90000 + 10000);
        document.getElementById('transactionCode').textContent = transactionCode;
    });

    function downloadInvoice() {
        // In a real app, this would generate a PDF
        alert('Invoice download feature - In production, this would download a PDF receipt');
    }
</script>
@endsection