@extends('layouts.app')

@section('title', 'HomeEase | Provider Support')

@section('content')
<style>
:root {
  --primary: #0F766E;
  --primary-light: #CCFBF1;
  --highlight: #F59E0B;
  --dark: #0F172A;
  --gray: #64748B;
  --white: #FFFFFF;
  --bg: #F8FAFC;
  --border: #DCE7E6;
  --success: #16A34A;
}

body {
  background:
    radial-gradient(circle at top right, rgba(15, 118, 110, 0.14), transparent 26%),
    linear-gradient(180deg, #F6FFFD 0%, var(--bg) 100%);
}

.provider-shell {
  max-width: 1180px;
  margin: 0 auto;
  padding: clamp(1.25rem, 4vw, 2rem);
}

.hero-grid {
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  gap: clamp(1.2rem, 4vw, 2rem);
  align-items: stretch;
}

.support-panel,
.signal-panel,
.main-card,
.side-card {
  background: rgba(255, 255, 255, 0.94);
  border: 1px solid rgba(220, 231, 230, 0.95);
  border-radius: 32px;
  box-shadow: 0 28px 70px rgba(15, 23, 42, 0.06);
}

.support-panel {
  padding: clamp(1.5rem, 5vw, 2.5rem);
}

.mini-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  border-radius: 999px;
  padding: 0.7rem 1rem;
  background: var(--primary-light);
  color: var(--primary);
  font-size: 0.82rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 1rem;
}

.support-panel h1 {
  font-size: clamp(2rem, 5vw, 3.3rem);
  line-height: 1.02;
  letter-spacing: -0.04em;
  margin-bottom: 1rem;
}

.support-panel p {
  color: var(--gray);
  line-height: 1.7;
  font-size: clamp(1rem, 2.2vw, 1.08rem);
  max-width: 60ch;
}

.provider-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.8rem;
  margin-top: 1.5rem;
}

.provider-tag {
  padding: 0.8rem 1rem;
  border-radius: 18px;
  background: linear-gradient(180deg, #FFFFFF 0%, #F0FDFA 100%);
  border: 1px solid var(--border);
  font-weight: 700;
  color: var(--dark);
}

.signal-panel {
  background: linear-gradient(160deg, #115E59 0%, #0F766E 52%, #134E4A 100%);
  color: var(--white);
  padding: clamp(1.5rem, 5vw, 2.25rem);
  position: relative;
  overflow: hidden;
}

.signal-panel::after {
  content: "";
  position: absolute;
  width: 260px;
  height: 260px;
  border-radius: 50%;
  right: -70px;
  bottom: -120px;
  background: rgba(255, 255, 255, 0.12);
}

.signal-panel h2 {
  font-size: clamp(1.3rem, 3vw, 1.9rem);
  margin-bottom: 0.8rem;
}

.signal-panel p {
  opacity: 0.88;
  line-height: 1.6;
}

.signal-list {
  display: grid;
  gap: 0.9rem;
  margin-top: 1.5rem;
}

.signal-item {
  padding: 1rem 1.05rem;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(10px);
}

.signal-item strong {
  display: block;
  margin-bottom: 0.25rem;
}

.provider-grid {
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  gap: clamp(1.25rem, 4vw, 2rem);
  margin-top: 1.6rem;
}

.main-card,
.side-card {
  padding: clamp(1.4rem, 4vw, 2rem);
}

.section-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.section-top h3 {
  font-size: clamp(1.3rem, 3vw, 1.7rem);
  margin-bottom: 0.35rem;
}

.section-top p {
  color: var(--gray);
  line-height: 1.6;
}

.status-pill {
  padding: 0.55rem 0.9rem;
  border-radius: 999px;
  background: #ECFDF5;
  color: var(--success);
  font-size: 0.78rem;
  font-weight: 800;
  white-space: nowrap;
}

.provider-form {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.provider-field {
  display: flex;
  flex-direction: column;
  gap: 0.55rem;
}

.provider-field.full {
  grid-column: 1 / -1;
}

.provider-field label {
  font-size: 0.8rem;
  font-weight: 800;
  color: var(--gray);
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.provider-field input,
.provider-field select,
.provider-field textarea {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 18px;
  padding: 0.95rem 1rem;
  font: inherit;
  background: #FFFFFF;
  color: var(--dark);
  transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.provider-field textarea {
  min-height: 180px;
  resize: vertical;
}

.provider-field input:focus,
.provider-field select:focus,
.provider-field textarea:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
  transform: translateY(-1px);
}

.provider-submit {
  margin-top: 1.25rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
}

.provider-submit p {
  color: var(--gray);
  margin: 0;
  line-height: 1.6;
}

.provider-btn {
  border: none;
  border-radius: 18px;
  padding: 1rem 1.45rem;
  background: linear-gradient(135deg, var(--primary), #14B8A6);
  color: var(--white);
  font-weight: 800;
  cursor: pointer;
  box-shadow: 0 18px 36px rgba(15, 118, 110, 0.22);
}

.support-stack {
  display: grid;
  gap: 1rem;
}

.stack-card {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem 1.1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F0FDFA 100%);
}

.stack-card strong {
  display: block;
  font-size: 1rem;
  margin-bottom: 0.35rem;
}

.stack-card p {
  color: var(--gray);
  line-height: 1.6;
  margin: 0;
}

.meta-chip {
  display: inline-flex;
  margin-top: 0.8rem;
  padding: 0.45rem 0.8rem;
  border-radius: 999px;
  background: #FEF3C7;
  color: #B45309;
  font-size: 0.78rem;
  font-weight: 800;
}

.route-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--primary);
  text-decoration: none;
  font-weight: 800;
  margin-top: 1rem;
}

@media (max-width: 980px) {
  .hero-grid,
  .provider-grid,
  .provider-form {
    grid-template-columns: 1fr;
  }

  .provider-submit,
  .section-top {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>

<div class="provider-shell">
  <section class="hero-grid">
    <div class="support-panel">
      <div class="mini-badge">Provider Desk</div>
      <h1>Support built for the people doing the work.</h1>
      <p>
        If you are a HomeEase service provider, this is your dedicated line for
        onboarding, verification, payouts, account reviews, missed job requests,
        and issues in the field. We route provider tickets directly to the ops team.
      </p>

      <div class="provider-tags">
        <div class="provider-tag">Verification and KYC</div>
        <div class="provider-tag">Payout and earnings help</div>
        <div class="provider-tag">Job request issues</div>
        <div class="provider-tag">Account access and safety</div>
      </div>
    </div>

    <aside class="signal-panel">
      <h2>Priority channels for active providers</h2>
      <p>Use the fastest lane depending on whether your issue affects live work or future payouts.</p>

      <div class="signal-list">
        <div class="signal-item">
          <strong>Provider hotline</strong>
          <span>+91 1800 555 2200 for urgent shift and customer issues</span>
        </div>
        <div class="signal-item">
          <strong>Payout desk</strong>
          <span>payouts@homeease.app for earnings, statements, and bank changes</span>
        </div>
        <div class="signal-item">
          <strong>Verification desk</strong>
          <span>verify@homeease.app for ID review and onboarding approvals</span>
        </div>
      </div>
    </aside>
  </section>

  <section class="provider-grid">
    <div class="main-card">
      <div class="section-top">
        <div>
          <h3>Submit a provider support request</h3>
          <p>Tell us what role you do, what part of the workflow is blocked, and what outcome you need.</p>
        </div>
        <span class="status-pill">Provider Priority Queue</span>
      </div>

      <form onsubmit="submitProviderContact(event)">
        <div class="provider-form">
          <div class="provider-field">
            <label for="provider-name">Full Name</label>
            <input id="provider-name" type="text" placeholder="Riya Sharma" required>
          </div>

          <div class="provider-field">
            <label for="provider-id">Provider ID</label>
            <input id="provider-id" type="text" placeholder="HE-PRO-24819" required>
          </div>

          <div class="provider-field">
            <label for="provider-email">Email Address</label>
            <input id="provider-email" type="email" placeholder="riya@example.com" required>
          </div>

          <div class="provider-field">
            <label for="provider-phone">Phone Number</label>
            <input id="provider-phone" type="tel" placeholder="+91 98765 43210" required>
          </div>

          <div class="provider-field">
            <label for="provider-service">Primary Service</label>
            <select id="provider-service" required>
              <option value="">Choose your category</option>
                    <option>Electrician</option>
                    <option>Plumber</option>
                    <option>AC / Cooler Repair</option>
                    <option>Driver</option>
              <option>Caregiving</option>
            </select>
          </div>

          <div class="provider-field">
            <label for="provider-topic">Support Topic</label>
            <select id="provider-topic" required>
              <option value="">Choose the issue</option>
              <option>Verification pending</option>
              <option>Payout issue</option>
              <option>Job request problem</option>
              <option>Customer dispute</option>
              <option>Account restriction</option>
            </select>
          </div>

          <div class="provider-field full">
            <label for="provider-message">Describe the issue</label>
            <textarea id="provider-message" placeholder="Include dates, booking references, payout periods, or anything the support team should check." required></textarea>
          </div>
        </div>

        <div class="provider-submit">
          <p>For incidents during an active booking, call the hotline so the operations team can intervene faster.</p>
          <button class="provider-btn" type="submit" id="provider-submit-button">Send to Provider Support</button>
        </div>
      </form>
    </div>

    <aside class="side-card">
      <div class="section-top">
        <div>
          <h3>Common provider support lanes</h3>
          <p>These are the most frequent reasons providers contact us.</p>
        </div>
      </div>

      <div class="support-stack">
        <div class="stack-card">
          <strong>Verification and profile review</strong>
          <p>Need help with ID checks, document rejection, profile approval, or service activation?</p>
          <div class="meta-chip">Average review: same day</div>
        </div>

        <div class="stack-card">
          <strong>Payout and bank issues</strong>
          <p>Missing earnings, failed bank transfer, incorrect statement, or payout hold questions.</p>
          <div class="meta-chip">Handled by finance ops</div>
        </div>

        <div class="stack-card">
          <strong>On-job support</strong>
          <p>Client mismatch, unsafe environment, address issues, or booking details not matching reality.</p>
          <div class="meta-chip">Escalates to live operations</div>
        </div>

        <div class="stack-card">
          <strong>Account quality and performance</strong>
          <p>Appeals for temporary restrictions, feedback reviews, or guidance to improve acceptance rate.</p>
          <div class="meta-chip">Policy team support</div>
        </div>
      </div>

      <a class="route-link" href="{{ route('contact.user') }}">Go to customer contact page</a>
    </aside>
  </section>
</div>

<script>
function submitProviderContact(event) {
  event.preventDefault();

  const button = document.getElementById('provider-submit-button');
  const originalText = button.textContent;

  button.textContent = 'Routing request...';
  button.disabled = true;

  setTimeout(() => {
    alert('Your provider support request has been submitted. The HomeEase operations team will contact you shortly.');
    event.target.reset();
    button.textContent = originalText;
    button.disabled = false;
  }, 1200);
}
</script>
@endsection
