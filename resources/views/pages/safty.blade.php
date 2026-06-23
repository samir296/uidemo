@extends('layouts.app')

@section('title', 'HomeEase | Safety Center')

@section('content')
<style>
:root {
  --primary: #7C3AED;
  --danger: #DC2626;
  --danger-soft: #FEF2F2;
  --dark: #0F172A;
  --muted: #64748B;
  --border: #E2E8F0;
}

body {
  background:
    radial-gradient(circle at top left, rgba(220, 38, 38, 0.10), transparent 24%),
    linear-gradient(180deg, #FFFDFD 0%, #F8FAFC 100%);
}

.safety-shell {
  max-width: 1080px;
  margin: 0 auto;
  padding: 1rem;
}

.hero,
.panel {
  background: rgba(255,255,255,0.95);
  border: 1px solid rgba(226,232,240,0.96);
  border-radius: 30px;
  box-shadow: 0 24px 60px rgba(15,23,42,0.06);
}

.hero {
  padding: clamp(1.2rem, 4vw, 1.8rem);
}

.eyebrow {
  display: inline-flex;
  padding: 0.65rem 0.95rem;
  border-radius: 999px;
  background: var(--danger-soft);
  color: var(--danger);
  font-weight: 800;
  font-size: 0.78rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 0.8rem;
}

.hero h1,
.panel h2 {
  margin: 0 0 0.7rem;
  color: var(--dark);
}

.hero p,
.lane-card p,
.tip-card p {
  color: var(--muted);
  line-height: 1.65;
}

.action-grid,
.tip-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-top: 1rem;
}

.lane-card,
.tip-card {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.lane-card strong,
.tip-card strong {
  display: block;
  margin-bottom: 0.35rem;
  color: var(--dark);
}

.cta {
  display: inline-flex;
  margin-top: 0.8rem;
  text-decoration: none;
  color: var(--danger);
  font-weight: 800;
}

.panel {
  margin-top: 1rem;
  padding: clamp(1rem, 4vw, 1.4rem);
}

@media (max-width: 900px) {
  .action-grid,
  .tip-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .safety-shell {
    padding: 0.85rem;
  }

  .hero,
  .panel {
    border-radius: 24px;
    padding: 1rem;
  }
}
</style>

<div class="safety-shell">
  <section class="hero">
    <div class="eyebrow">Safety Center</div>
    <h1>Use this page first for urgent or trust-related issues.</h1>
    <p>If a provider, customer, or situation feels unsafe, move to the correct lane quickly. This page is designed to feel clear and calm on mobile so people can act fast.</p>

    <div class="action-grid">
      <div class="lane-card">
        <strong>Immediate danger</strong>
        <p>Contact local emergency services first if someone is at risk right now.</p>
      </div>
      <div class="lane-card">
        <strong>Trust complaint</strong>
        <p>Report inappropriate behaviour, harassment, identity concerns, or repeated violations.</p>
        <a class="cta" href="{{ route('contact.user') }}">Report through support</a>
      </div>
      <div class="lane-card">
        <strong>Account safety</strong>
        <p>Use settings and support to secure your profile, phone number, and communication preferences.</p>
        <a class="cta" href="{{ url('/settings') }}">Open settings</a>
      </div>
    </div>
  </section>

  <section class="panel">
    <h2>Safety tips for customers and providers</h2>
    <div class="tip-grid">
      <div class="tip-card">
        <strong>Verify details before arrival</strong>
        <p>Double-check service type, date, address, and contact details before the visit starts.</p>
      </div>
      <div class="tip-card">
        <strong>Keep in-app records</strong>
        <p>Use HomeEase communication and support channels so important updates stay documented.</p>
      </div>
      <div class="tip-card">
        <strong>Report patterns early</strong>
        <p>If something feels wrong more than once, report it early instead of waiting for a bigger issue.</p>
      </div>
    </div>
  </section>
</div>
@endsection
