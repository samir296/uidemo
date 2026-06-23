@extends('layouts.app')

@section('title', 'HomeEase | Contact Us')

@section('content')
<style>
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --accent: #0EA5E9;
  --dark: #0F172A;
  --gray: #64748B;
  --white: #FFFFFF;
  --bg: #F8FAFC;
  --border: #E2E8F0;
  --success: #10B981;
}

body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 28%),
    linear-gradient(180deg, #FCFBFF 0%, var(--bg) 100%);
}

.contact-shell {
  max-width: 1180px;
  margin: 0 auto;
  padding: clamp(1.25rem, 4vw, 2rem);
}

.hero-panel {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: clamp(1.2rem, 4vw, 2rem);
  background: rgba(255, 255, 255, 0.92);
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 34px;
  padding: clamp(1.5rem, 5vw, 2.5rem);
  box-shadow: 0 30px 80px rgba(15, 23, 42, 0.07);
}

.hero-copy h1 {
  font-size: clamp(2rem, 5vw, 3.4rem);
  line-height: 1;
  letter-spacing: -0.04em;
  margin-bottom: 1rem;
}

.hero-copy p {
  color: var(--gray);
  font-size: clamp(1rem, 2.2vw, 1.1rem);
  line-height: 1.7;
  max-width: 60ch;
}

.badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.7rem 1rem;
  border-radius: 999px;
  background: var(--primary-light);
  color: var(--primary);
  font-weight: 800;
  font-size: 0.82rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 1rem;
}

.hero-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-top: 1.8rem;
}

.stat-card {
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem;
}

.stat-card strong {
  display: block;
  font-size: 1.4rem;
  margin-bottom: 0.3rem;
}

.stat-card span {
  color: var(--gray);
  font-size: 0.85rem;
  font-weight: 600;
}

.hero-card {
  background: linear-gradient(145deg, var(--primary), #5B21B6);
  color: var(--white);
  border-radius: 30px;
  padding: clamp(1.5rem, 4vw, 2rem);
  position: relative;
  overflow: hidden;
}

.hero-card::before {
  content: "";
  position: absolute;
  inset: auto -20% -35% auto;
  width: 220px;
  height: 220px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.12);
}

.hero-card h2 {
  font-size: clamp(1.3rem, 3vw, 1.8rem);
  margin-bottom: 0.8rem;
}

.hero-card p {
  opacity: 0.88;
  line-height: 1.6;
}

.hero-actions {
  display: grid;
  gap: 0.9rem;
  margin-top: 1.5rem;
}

.hero-action {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding: 1rem 1.1rem;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(10px);
}

.hero-action strong {
  display: block;
  font-size: 0.95rem;
}

.hero-action span {
  font-size: 0.82rem;
  opacity: 0.8;
}

.content-grid {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: clamp(1.25rem, 4vw, 2rem);
  margin-top: 1.6rem;
}

.card {
  background: rgba(255, 255, 255, 0.92);
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 30px;
  padding: clamp(1.4rem, 4vw, 2rem);
  box-shadow: 0 20px 60px rgba(15, 23, 42, 0.05);
}

.section-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.section-head h3 {
  font-size: clamp(1.3rem, 3vw, 1.7rem);
  margin-bottom: 0.35rem;
}

.section-head p {
  color: var(--gray);
  line-height: 1.6;
}

.pill {
  padding: 0.55rem 0.9rem;
  border-radius: 999px;
  background: #ECFDF5;
  color: #047857;
  font-size: 0.78rem;
  font-weight: 800;
  white-space: nowrap;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 0.55rem;
}

.field.full {
  grid-column: 1 / -1;
}

.field label {
  font-size: 0.8rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--gray);
}

.field input,
.field select,
.field textarea {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 18px;
  padding: 0.95rem 1rem;
  font: inherit;
  color: var(--dark);
  background: #FFFFFF;
  transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.field textarea {
  min-height: 160px;
  resize: vertical;
}

.field input:focus,
.field select:focus,
.field textarea:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.12);
  transform: translateY(-1px);
}

.submit-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  margin-top: 1.25rem;
}

.submit-row p {
  color: var(--gray);
  font-size: 0.9rem;
  line-height: 1.6;
  margin: 0;
}

.primary-btn {
  border: none;
  border-radius: 18px;
  padding: 1rem 1.4rem;
  background: linear-gradient(135deg, var(--primary), #8B5CF6);
  color: var(--white);
  font-weight: 800;
  cursor: pointer;
  box-shadow: 0 18px 38px rgba(124, 58, 237, 0.24);
}

.primary-btn:hover {
  transform: translateY(-2px);
}

.contact-list,
.faq-list {
  display: grid;
  gap: 1rem;
}

.contact-item,
.faq-item {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem 1.1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.contact-item strong,
.faq-item strong {
  display: block;
  font-size: 1rem;
  margin-bottom: 0.35rem;
}

.contact-item p,
.faq-item p {
  color: var(--gray);
  line-height: 1.6;
  margin: 0;
}

.contact-meta {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 0.8rem;
  padding: 0.45rem 0.8rem;
  border-radius: 999px;
  background: #EFF6FF;
  color: #2563EB;
  font-size: 0.78rem;
  font-weight: 700;
}

.route-switch {
  margin-top: 1rem;
  display: inline-flex;
  align-items: center;
  gap: 0.55rem;
  color: var(--primary);
  text-decoration: none;
  font-weight: 800;
}

@media (max-width: 980px) {
  .hero-panel,
  .content-grid,
  .form-grid,
  .hero-stats {
    grid-template-columns: 1fr;
  }

  .submit-row,
  .section-head {
    flex-direction: column;
    align-items: flex-start;
  }
}

@media (max-width: 640px) {
  .contact-shell {
    padding: 0.9rem;
  }

  .hero-panel,
  .card {
    border-radius: 24px;
    padding: 1.1rem;
  }

  .hero-copy h1 {
    line-height: 1.08;
    margin-bottom: 0.8rem;
  }

  .hero-copy p,
  .section-head p,
  .submit-row p,
  .contact-item p,
  .faq-item p {
    font-size: 0.92rem;
    line-height: 1.55;
  }

  .hero-card {
    border-radius: 24px;
    padding: 1.2rem;
  }

  .hero-action {
    flex-direction: column;
    align-items: flex-start;
    padding: 0.95rem 1rem;
  }

  .badge,
  .pill,
  .contact-meta {
    white-space: normal;
  }

  .field label {
    font-size: 0.75rem;
  }

  .field input,
  .field select,
  .field textarea {
    border-radius: 16px;
    padding: 0.9rem 0.95rem;
    font-size: 0.95rem;
  }

  .field textarea {
    min-height: 140px;
  }

  .submit-row {
    gap: 0.9rem;
    width: 100%;
  }

  .submit-row .primary-btn {
    width: 100%;
  }

  .contact-item,
  .faq-item,
  .stat-card {
    border-radius: 18px;
    padding: 0.95rem 1rem;
  }
}

@media (max-width: 420px) {
  .contact-shell {
    padding: 0.7rem;
  }

  .hero-panel,
  .card {
    border-radius: 20px;
    padding: 1rem;
  }

  .hero-card {
    border-radius: 20px;
    padding: 1rem;
  }

  .hero-copy h1 {
    font-size: 1.8rem;
  }

  .section-head h3,
  .hero-card h2 {
    font-size: 1.15rem;
  }

  .badge,
  .pill {
    font-size: 0.72rem;
    padding: 0.6rem 0.8rem;
  }

  .field input,
  .field select,
  .field textarea {
    padding: 0.85rem 0.9rem;
  }

  .primary-btn {
    border-radius: 16px;
    padding: 0.95rem 1.1rem;
  }
}
</style>

<div class="contact-shell">
  <section class="hero-panel">
    <div class="hero-copy">
      <div class="badge">Customer Care</div>
      <h1>Need help with a booking, payment, or account?</h1>
      <p>
        Reach the HomeEase support team for anything from finding the right expert
        to resolving cancellations, refunds, safety concerns, or account issues.
        This page is designed for everyday customers using the platform.
      </p>

      <div class="hero-stats">
        <div class="stat-card">
          <strong>24/7</strong>
          <span>Safety support for urgent issues</span>
        </div>
        <div class="stat-card">
          <strong>10 min</strong>
          <span>Average first reply on live chat</span>
        </div>
        <div class="stat-card">
          <strong>3 ways</strong>
          <span>Chat, call, or email support</span>
        </div>
      </div>
    </div>

    <aside class="hero-card">
      <h2>Quick help channels</h2>
      <p>Choose the fastest option based on what you need today.</p>

      <div class="hero-actions">
        <div class="hero-action">
          <div>
            <strong>Live chat</strong>
            <span>Best for active bookings and status updates</span>
          </div>
          <strong>Now</strong>
        </div>
        <div class="hero-action">
          <div>
            <strong>Call support</strong>
            <span>For urgent reschedules, payments, and safety</span>
          </div>
          <strong>+91 1800 123 9090</strong>
        </div>
        <div class="hero-action">
          <div>
            <strong>Email support</strong>
            <span>For detailed issues and follow-up documents</span>
          </div>
          <strong>help@homeease.app</strong>
        </div>
      </div>
    </aside>
  </section>

  <section class="content-grid">
    <div class="card">
      <div class="section-head">
        <div>
          <h3>Send us a message</h3>
          <p>Share a few details and our customer support team will follow up with the right next step.</p>
        </div>
        <span class="pill">Customers Only</span>
      </div>

      <form onsubmit="submitCustomerContact(event)">
        <div class="form-grid">
          <div class="field">
            <label for="customer-name">Full Name</label>
            <input id="customer-name" type="text" placeholder="Alex Johnson" required>
          </div>

          <div class="field">
            <label for="customer-phone">Phone Number</label>
            <input id="customer-phone" type="tel" placeholder="+91 98765 43210" required>
          </div>

          <div class="field">
            <label for="customer-email">Email Address</label>
            <input id="customer-email" type="email" placeholder="alex@example.com" required>
          </div>

          <div class="field">
            <label for="customer-topic">Issue Type</label>
            <select id="customer-topic" required>
              <option value="">Choose a topic</option>
              <option>Booking support</option>
              <option>Payment or refund</option>
              <option>Account issue</option>
              <option>Report a provider</option>
              <option>Safety concern</option>
            </select>
          </div>

          <div class="field full">
            <label for="booking-id">Booking ID or Order Reference</label>
            <input id="booking-id" type="text" placeholder="Optional reference to help us find your request faster">
          </div>

          <div class="field full">
            <label for="customer-message">How can we help?</label>
            <textarea id="customer-message" placeholder="Tell us what happened, what you expected, and what outcome would help most." required></textarea>
          </div>
        </div>

        <div class="submit-row">
          <p>For safety emergencies, please use the emergency support line instead of waiting for email.</p>
          <button class="primary-btn" type="submit" id="customer-submit">Submit Request</button>
        </div>
      </form>
    </div>

    <div class="card">
      <div class="section-head">
        <div>
          <h3>Other ways to reach us</h3>
          <p>Pick the support lane that matches the situation.</p>
        </div>
      </div>

      <div class="contact-list">
        <div class="contact-item">
          <strong>Booking changes</strong>
          <p>Need to reschedule, cancel, or confirm timing with a provider? Our booking team can help.</p>
          <div class="contact-meta">support-bookings@homeease.app</div>
        </div>

        <div class="contact-item">
          <strong>Payments and refunds</strong>
          <p>Questions about charges, failed payments, credits, or reimbursement status.</p>
          <div class="contact-meta">billing@homeease.app</div>
        </div>

        <div class="contact-item">
          <strong>Safety desk</strong>
          <p>Report harassment, unsafe behavior, identity mismatch, or any urgent trust concern.</p>
          <div class="contact-meta">24/7 Priority Line</div>
        </div>
      </div>

      <div class="section-head" style="margin-top: 1.8rem;">
        <div>
          <h3>Popular questions</h3>
        </div>
      </div>

      <div class="faq-list">
        <div class="faq-item">
          <strong>How soon will I hear back?</strong>
          <p>General requests are usually answered within a few business hours, while urgent support is prioritized immediately.</p>
        </div>

        <div class="faq-item">
          <strong>Can I attach screenshots or invoices?</strong>
          <p>Yes. After your first message, our team can request screenshots, payment proofs, or photos to speed up resolution.</p>
        </div>

        <div class="faq-item">
          <strong>Are you a service provider instead?</strong>
          <p>Providers have a dedicated support channel for payouts, verification, and job flow questions.</p>
        </div>
      </div>

      <a class="route-switch" href="{{ route('contact.provider') }}">Go to provider support</a>
    </div>
  </section>
</div>

<script>
function submitCustomerContact(event) {
  event.preventDefault();

  const button = document.getElementById('customer-submit');
  const originalText = button.textContent;

  button.textContent = 'Sending...';
  button.disabled = true;

  setTimeout(() => {
    alert('Your support request has been sent. A HomeEase customer care agent will contact you shortly.');
    event.target.reset();
    button.textContent = originalText;
    button.disabled = false;
  }, 1200);
}
</script>
@endsection
