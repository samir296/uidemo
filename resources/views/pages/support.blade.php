@extends('layouts.app')

@section('title', 'HomeEase | Support Center')

@section('content')
<style>
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --dark: #0F172A;
  --muted: #64748B;
  --border: #E2E8F0;
  --surface: rgba(255,255,255,0.94);
  --bg: #F8FAFC;
}

body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 28%),
    linear-gradient(180deg, #FCFBFF 0%, var(--bg) 100%);
}

.app-shell {
  max-width: 1120px;
  margin: 0 auto;
  padding: 1.1rem;
}

.hero-card,
.section-card {
  background: var(--surface);
  border: 1px solid rgba(226, 232, 240, 0.96);
  border-radius: 30px;
  box-shadow: 0 24px 60px rgba(15, 23, 42, 0.06);
}

.hero-card {
  padding: clamp(1.3rem, 4vw, 2rem);
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 1.2rem;
}

.eyebrow {
  display: inline-flex;
  padding: 0.65rem 0.95rem;
  border-radius: 999px;
  background: var(--primary-light);
  color: var(--primary);
  font-size: 0.78rem;
  font-weight: 800;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 0.9rem;
}

.hero-card h1 {
  margin: 0 0 0.8rem;
  color: var(--dark);
  font-size: clamp(2rem, 5vw, 3rem);
  line-height: 1.02;
}

.hero-card p,
.section-copy,
.stack-card p,
.faq-item p {
  color: var(--muted);
  line-height: 1.65;
}

.hero-actions,
.quick-grid,
.faq-list,
.lane-list {
  display: grid;
  gap: 1rem;
}

.stack-card {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.stack-card strong {
  display: block;
  margin-bottom: 0.25rem;
  color: var(--dark);
}

.pill-link {
  display: inline-flex;
  margin-top: 0.8rem;
  text-decoration: none;
  color: var(--primary);
  font-weight: 800;
}

.section-card {
  margin-top: 1rem;
  padding: clamp(1.1rem, 4vw, 1.6rem);
}

.section-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1rem;
}

.section-head h2 {
  margin: 0 0 0.35rem;
  color: var(--dark);
  font-size: clamp(1.25rem, 3vw, 1.7rem);
}

.badge {
  padding: 0.55rem 0.8rem;
  border-radius: 999px;
  background: #ECFDF5;
  color: #047857;
  font-size: 0.76rem;
  font-weight: 800;
}

.quick-grid {
  grid-template-columns: repeat(3, 1fr);
}

.faq-item strong {
  display: block;
  color: var(--dark);
  margin-bottom: 0.35rem;
}

@media (max-width: 900px) {
  .hero-card,
  .quick-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .app-shell {
    padding: 0.85rem;
  }

  .hero-card,
  .section-card {
    border-radius: 24px;
  }

  .hero-card,
  .section-card {
    padding: 1rem;
  }

  .section-head {
    flex-direction: column;
  }
}
</style>

<div class="app-shell">
  <section class="hero-card">
    <div>
      <div class="eyebrow">Support Center</div>
      <h1>Help that feels fast on mobile.</h1>
      <p>Use the right support lane for bookings, payments, profile questions, cancellations, and general app guidance without getting lost in long forms.</p>
    </div>

    <div class="hero-actions">
      <div class="stack-card">
        <strong>Customer support</strong>
        <p>Booking help, delays, refunds, and account issues for people using HomeEase services.</p>
        <a class="pill-link" href="{{ route('contact.user') }}">Open customer help</a>
      </div>
      <div class="stack-card">
        <strong>Provider support</strong>
        <p>Profile updates, payout questions, service listing issues, and work-related help for providers.</p>
        <a class="pill-link" href="{{ route('contact.provider') }}">Open provider help</a>
      </div>
    </div>
  </section>

  <section class="section-card">
    <div class="section-head">
      <div>
        <h2>Quick help lanes</h2>
        <p class="section-copy">Choose the shortest path based on what happened.</p>
      </div>
      <span class="badge">Mobile-first</span>
    </div>

    <div class="quick-grid">
      <div class="stack-card">
        <strong>Booking support</strong>
        <p>Reschedule visits, check provider arrival, or update request details.</p>
      </div>
      <div class="stack-card">
        <strong>Payment and refund</strong>
        <p>Track charges, failed payments, wallet credits, and refund status.</p>
      </div>
      <div class="stack-card">
        <strong>Profile and settings</strong>
        <p>Manage phone number, address, saved preferences, and notification setup.</p>
      </div>
    </div>
  </section>

  <section class="section-card">
    <div class="section-head">
      <div>
        <h2>Popular questions</h2>
        <p class="section-copy">The most common support topics people check first.</p>
      </div>
    </div>

    <div class="faq-list">
      <div class="stack-card faq-item">
        <strong>How quickly will HomeEase reply?</strong>
        <p>For normal support, the page is designed around fast first responses. Safety issues should go through the safety page immediately.</p>
      </div>
      <div class="stack-card faq-item">
        <strong>Where do I report a bad service experience?</strong>
        <p>Use customer support for service quality, refund, and complaint handling. Include the booking reference when possible.</p>
      </div>
      <div class="stack-card faq-item">
        <strong>Where do I go for emergency help?</strong>
        <p>Open the Safety Center for urgent issues, SOS guidance, and trust-and-safety reporting paths.</p>
        <a class="pill-link" href="{{ url('/safty') }}">Open safety center</a>
      </div>
    </div>
  </section>
</div>
@endsection
