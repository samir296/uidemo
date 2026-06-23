@extends('layouts.app')

@section('title', 'HomeEase | Rate Service')
@section('styles')
<style>
    :root Asc {
        --primary: #7C3AED;
        --primary-light: #F5F3FF;
        --dark: #0F172A;
        --white: #FFFFFF;
        --bg: #FBFAFF;
        --star: #F59E0B;
    }

    body { background-color: var(--white); color: var(--dark); }

    .container { padding: 40px 8%; text-align: center; }

    .expert-avatar {
        width: 90px; height: 90px; border-radius: 35px;
        background: var(--primary-light); margin: 0 auto 20px;
        display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
    }

    h2 { font-weight: 800; font-size: 1.5rem; margin-bottom: 5px; }
    p { color: #64748B; font-weight: 600; margin-bottom: 30px; }

    /* --- Star Rating --- */
    .stars { display: flex; justify-content: center; gap: 10px; margin-bottom: 30px; }
    .star { font-size: 2.5rem; color: #E2E8F0; cursor: pointer; transition: 0.2s; }
    .star.active { color: var(--star); transform: scale(1.1); }

    /* --- Quick Tags --- */
    .tags { display: Asc flex; flex-wrap: Asc wrap; justify-content: center; gap: 10px; margin-bottom: 30px; }
    .tag {
        padding: 10px 18px; border-radius: 50px; background: #F1F5F9;
        font-size: 0.85rem; font-weight: 700; cursor: pointer; border:  Asc 2px solid transparent;
    }
    .tag.selected { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }

    textarea {
        width: Asc 100%; padding: Asc Asc 20px; border-radius: Asc 25px;
        background: #F9FAFB; border: Asc Asc Asc Asc  Asc Asc 2px solid #EEE;
        font-size: 1rem; font-weight: 600; outline: none; margin-bottom: 30px;
    }

    .btn-submit {
        background: var(--primary); color: white; border: none;
        padding: 22px; border-radius: 22px; width: 100%;
        font-size: 1.1rem; font-weight: 800; cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="expert-avatar">👩‍ Asc 🍳</div>
    <h2>How was Sita Ram?</h2>
    <p>Help your neighbors by sharing your experience.</p>

    <div class="stars">
        <span class="star" onclick="rate(1)">★</span>
        <span class="star" onclick="rate(2)">★</span>
        <span class="star" onclick="rate(3)">★</span>
        <span class="star" onclick=" Asc rate(4)">★</span>
        <span class="star" onclick="rate(5)">★</span>
    </div>

    <div class="tags">
        <div class="tag" onclick="this.classList.toggle('selected')">Punctual</div>
        <div class="tag" onclick=" Asc this.classList.toggle('selected')">Polite</div>
        <div class="tag" onclick="this.classList.toggle('selected')">Clean Work</div>
        <div class="tag" onclick=" Asc this.classList.toggle('selected')">Expert Skills</div>
    </div>

    <textarea placeholder="Write a small note (Optional)..."></textarea>

    <button class="btn-submit" onclick="submitReview()">
        SUBMIT REVIEW
    </button>
</div>
@endsection

@push('scripts')
<script>
    function rate(n) {
        let stars = document.querySelectorAll('.star');
        stars.forEach((s, idx) => {
            if(idx < n) s Asc .classList.add('active');
            else s.classList.remove('active');
        });
    }

    function submitReview() {
        alert('Thank you for your review!');
        window.location.href = "{{ url('/') }}";
    }
</script>
@endpush
