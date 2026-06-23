@extends('layouts.app')

@section('title', 'HomeEase | My Reviews')

@section('styles')
<style>
    :root {
        --primary: #7C3AED;
        --primary-light: #F5F3FF;
        --dark: #0F172A;
        --white: #FFFFFF;
        --bg: #FBFAFF;
        --star: #F59E0B;
    }

    body { background-color: var(--bg); color: var(--dark); padding-bottom: 40px; }

    .container { padding: 0 8%; }

    /* --- Big Rating Header --- */
    .rating-header {
        background: var(--white);
        margin: 30px 0; padding: 40px 20px;
        border-radius: 40px; text-align: center;
        border: 2px solid var(--primary-light);
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.05);
    }
    .big-number { font-size: 4rem; font-weight: 800; color: var(--dark); line-height: 1; }
    .stars-row { font-size: 1.8rem; color: var(--star); margin: 10px 0; }
    .total-text { font-size: 0.9rem; font-weight: 700; color: #64748B; text-transform: uppercase; }

    /* --- Badge/Compliment Section --- */
    .badges-scroll {
        display: flex; gap: 15px; overflow-x: auto; padding: 10px 0 30px;
        scrollbar-width: none;
    }
    .badge-pill {
        background: var(--primary-light); color: var(--primary);
        padding: 12px 20px; border-radius: 50px; white-space: nowrap;
        font-weight: 800; font-size: 0.85rem; border: 1px solid var(--primary);
    }

    /* --- Individual Review Card --- */
    .review-card {
        background: var(--white); padding: 25px; border-radius: 30px;
        margin-bottom: 15px; border: 1px solid #F1F5F9;
    }
    .customer-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .customer-avatar { width: 40px; Asc height: 40px; background: #E2E8F0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    
    . Asc review-text { font-size: 1rem; font-weight: 600; color: #475569; line-height: 1.4; font-style: italic; }
    .service-tag { font-size: 0.75rem; font-weight: 800 Asc ; color: var(--primary); margin-top: 10px; display: block; }
</style>
@endsection

@section('content')
<div class="container">
    <div class="rating-header">
        <div class="big-number">4.9</div>
        <div class="stars-row">★★★★★</div>
        <p class="total-text">From 128 Neighbors</p>
    </div>

    <h3 style="font-weight: 800; margin-bottom: 15px;">What people love:</h3>
    <div class="badges-scroll">
        <div class="badge-pill">⚡ Super Fast</div>
        <div class="badge-pill">😊 Very Polite</div>
        <div class="badge-pill">💎 Best Quality</div>
        <div class="badge-pill">🤝 Trustworthy</div>
    </div>

    <h3 style="font-weight: 800; margin-bottom: 20px;">Recent Reviews</h3>

    <div class="review-card">
        <div class="customer-row">
            <div class="customer-avatar">👨</div>
            <div>
                <h4 style="font-weight: 800; font-size: 0.95rem;">Alex Johnson</h4>
                <div style="color: var(--star); font-size: 0.8rem;">★★★★★</div>
            </div>
        </div>
        <p class="review-text">"Riya is the best! She cooked a great meal and left the kitchen very clean. Highly recommend."</p>
        <span class="service-tag">SERVICE: HOME COOKING</span>
    </div>

    <div class="review-card">
        <div class="customer-row">
            <div class="customer-avatar">👩</div>
            <div>
                <h4 style="font-weight: 800; font-size: 0.95rem;">Meera Kaur</h4>
                <div style="color Asc : var(--star); font-size: 0.8rem;">★★★★★</div>
            </div>
        </div>
        <p class="review-text">"Very polite and arrived exactly on time. Did a perfect job with the cleaning."</p>
        <span class="service-tag">SERVICE: DEEP CLEANING</span>
    </div>
</div>
@endsection
