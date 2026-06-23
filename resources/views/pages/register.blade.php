@extends('layouts.app')

@section('title', 'HomeEase | Register')

@section('content')
@php
  $initialRole = request('role') === 'provider' ? 'provider' : 'user';
@endphp
<style>
:root {
  --primary: #7C3AED;
  --primary-dark: #5B21B6;
  --primary-light: #F5F3FF;
  --accent: #0F172A;
  --text: #1E293B;
  --muted: #64748B;
  --border: #E2E8F0;
  --bg: #F8FAFC;
  --white: #FFFFFF;
  --success: #10B981;
}

body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.14), transparent 30%),
    linear-gradient(180deg, #FCFBFF 0%, var(--bg) 100%);
}

.register-shell {
  max-width: 1180px;
  margin: 0 auto;
  padding: clamp(1.25rem, 4vw, 2rem);
}

.register-hero {
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  gap: clamp(1.25rem, 4vw, 2rem);
  align-items: stretch;
}

.intro-card,
.summary-card,
.form-card,
.info-card {
  background: rgba(255, 255, 255, 0.94);
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 32px;
  box-shadow: 0 26px 70px rgba(15, 23, 42, 0.06);
}

.intro-card {
  padding: clamp(1.6rem, 5vw, 2.4rem);
}

.eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.55rem;
  padding: 0.7rem 1rem;
  border-radius: 999px;
  background: var(--primary-light);
  color: var(--primary);
  font-size: 0.82rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 1rem;
}

.intro-card h1 {
  font-size: clamp(2rem, 5vw, 3.3rem);
  line-height: 1.02;
  letter-spacing: -0.04em;
  margin-bottom: 1rem;
  color: var(--accent);
}

.intro-card p {
  color: var(--muted);
  font-size: clamp(1rem, 2.2vw, 1.08rem);
  line-height: 1.75;
  max-width: 58ch;
}

.feature-strip {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-top: 1.6rem;
}

.feature-item {
  padding: 1rem;
  border: 1px solid var(--border);
  border-radius: 22px;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.feature-item strong {
  display: block;
  font-size: 1rem;
  margin-bottom: 0.35rem;
  color: var(--accent);
}

.feature-item span {
  color: var(--muted);
  font-size: 0.88rem;
  line-height: 1.55;
}

.summary-card {
  background: linear-gradient(145deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: var(--white);
  padding: clamp(1.6rem, 5vw, 2.2rem);
  position: relative;
  overflow: hidden;
}

.summary-card::after {
  content: "";
  position: absolute;
  right: -70px;
  bottom: -90px;
  width: 240px;
  height: 240px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.12);
}

.summary-card h2 {
  font-size: clamp(1.3rem, 3vw, 1.8rem);
  margin-bottom: 0.8rem;
}

.summary-card p {
  opacity: 0.9;
  line-height: 1.7;
  margin-bottom: 1.2rem;
}

.summary-points {
  display: grid;
  gap: 0.9rem;
}

.summary-point {
  padding: 1rem 1.1rem;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(10px);
}

.summary-point strong {
  display: block;
  margin-bottom: 0.25rem;
}

.register-grid {
  display: grid;
  grid-template-columns: 1.08fr 0.92fr;
  gap: clamp(1.25rem, 4vw, 2rem);
  margin-top: 1.6rem;
}

.form-card,
.info-card {
  padding: clamp(1.4rem, 4vw, 2rem);
}

.section-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1.4rem;
}

.section-head h3 {
  font-size: clamp(1.3rem, 3vw, 1.7rem);
  color: var(--accent);
  margin-bottom: 0.35rem;
}

.section-head p {
  color: var(--muted);
  line-height: 1.65;
}

.status-chip {
  padding: 0.55rem 0.9rem;
  border-radius: 999px;
  background: #ECFDF5;
  color: #047857;
  font-size: 0.78rem;
  font-weight: 800;
  white-space: nowrap;
}

.role-toggle {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.role-card {
  border: 1.5px solid var(--border);
  border-radius: 24px;
  padding: 1.1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
  cursor: pointer;
  transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
}

.role-card.active {
  border-color: var(--primary);
  background: linear-gradient(180deg, #FFFFFF 0%, #F5F3FF 100%);
  box-shadow: 0 14px 30px rgba(124, 58, 237, 0.12);
}

.role-card:hover {
  transform: translateY(-2px);
}

.role-card strong {
  display: block;
  font-size: 1rem;
  color: var(--accent);
  margin-bottom: 0.25rem;
}

.role-card span {
  color: var(--muted);
  font-size: 0.9rem;
  line-height: 1.55;
}

.register-form {
  display: grid;
  gap: 1rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.field.full {
  grid-column: 1 / -1;
}

.field label {
  font-size: 0.8rem;
  font-weight: 800;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.field input,
.field select,
.field textarea {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 18px;
  padding: 0.95rem 1rem;
  font: inherit;
  color: var(--text);
  background: #FFFFFF;
  transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.field textarea {
  min-height: 120px;
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

.field input.is-invalid,
.field select.is-invalid,
.field textarea.is-invalid,
.address-row .is-invalid,
.photo-panel.is-invalid,
.provider-service-panel.is-invalid {
  border-color: #EF4444 !important;
  box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12) !important;
}

.field-error-message {
  color: #B91C1C;
  font-size: 0.78rem;
  font-weight: 700;
  line-height: 1.45;
}

.field-note {
  color: var(--muted);
  font-size: 0.8rem;
  line-height: 1.5;
}

.address-row {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 0.8rem;
}

.location-btn {
  border: none;
  border-radius: 16px;
  padding: 0.95rem 1rem;
  background: var(--primary-light);
  color: var(--primary);
  font-weight: 800;
  cursor: pointer;
  white-space: nowrap;
}

.location-btn:hover {
  background: #EDE9FE;
}

.submit-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  margin-top: 0.5rem;
}

.submit-row p {
  color: var(--muted);
  font-size: 0.9rem;
  line-height: 1.65;
  margin: 0;
}

.primary-btn {
  border: none;
  border-radius: 18px;
  padding: 1rem 1.45rem;
  background: linear-gradient(135deg, var(--primary), #8B5CF6);
  color: var(--white);
  font-weight: 800;
  cursor: pointer;
  box-shadow: 0 18px 36px rgba(124, 58, 237, 0.22);
}

.primary-btn:hover {
  transform: translateY(-2px);
}

.primary-btn:disabled,
.secondary-btn:disabled,
.debug-token-btn:disabled,
.location-btn:disabled,
.photo-btn:disabled {
  opacity: 0.7;
  cursor: wait;
  transform: none;
}

.register-form.is-submitting {
  opacity: 0.92;
}

.support-stack {
  display: grid;
  gap: 1rem;
}

.support-item {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem 1.1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.support-item strong {
  display: block;
  font-size: 1rem;
  color: var(--accent);
  margin-bottom: 0.3rem;
}

.support-item p {
  color: var(--muted);
  line-height: 1.6;
  margin: 0;
}

.support-link {
  display: inline-flex;
  margin-top: 0.8rem;
  padding: 0.45rem 0.8rem;
  border-radius: 999px;
  background: #EFF6FF;
  color: #2563EB;
  font-size: 0.78rem;
  font-weight: 800;
  text-decoration: none;
}

.hidden {
  display: none;
}

.provider-service-panel {
  grid-column: 1 / -1;
  border: 1px solid var(--border);
  border-radius: 24px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.provider-service-panel h4 {
  margin: 0 0 0.35rem;
  color: var(--accent);
  font-size: 1rem;
}

.provider-service-panel p {
  margin: 0 0 1rem;
  color: var(--muted);
  line-height: 1.6;
  font-size: 0.9rem;
}

.provider-service-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.offering-stack {
  display: grid;
  gap: 1rem;
}

.offering-card {
  border: 1px solid var(--border);
  border-radius: 24px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.offering-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1rem;
}

.offering-head strong {
  display: block;
  color: var(--accent);
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

.offering-head span {
  color: var(--muted);
  font-size: 0.88rem;
  line-height: 1.5;
}

.secondary-btn {
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 0.85rem 1rem;
  background: #FFFFFF;
  color: var(--accent);
  font-weight: 800;
  cursor: pointer;
}

.secondary-btn:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.offering-remove {
  border: 1px solid #FECACA;
  border-radius: 14px;
  padding: 0.7rem 0.9rem;
  background: #FFF1F2;
  color: #BE123C;
  font-weight: 800;
  cursor: pointer;
}

.offering-empty {
  grid-column: 1 / -1;
  border: 1px dashed var(--border);
  border-radius: 22px;
  padding: 1rem;
  background: #FFFFFF;
  color: var(--muted);
  line-height: 1.6;
}

.service-checkbox-list {
  display: grid;
  gap: 0.65rem;
  margin-top: 0.2rem;
}

.service-checkbox-item {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  padding: 0.8rem 0.9rem;
  border: 1px solid var(--border);
  border-radius: 16px;
  background: #FFFFFF;
  color: var(--text);
  font-size: 0.92rem;
  line-height: 1.4;
}

.service-checkbox-item input {
  width: 1rem;
  height: 1rem;
  margin: 0;
}

.inline-feedback {
  display: none;
  align-items: center;
  gap: 0.6rem;
  margin-bottom: 1rem;
  padding: 0.9rem 1rem;
  border-radius: 18px;
  background: #ECFDF5;
  border: 1px solid #A7F3D0;
  color: #047857;
  font-size: 0.88rem;
  font-weight: 700;
  line-height: 1.5;
}

.inline-feedback.show {
  display: flex;
}

.inline-feedback.is-error {
  background: #FEF2F2;
  border-color: #FECACA;
  color: #B91C1C;
}

.inline-feedback.is-error strong {
  color: #991B1B;
}

.inline-feedback strong {
  color: #065F46;
}

#register-feedback {
  position: fixed;
  left: 50%;
  bottom: 18px;
  transform: translateX(-50%);
  width: min(680px, calc(100vw - 24px));
  margin: 0;
  z-index: 1200;
  box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
  backdrop-filter: blur(12px);
}

#register-feedback.show {
  display: flex;
}

.photo-panel {
  grid-column: 1 / -1;
  border: 1px solid var(--border);
  border-radius: 24px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.photo-panel h4 {
  margin: 0 0 0.35rem;
  color: var(--accent);
  font-size: 1rem;
}

.photo-panel p {
  margin: 0 0 1rem;
  color: var(--muted);
  line-height: 1.6;
  font-size: 0.9rem;
}

.photo-uploader {
  display: grid;
  grid-template-columns: 124px 1fr;
  gap: 1rem;
  align-items: center;
}

.photo-preview {
  width: 124px;
  height: 124px;
  border-radius: 24px;
  border: 1.5px dashed var(--border);
  background: #FFFFFF;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  color: var(--muted);
  font-size: 0.78rem;
  font-weight: 700;
  text-align: center;
  padding: 0.75rem;
}

.photo-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.photo-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.photo-btn {
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 0.85rem 1rem;
  background: #FFFFFF;
  color: var(--accent);
  font-weight: 800;
  cursor: pointer;
}

.photo-btn.primary {
  background: var(--primary-light);
  color: var(--primary);
  border-color: rgba(124, 58, 237, 0.18);
}

.debug-token-btn {
  border: 1px dashed rgba(124, 58, 237, 0.35);
  border-radius: 16px;
  padding: 0.85rem 1rem;
  background: #F8FAFC;
  color: var(--primary);
  font-weight: 800;
  cursor: pointer;
}

@media (max-width: 980px) {
  .register-hero,
  .register-grid,
  .feature-strip,
  .form-grid,
  .provider-service-grid,
  .photo-uploader {
    grid-template-columns: 1fr;
  }

  .submit-row,
  .section-head {
    flex-direction: column;
    align-items: flex-start;
  }
}

@media (max-width: 640px) {
  .register-shell {
    padding: 0.85rem;
  }

  .intro-card,
  .summary-card,
  .form-card,
  .info-card {
    border-radius: 24px;
  }

  .intro-card,
  .summary-card,
  .form-card,
  .info-card {
    padding: 1.1rem;
  }

  .intro-card h1 {
    font-size: 1.9rem;
    line-height: 1.08;
  }

  .intro-card p,
  .section-head p,
  .submit-row p,
  .feature-item span,
  .summary-point span,
  .support-item p {
    font-size: 0.92rem;
    line-height: 1.55;
  }

  .eyebrow,
  .status-chip {
    white-space: normal;
  }

  .role-toggle {
    gap: 0.8rem;
  }

  .role-card {
    border-radius: 20px;
    padding: 0.95rem;
  }

  .field label {
    font-size: 0.74rem;
  }

  .field input,
  .field select,
  .field textarea {
    border-radius: 16px;
    padding: 0.88rem 0.95rem;
    font-size: 0.95rem;
  }

  .address-row {
    grid-template-columns: 1fr;
    gap: 0.7rem;
  }

  .location-btn,
  .primary-btn,
  .secondary-btn {
    width: 100%;
    justify-content: center;
  }

  .submit-row {
    width: 100%;
    gap: 0.9rem;
  }

  .primary-btn {
    width: 100%;
  }

  .provider-service-panel,
  .offering-card,
  .support-item,
  .feature-item {
    border-radius: 20px;
    padding: 0.95rem;
  }

  .offering-head {
    flex-direction: column;
    align-items: stretch;
    gap: 0.8rem;
  }

  .offering-remove {
    width: 100%;
    text-align: center;
  }

  .inline-feedback {
    border-radius: 16px;
    padding: 0.85rem 0.9rem;
    font-size: 0.84rem;
  }

  #register-feedback {
    width: calc(100vw - 20px);
    bottom: 10px;
    border-radius: 14px;
    padding: 0.8rem 0.85rem;
    font-size: 0.82rem;
  }
}

@media (max-width: 420px) {
  .register-shell {
    padding: 0.7rem;
  }

  .intro-card,
  .summary-card,
  .form-card,
  .info-card {
    border-radius: 20px;
    padding: 1rem;
  }

  .intro-card h1 {
    font-size: 1.7rem;
  }

  .section-head h3 {
    font-size: 1.2rem;
  }

  .field input,
  .field select,
  .field textarea {
    padding: 0.82rem 0.88rem;
  }

  .provider-service-panel,
  .offering-card {
    border-radius: 18px;
    padding: 0.85rem;
  }
}
</style>

<div class="register-shell">
  <section class="register-hero">
    <div class="intro-card">
      <div class="eyebrow">Join HomeEase</div>
      <h1>One page for customers and service providers.</h1>
      <p>
        Choose whether you want to find help at home or work and earn as a provider.
        The layout follows the rest of the HomeEase website, with a clean card style,
        simple forms, and location-based address support for normal users.
      </p>

        <div class="feature-strip">
        <div class="feature-item">
          <strong>Find Help</strong>
          <span>Quick signup for customers with required mobile number and optional email.</span>
        </div>
        <div class="feature-item">
          <strong>Use Location</strong>
          <span>Fetch current location and fill the address field automatically.</span>
        </div>
        <div class="feature-item">
          <strong>Provider Form</strong>
          <span>Simple provider details with Aadhaar, phone, service type, and address.</span>
        </div>
      </div>
    </div>

    <aside class="summary-card">
      <h2>What this page now does</h2>
      <p>It keeps the registration flow simple and closer to the rest of the site instead of feeling like a separate app.</p>

      <div class="summary-points">
        <div class="summary-point">
          <strong>Normal user</strong>
          <span>Find Help mode with optional personal details and dynamic address fill.</span>
        </div>
        <div class="summary-point">
          <strong>Provider</strong>
          <span>No verification flow. Just collect the basic information you asked for.</span>
        </div>
        <div class="summary-point">
          <strong>Prototype ready</strong>
          <span>Front-end interaction works now and can be connected to backend later.</span>
        </div>
      </div>
    </aside>
  </section>

  <section class="register-grid">
    <div class="form-card">
      <div class="section-head">
        <div>
          <h3>Create your profile</h3>
          <p>Select how you want to use HomeEase and fill only the details needed for that role.</p>
        </div>
        <span class="status-chip">Simple Signup</span>
      </div>

      <div class="role-toggle">
        <div class="role-card {{ $initialRole === 'user' ? 'active' : '' }}" id="role-user-card" onclick="setRole('user')">
          <strong>Find Help</strong>
          <span>For customers who want cooks, cleaners, and home experts.</span>
        </div>
        <div class="role-card {{ $initialRole === 'provider' ? 'active' : '' }}" id="role-provider-card" onclick="setRole('provider')">
          <strong>Work &amp; Earn</strong>
          <span>For service providers who want to receive local work requests.</span>
        </div>
      </div>

      <form class="register-form" id="register-form" onsubmit="submitRegisterForm(event)">
        @csrf
        <input type="hidden" id="selected-role" value="{{ $initialRole }}">
        <input type="hidden" id="mobile-token" value="">
        <input type="hidden" id="profile-image-data" value="">
        <input type="file" id="profile-camera-input" accept="image/png,image/jpeg,image/webp" capture="user" style="display:none;" onchange="handleProfileImageSelection(event)">
        <input type="file" id="profile-image-input" accept="image/png,image/jpeg,image/webp" style="display:none;" onchange="handleProfileImageSelection(event)">
        <div id="register-feedback" class="inline-feedback" role="alert" aria-live="polite"></div>

        <div class="photo-panel">
          <h4>Profile photo or selfie</h4>
          <p>Upload a clear face photo. This is mandatory for both customers and providers, and you can open the camera directly on mobile.</p>
          <div class="photo-uploader">
            <div class="photo-preview" id="profile-image-preview">Selfie or profile photo required</div>
            <div>
              <div class="photo-actions">
                <button type="button" class="photo-btn primary" onclick="openProfileCamera()">Open Camera</button>
                <button type="button" class="photo-btn" onclick="openProfileImagePicker()">Choose Photo</button>
                <button type="button" class="photo-btn" onclick="clearProfileImage()">Remove Photo</button>
              </div>
              <div class="field-note" id="profile-image-status" style="margin-top:0.75rem;">A clear front-facing photo is required for both customers and providers. You can open the camera directly or choose a saved image.</div>
            </div>
          </div>
        </div>

        <div id="user-fields" class="{{ $initialRole === 'provider' ? 'hidden' : '' }}">
          <div class="form-grid">
            <div class="field">
              <label for="user-name">Name</label>
              <input id="user-name" type="text" placeholder="Optional">
            </div>

            <div class="field">
              <label for="user-phone">Phone Number</label>
              <input id="user-phone" type="tel" placeholder="+91 98765 43210" required>
            </div>

            <div class="field full">
              <label for="user-email">Email Address</label>
              <input id="user-email" type="email" placeholder="Optional">
            </div>

            <div class="field">
              <label for="user-password">Password</label>
              <input id="user-password" type="password" placeholder="Minimum 8 characters" required>
            </div>

            <div class="field">
              <label for="user-password-confirmation">Confirm Password</label>
              <input id="user-password-confirmation" type="password" placeholder="Repeat password" required>
            </div>

            <div class="field full">
              <label for="user-address">Address</label>
              <div class="address-row">
                <input id="user-address" type="text" placeholder="Your area or full address">
                <button class="location-btn" type="button" id="location-button" onclick="fetchLocation()">Use Location</button>
              </div>
              <div class="field-note" id="location-status">You can type your address manually or fetch your current location.</div>
            </div>

            <div class="field full">
              <label for="user-help-type">What help do you need?</label>
              <select id="user-help-type">
                <option value="">Select a service</option>
                <option>Electrician</option>
                <option>Plumber</option>
                <option>AC / Cooler Repair</option>
                <option>Driver</option>
              </select>
            </div>

            <div class="field full">
              <label for="user-note">Notes</label>
              <textarea id="user-note" placeholder="Optional details about the service you need"></textarea>
            </div>
          </div>
        </div>

        <div id="provider-fields" class="{{ $initialRole === 'provider' ? '' : 'hidden' }}">
          <div class="form-grid">
            <div class="field">
              <label for="provider-name">Full Name</label>
              <input id="provider-name" type="text" placeholder="Enter full name" required>
            </div>

            <div class="field">
              <label for="provider-phone">Phone Number</label>
              <input id="provider-phone" type="tel" placeholder="+91 98765 43210" required>
            </div>

            <div class="field">
              <label for="provider-email">Email Address</label>
              <input id="provider-email" type="email" placeholder="Optional">
            </div>

            <div class="field">
              <label for="provider-password">Password</label>
              <input id="provider-password" type="password" placeholder="Minimum 8 characters" required>
            </div>

            <div class="field">
              <label for="provider-password-confirmation">Confirm Password</label>
              <input id="provider-password-confirmation" type="password" placeholder="Repeat password" required>
            </div>

            <div class="field">
              <label for="provider-aadhaar">Aadhaar Number</label>
              <input id="provider-aadhaar" type="text" inputmode="numeric" maxlength="12" placeholder="12-digit Aadhaar number" required>
            </div>

            <div class="field">
              <label for="provider-city">Area (Panipat)</label>
              <input id="provider-city" type="text" placeholder="Panipat" required>
            </div>

            <div class="field full">
              <label for="provider-address">Address</label>
              <div class="address-row">
                <textarea id="provider-address" placeholder="Enter your Panipat area or full address" required></textarea>
                <button class="location-btn" type="button" id="provider-location-button" onclick="fetchProviderLocation()">Use Current Location</button>
              </div>
              <div class="field-note" id="provider-location-status">Providers can fetch their current Panipat working address and area automatically.</div>
            </div>

            <div class="provider-service-panel">
              <div class="offering-head">
                <div>
                  <strong>Service offerings</strong>
                  <span>Keep it simple: choose the service, tick the jobs you do, add experience, and enter a price within the approved range.</span>
                </div>
                <button class="secondary-btn" type="button" onclick="addProviderOffering()">Add Service</button>
              </div>
              <div id="provider-offering-feedback" class="inline-feedback" role="status" aria-live="polite"></div>
              <div id="provider-offerings" class="offering-stack"></div>
              <div class="field-note">Available services: Electrician, Plumber, AC / Cooler Repair, and Driver.</div>
            </div>
          </div>
        </div>

        <div class="submit-row">
          <p id="submit-copy">{{ $initialRole === 'provider' ? 'Provider mode collects basic operational details, service offerings, and the device token if your mobile app shares it for notifications.' : 'Customer mode requires your mobile number, and the device token is saved too when your mobile app or phone provides one for notifications.' }}</p>
          <div style="display:flex; flex-wrap:wrap; gap:0.75rem; width:100%; justify-content:flex-end;">
            <a href="{{ route('login') }}" class="secondary-btn" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">Already have an account? Login</a>
            <button class="debug-token-btn" type="button" onclick="debugDeviceToken()">Check Device Token</button>
            <button class="primary-btn" type="submit" id="submit-button">{{ $initialRole === 'provider' ? 'Continue as Provider' : 'Continue as Customer' }}</button>
          </div>
        </div>
      </form>
    </div>

    <aside class="info-card">
      <div class="section-head">
        <div>
          <h3>Support and guidance</h3>
          <p>Use the right page if you need help after signup.</p>
        </div>
      </div>

      <div class="support-stack">
        <div class="support-item">
          <strong>Customers</strong>
          <p>Use the customer contact page for booking help, refunds, account issues, and support questions.</p>
          <a class="support-link" href="{{ route('contact.user') }}">Customer Contact</a>
        </div>

        <div class="support-item">
          <strong>Providers</strong>
          <p>Use the provider support page for payouts, profile issues, job concerns, and account support.</p>
          <a class="support-link" href="{{ route('contact.provider') }}">Provider Support</a>
        </div>

        <div class="support-item">
          <strong>Current setup</strong>
          <p>This registration form now saves users in Laravel, stores provider service offerings, and keeps the mobile notification token when the client sends one.</p>
        </div>
      </div>
    </aside>
  </section>
</div>

<script>
let providerOfferingIndex = 0;
let providerOfferingFeedbackTimer = null;

const providerServiceOptions = [
  {
    value: 'electrician',
    label: 'Electrician',
    subtypeLabel: 'Services offered',
    subtypeOptions: ['Visit fee', 'Switch / socket', 'Fan repair', 'Wiring'],
    pricePlaceholder: '149',
    defaultPricingModel: 'Per visit',
    priceGuide: [
      'Visit Fee: Rs. 99 - 149',
      'Small jobs: Switch / socket Rs. 100 - 200',
      'Fan repair: Rs. 150 - 300',
      'Bigger work: Wiring Rs. 300 - 800'
    ]
  },
  {
    value: 'plumber',
    label: 'Plumber',
    subtypeLabel: 'Services offered',
    subtypeOptions: ['Visit fee', 'Tap repair', 'Leakage fix', 'Pipe work'],
    pricePlaceholder: '149',
    defaultPricingModel: 'Per visit',
    priceGuide: [
      'Visit Fee: Rs. 99 - 149',
      'Small jobs: Tap repair Rs. 100 - 200',
      'Leakage fix: Rs. 150 - 300',
      'Bigger work: Pipe work Rs. 300 - 1000'
    ]
  },
  {
    value: 'ac_cooler_repair',
    label: 'AC / Cooler Repair',
    subtypeLabel: 'Services offered',
    subtypeOptions: ['Visit fee', 'Gas check', 'Gas refill', 'General service'],
    pricePlaceholder: '199',
    defaultPricingModel: 'Per visit',
    priceGuide: [
      'Visit Fee: Rs. 149 - 199',
      'Gas check: Rs. 0 - 100',
      'Gas refill: Rs. 1500 - 2500',
      'General service: Rs. 300 - 600'
    ]
  },
  {
    value: 'driver',
    label: 'Driver',
    subtypeLabel: 'Services offered',
    subtypeOptions: ['Driver only (without car)', 'Driver with car', 'Office pickup / drop', 'Outstation driver duty'],
    defaultPricingModel: 'Per day',
    priceGuide: [
      'Driver only (without car): Rs. 800 - 1200',
      'Driver with car: Rs. 1800 - 3000',
      'Office pickup / drop: Rs. 1000 - 1800',
      'Outstation driver duty: Rs. 2000 - 3000'
    ]
  }
];

document.addEventListener('DOMContentLoaded', function () {
  setRole('{{ $initialRole }}');
  captureMobileToken();
});

function getProviderServiceMeta(service) {
  return providerServiceOptions.find((option) => option.value === service) || providerServiceOptions[0];
}

function getProviderServiceSelectOptions(selectedValue) {
  return providerServiceOptions.map((option) => `<option value="${option.value}" ${option.value === selectedValue ? 'selected' : ''}>${option.label}</option>`).join('');
}

function getProviderMetaOptions(options = [], selectedValue = '') {
  return options.map((option) => `<option value="${option}" ${option === selectedValue ? 'selected' : ''}>${option}</option>`).join('');
}

function getProviderModeOptions(meta, selectedValue = '') {
  return (meta.modeOptions || []).map((option) => `<option value="${option}" ${option === selectedValue ? 'selected' : ''}>${option}</option>`).join('');
}

function renderServiceCheckboxOptions(index, options = [], selectedValues = []) {
  return options.map((option, optionIndex) => `
    <label class="service-checkbox-item" for="provider-offering-subtype-${index}-${optionIndex}">
      <input
        id="provider-offering-subtype-${index}-${optionIndex}"
        type="checkbox"
        value="${option}"
        ${selectedValues.includes(option) ? 'checked' : ''}
        onchange="syncOfferingSubtype(${index})"
      >
      <span>${option}</span>
    </label>
  `).join('');
}

function getSelectedSubtypeValues(index) {
  return Array.from(document.querySelectorAll(`[data-offering-index="${index}"] .service-checkbox-item input:checked`))
    .map((input) => input.value.trim())
    .filter(Boolean);
}

function syncOfferingSubtype(index) {
  const hiddenInput = document.getElementById(`provider-offering-subtype-${index}`);
  if (!hiddenInput) return;

  hiddenInput.value = getSelectedSubtypeValues(index).join(', ');
}

function formatPriceGuide(meta) {
  const guideLines = meta.priceGuide || [];
  return guideLines.join('<br>');
}

function createOfferingMarkup(index, service = 'electrician') {
  const meta = getProviderServiceMeta(service);

  return `
    <div class="offering-card" data-offering-card data-offering-index="${index}">
      <div class="offering-head">
        <div>
          <strong>Service offering ${index + 1}</strong>
          <span>Choose one service, select the jobs you handle, and add your experience.</span>
        </div>
        <button class="offering-remove" type="button" onclick="removeProviderOffering(${index})">Remove</button>
      </div>
      <div class="provider-service-grid">
        <div class="field">
          <label for="provider-offering-service-${index}">Service Type</label>
          <select id="provider-offering-service-${index}" data-offering-service onchange="updateOfferingCard(${index})">
            ${getProviderServiceSelectOptions(service)}
          </select>
        </div>
        <div class="field full">
          <label for="provider-offering-subtype-${index}" data-offering-subtype-label>${meta.subtypeLabel}</label>
          <input id="provider-offering-subtype-${index}" type="hidden" data-offering-required value="">
          <div class="service-checkbox-list" data-offering-subtype-options>
            ${renderServiceCheckboxOptions(index, meta.subtypeOptions)}
          </div>
        </div>
        <div class="field">
          <label for="provider-offering-experience-${index}">Experience (Years)</label>
          <input id="provider-offering-experience-${index}" type="number" min="0" max="60" placeholder="Example: 3">
        </div>
        <div class="field full">
          <label>Fixed Customer Pricing</label>
          <div class="field-note" data-offering-price-range-note>${formatPriceGuide(meta)}</div>
        </div>
      </div>
    </div>
  `;
}

function addProviderOffering(service = 'electrician') {
  const container = document.getElementById('provider-offerings');
  if (!container) return;

  container.insertAdjacentHTML('beforeend', createOfferingMarkup(providerOfferingIndex, service));
  const newCard = container.lastElementChild;
  providerOfferingIndex += 1;
  syncProviderOfferingState();

  if (newCard) {
    showProviderOfferingFeedback('Service added successfully. Please scroll down to complete the new service details.');
    newCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

function removeProviderOffering(index) {
  const card = document.querySelector(`[data-offering-index="${index}"]`);
  if (card) {
    card.remove();
  }

  syncProviderOfferingState();
}

function updateOfferingCard(index) {
  const card = document.querySelector(`[data-offering-index="${index}"]`);
  if (!card) return;

  const serviceSelect = card.querySelector('[data-offering-service]');
  const subtypeLabel = card.querySelector('[data-offering-subtype-label]');
  const subtypeInput = card.querySelector(`#provider-offering-subtype-${index}`);
  const subtypeOptions = card.querySelector('[data-offering-subtype-options]');
  const priceRangeNote = card.querySelector('[data-offering-price-range-note]');

  const meta = getProviderServiceMeta(serviceSelect.value);
  const selectedValues = subtypeInput?.value ? subtypeInput.value.split(', ').filter(Boolean) : [];

  subtypeLabel.textContent = meta.subtypeLabel;
  subtypeOptions.innerHTML = renderServiceCheckboxOptions(index, meta.subtypeOptions, selectedValues);

  if (priceRangeNote) {
    priceRangeNote.innerHTML = formatPriceGuide(meta);
  }

  syncOfferingSubtype(index);
}

function syncProviderOfferingState() {
  const container = document.getElementById('provider-offerings');
  const submitCopy = document.getElementById('submit-copy');
  const selectedRole = document.getElementById('selected-role').value;
  const cards = container ? container.querySelectorAll('[data-offering-card]') : [];

  if (selectedRole === 'provider' && cards.length === 0) {
    addProviderOffering();
    return;
  }

  cards.forEach((card, index) => {
    const title = card.querySelector('.offering-head strong');
    if (title) {
      title.textContent = `Service offering ${index + 1}`;
    }
  });

  document.querySelectorAll('[data-offering-required]').forEach((input) => {
    if (selectedRole === 'provider') {
      input.setAttribute('required', 'required');
    } else {
      input.removeAttribute('required');
    }
  });

  if (selectedRole === 'provider' && submitCopy) {
    submitCopy.textContent = 'Provider mode lets you add multiple services and saves the mobile notification token too when it is available on the device.';
  }
}

function showRegisterFeedback(message, type = 'success') {
  const feedback = document.getElementById('register-feedback');
  if (!feedback) return;

  feedback.innerHTML = `<strong>${type === 'error' ? 'Please check:' : 'Done:'}</strong> ${message}`;
  feedback.classList.add('show');
  feedback.classList.toggle('is-error', type === 'error');

  if (type !== 'error') {
    window.clearTimeout(showRegisterFeedback.dismissTimer);
    showRegisterFeedback.dismissTimer = window.setTimeout(() => {
      hideRegisterFeedback();
    }, 2800);
  } else {
    window.clearTimeout(showRegisterFeedback.dismissTimer);
  }
}

function hideRegisterFeedback() {
  const feedback = document.getElementById('register-feedback');
  if (!feedback) return;

  feedback.classList.remove('show', 'is-error');
  feedback.innerHTML = '';
}

function clearRegisterFieldErrors() {
  document.querySelectorAll('.is-invalid').forEach((element) => {
    element.classList.remove('is-invalid');
  });

  document.querySelectorAll('.field-error-message').forEach((element) => {
    element.remove();
  });

  const photoPanel = document.querySelector('.photo-panel');
  const offeringPanel = document.querySelector('.provider-service-panel');

  photoPanel?.classList.remove('is-invalid');
  offeringPanel?.classList.remove('is-invalid');
}

function getRegisterErrorTarget(errorKey) {
  const directMap = {
    profile_image_data: document.getElementById('profile-image-status'),
    user_name: document.getElementById('user-name'),
    user_phone: document.getElementById('user-phone'),
    user_email: document.getElementById('user-email'),
    user_password: document.getElementById('user-password'),
    user_password_confirmation: document.getElementById('user-password-confirmation'),
    user_address: document.getElementById('user-address'),
    user_help_type: document.getElementById('user-help-type'),
    user_note: document.getElementById('user-note'),
    provider_name: document.getElementById('provider-name'),
    provider_phone: document.getElementById('provider-phone'),
    provider_email: document.getElementById('provider-email'),
    provider_password: document.getElementById('provider-password'),
    provider_password_confirmation: document.getElementById('provider-password-confirmation'),
    provider_aadhaar: document.getElementById('provider-aadhaar'),
    provider_city: document.getElementById('provider-city'),
    provider_address: document.getElementById('provider-address'),
    provider_offerings: document.getElementById('provider-offering-feedback'),
  };

  if (directMap[errorKey]) {
    return directMap[errorKey];
  }

  if (errorKey.startsWith('provider_offerings.')) {
    return document.getElementById('provider-offering-feedback');
  }

  return null;
}

function applyRegisterValidationErrors(errors = {}) {
  clearRegisterFieldErrors();

  let firstTarget = null;

  Object.entries(errors).forEach(([key, messages]) => {
    const target = getRegisterErrorTarget(key);
    const message = Array.isArray(messages) ? messages[0] : messages;

    if (!target || !message) {
      return;
    }

    if (!firstTarget) {
      firstTarget = target;
    }

    if (key === 'profile_image_data') {
      document.querySelector('.photo-panel')?.classList.add('is-invalid');
      showRegisterFeedback(message, 'error');
      return;
    }

    if (key === 'provider_offerings' || key.startsWith('provider_offerings.')) {
      document.querySelector('.provider-service-panel')?.classList.add('is-invalid');
      const offeringFeedback = document.getElementById('provider-offering-feedback');
      if (offeringFeedback) {
        offeringFeedback.innerHTML = `<strong>Please check:</strong> ${message}`;
        offeringFeedback.classList.add('show', 'is-error');
      }
      return;
    }

    target.classList.add('is-invalid');
    const field = target.closest('.field') || target.parentElement;
    if (!field) {
      return;
    }

    const existingMessage = field.querySelector('.field-error-message');
    if (existingMessage) {
      existingMessage.textContent = message;
      return;
    }

    const errorNode = document.createElement('div');
    errorNode.className = 'field-error-message';
    errorNode.textContent = message;
    field.appendChild(errorNode);
  });

  if (Object.keys(errors).length > 0) {
    const totalIssues = Object.values(errors).flat().length;
    showRegisterFeedback(`${totalIssues} issue${totalIssues === 1 ? '' : 's'} found. Please check the highlighted fields.`, 'error');
  }

  if (firstTarget) {
    firstTarget.scrollIntoView({ behavior: 'smooth', block: 'center' });
    if (typeof firstTarget.focus === 'function' && !['register-feedback', 'provider-offering-feedback', 'profile-image-status'].includes(firstTarget.id)) {
      firstTarget.focus();
    }
  }
}

function getStoredMobileTokenCandidate() {
  const params = new URLSearchParams(window.location.search);
  const candidates = [
    params.get('device_token'),
    params.get('mobile_token'),
    params.get('fcm_token'),
    window.HomeEaseMobileToken,
    window.deviceToken,
    window.fcmToken,
    window.HomeEase && window.HomeEase.mobileToken,
    window.webkit?.messageHandlers?.deviceToken,
    localStorage.getItem('homeease_mobile_token'),
    localStorage.getItem('homeease_notification_token'),
    localStorage.getItem('fcm_token'),
    sessionStorage.getItem('homeease_mobile_token'),
    sessionStorage.getItem('homeease_notification_token'),
    sessionStorage.getItem('fcm_token')
  ];

  return candidates.find((token) => typeof token === 'string' && token.trim() !== '') || '';
}

function setCapturedMobileToken(token) {
  const normalizedToken = typeof token === 'string' ? token.trim() : '';
  const mobileTokenInput = document.getElementById('mobile-token');

  if (!normalizedToken || !mobileTokenInput) {
    return '';
  }

  mobileTokenInput.value = normalizedToken;
  localStorage.setItem('homeease_mobile_token', normalizedToken);
  sessionStorage.setItem('homeease_mobile_token', normalizedToken);

  return normalizedToken;
}

window.setHomeEaseMobileToken = function(token) {
  setCapturedMobileToken(token);
};

window.addEventListener('message', (event) => {
  const data = event.data;

  if (typeof data === 'string') {
    setCapturedMobileToken(data);
    return;
  }

  const token = data?.mobile_token || data?.device_token || data?.fcm_token || data?.token;

  if (typeof token === 'string') {
    setCapturedMobileToken(token);
  }
});

async function waitForMobileToken(timeoutMs = 1500) {
  const start = Date.now();
  let token = getStoredMobileTokenCandidate();

  while (!token && Date.now() - start < timeoutMs) {
    await new Promise((resolve) => setTimeout(resolve, 200));
    token = getStoredMobileTokenCandidate();
  }

  return token || '';
}

async function captureMobileToken() {
  const mobileTokenInput = document.getElementById('mobile-token');
  if (!mobileTokenInput) return '';

  let token = getStoredMobileTokenCandidate();

  if (!token && typeof window.HomeEaseRequestDeviceToken === 'function') {
    token = await window.HomeEaseRequestDeviceToken({ forcePermissionPrompt: false });
  }

  if (!token && 'serviceWorker' in navigator && 'PushManager' in window) {
    try {
      const registration = await navigator.serviceWorker.ready;
      const subscription = await registration.pushManager.getSubscription();

      if (subscription && subscription.endpoint) {
        token = `webpush:${subscription.endpoint}`;
      }
    } catch (error) {
      // Ignore token discovery errors and continue without a device token.
    }
  }

  if (!token) {
    token = await waitForMobileToken();
  }

  return setCapturedMobileToken(token);
}

async function debugDeviceToken() {
  let token = '';

  if (typeof window.HomeEaseRequestDeviceToken === 'function') {
    token = await window.HomeEaseRequestDeviceToken({ forcePermissionPrompt: true });
  }

  if (!token) {
    token = await captureMobileToken();
  }

  if (token) {
    alert(`Device token detected:\n\n${token}`);
    return;
  }

  alert('No device token detected right now. Check whether the phone/app/webview is actually providing one.');
}

function openProfileImagePicker() {
  const input = document.getElementById('profile-image-input');
  if (input) {
    input.click();
  }
}

function openProfileCamera() {
  const input = document.getElementById('profile-camera-input');
  if (input) {
    input.click();
  }
}

function clearProfileImage() {
  const input = document.getElementById('profile-image-input');
  const cameraInput = document.getElementById('profile-camera-input');
  const hiddenInput = document.getElementById('profile-image-data');
  const preview = document.getElementById('profile-image-preview');
  const status = document.getElementById('profile-image-status');

  if (input) {
    input.value = '';
  }

  if (cameraInput) {
    cameraInput.value = '';
  }

  if (hiddenInput) {
    hiddenInput.value = '';
  }

  if (preview) {
    preview.innerHTML = 'Selfie or profile photo required';
  }

  if (status) {
    status.textContent = 'A clear front-facing photo helps trust and safer bookings.';
  }
}

function handleProfileImageSelection(event) {
  const file = event.target.files?.[0];
  const hiddenInput = document.getElementById('profile-image-data');
  const preview = document.getElementById('profile-image-preview');
  const status = document.getElementById('profile-image-status');

  if (!file) {
    return;
  }

  if (!file.type.startsWith('image/')) {
    showRegisterFeedback('Please select a valid image file for the profile photo.', 'error');
    return;
  }

  const reader = new FileReader();
  reader.onload = function(loadEvent) {
    const result = typeof loadEvent.target?.result === 'string' ? loadEvent.target.result : '';

    if (!result) {
      showRegisterFeedback('Unable to read the selected image. Please try another photo.', 'error');
      return;
    }

    if (hiddenInput) {
      hiddenInput.value = result;
    }

    if (preview) {
      preview.innerHTML = `<img src="${result}" alt="Profile preview">`;
    }

    if (status) {
      status.textContent = 'Photo added successfully. This selfie will be saved with the account.';
    }
  };

  reader.readAsDataURL(file);
}

function extractResolvedLocation(data) {
  const address = data?.address || {};

  return {
    fullAddress: data?.display_name || '',
    city: address.city || address.town || address.village || address.state_district || address.county || '',
  };
}

async function reverseGeocode(latitude, longitude) {
  const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`, {
    headers: {
      'Accept': 'application/json'
    }
  });

  if (!response.ok) {
    throw new Error('Reverse geocoding failed');
  }

  return response.json();
}

function withLocationButtonState(button, text, isDisabled) {
  if (!button) {
    return;
  }

  button.disabled = isDisabled;
  button.textContent = text;
}

function buildProviderOfferingsPayload() {
  return Array.from(document.querySelectorAll('[data-offering-card]')).map((card) => {
    const index = card.getAttribute('data-offering-index');
    const serviceType = document.getElementById(`provider-offering-service-${index}`)?.value || '';
    const selectedServices = getSelectedSubtypeValues(index);
    const meta = getProviderServiceMeta(serviceType);

    return {
      service_type: serviceType,
      service_subtype: selectedServices.join(', '),
      offering_name: `${meta.label} service`,
      details: selectedServices.join(', ') || meta.label,
      service_mode: 'Standard',
      pricing_model: meta.defaultPricingModel || 'Per visit',
      price_amount: null,
      experience_years: Number(document.getElementById(`provider-offering-experience-${index}`)?.value || 0) || null,
      timing: 'On request',
      price: 'Fixed service rates apply',
      notes: (meta.priceGuide || []).join(' | '),
      service_attributes: {
        work_option: selectedServices.join(', '),
      }
    };
  });
}

async function buildRegisterPayload() {
  const role = document.getElementById('selected-role').value;
  let mobileToken = document.getElementById('mobile-token')?.value || getStoredMobileTokenCandidate() || '';

  if (!mobileToken) {
    mobileToken = await waitForMobileToken(400);
  }

  return {
    role,
    mobile_token: mobileToken,
    profile_image_data: document.getElementById('profile-image-data')?.value || '',
    user_name: document.getElementById('user-name')?.value.trim() || '',
    user_phone: document.getElementById('user-phone')?.value.trim() || '',
    user_email: document.getElementById('user-email')?.value.trim() || '',
    user_password: document.getElementById('user-password')?.value || '',
    user_password_confirmation: document.getElementById('user-password-confirmation')?.value || '',
    user_address: document.getElementById('user-address')?.value.trim() || '',
    user_help_type: document.getElementById('user-help-type')?.value || '',
    user_note: document.getElementById('user-note')?.value.trim() || '',
    provider_name: document.getElementById('provider-name')?.value.trim() || '',
    provider_phone: document.getElementById('provider-phone')?.value.trim() || '',
    provider_email: document.getElementById('provider-email')?.value.trim() || '',
    provider_password: document.getElementById('provider-password')?.value || '',
    provider_password_confirmation: document.getElementById('provider-password-confirmation')?.value || '',
    provider_aadhaar: document.getElementById('provider-aadhaar')?.value.trim() || '',
    provider_city: document.getElementById('provider-city')?.value.trim() || '',
    provider_address: document.getElementById('provider-address')?.value.trim() || '',
    provider_offerings: role === 'provider' ? buildProviderOfferingsPayload() : []
  };
}

function showProviderOfferingFeedback(message) {
  const feedback = document.getElementById('provider-offering-feedback');
  if (!feedback) return;

  feedback.innerHTML = `<strong>Updated:</strong> ${message}`;
  feedback.classList.add('show');

  if (providerOfferingFeedbackTimer) {
    clearTimeout(providerOfferingFeedbackTimer);
  }

  providerOfferingFeedbackTimer = setTimeout(() => {
    feedback.classList.remove('show');
  }, 3200);
}

function setRole(role) {
  const userFields = document.getElementById('user-fields');
  const providerFields = document.getElementById('provider-fields');
  const userCard = document.getElementById('role-user-card');
  const providerCard = document.getElementById('role-provider-card');
  const submitButton = document.getElementById('submit-button');
  const submitCopy = document.getElementById('submit-copy');
  const roleInput = document.getElementById('selected-role');

  roleInput.value = role;

  if (role === 'user') {
    userFields.classList.remove('hidden');
    providerFields.classList.add('hidden');
    userCard.classList.add('active');
    providerCard.classList.remove('active');
    submitButton.textContent = 'Continue as Customer';
    submitCopy.textContent = 'Customer mode requires your mobile number, and the device token is saved too when your mobile app or phone provides one for notifications.';

    document.getElementById('provider-name').removeAttribute('required');
    document.getElementById('provider-phone').removeAttribute('required');
    document.getElementById('provider-aadhaar').removeAttribute('required');
    document.getElementById('provider-city').removeAttribute('required');
    document.getElementById('provider-address').removeAttribute('required');
    document.getElementById('provider-password').removeAttribute('required');
    document.getElementById('provider-password-confirmation').removeAttribute('required');
    document.getElementById('user-phone').setAttribute('required', 'required');
    document.getElementById('user-password').setAttribute('required', 'required');
    document.getElementById('user-password-confirmation').setAttribute('required', 'required');
    document.querySelectorAll('[data-offering-required]').forEach((input) => input.removeAttribute('required'));
  } else {
    userFields.classList.add('hidden');
    providerFields.classList.remove('hidden');
    providerCard.classList.add('active');
    userCard.classList.remove('active');
    submitButton.textContent = 'Continue as Provider';
    submitCopy.textContent = 'Provider mode lets you add multiple services and saves the mobile notification token too when it is available on the device.';

    document.getElementById('provider-name').setAttribute('required', 'required');
    document.getElementById('provider-phone').setAttribute('required', 'required');
    document.getElementById('provider-aadhaar').setAttribute('required', 'required');
    document.getElementById('provider-city').setAttribute('required', 'required');
    document.getElementById('provider-address').setAttribute('required', 'required');
    document.getElementById('provider-password').setAttribute('required', 'required');
    document.getElementById('provider-password-confirmation').setAttribute('required', 'required');
    document.getElementById('user-phone').removeAttribute('required');
    document.getElementById('user-password').removeAttribute('required');
    document.getElementById('user-password-confirmation').removeAttribute('required');
  }

  syncProviderOfferingState();
  hideRegisterFeedback();
}

function fetchLocation() {
  const status = document.getElementById('location-status');
  const button = document.getElementById('location-button');
  const address = document.getElementById('user-address');

  if (!navigator.geolocation) {
    status.textContent = 'Location is not supported on this device.';
    return;
  }

  status.textContent = 'Fetching your current location...';
  button.disabled = true;
  button.textContent = 'Fetching...';

  navigator.geolocation.getCurrentPosition(
    async function(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      try {
        const data = await reverseGeocode(latitude, longitude);
        const resolvedAddress = extractResolvedLocation(data).fullAddress;

        if (!resolvedAddress) {
          throw new Error('Address not found');
        }

        address.value = resolvedAddress;
        status.textContent = 'Current address found. You can edit it if needed.';
      } catch (error) {
        address.value = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
        status.textContent = 'Exact address could not be detected, so coordinates were added instead. You can edit them manually.';
      } finally {
        withLocationButtonState(button, 'Use Location', false);
      }
    },
    function() {
      status.textContent = 'Location access was denied. You can still type the address manually.';
      withLocationButtonState(button, 'Use Location', false);
    }
  );
}

function fetchProviderLocation() {
  const status = document.getElementById('provider-location-status');
  const button = document.getElementById('provider-location-button');
  const address = document.getElementById('provider-address');
  const city = document.getElementById('provider-city');

  if (!navigator.geolocation) {
    status.textContent = 'Location is not supported on this device.';
    return;
  }

  status.textContent = 'Fetching provider current location...';
  withLocationButtonState(button, 'Fetching...', true);

  navigator.geolocation.getCurrentPosition(
    async function(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      try {
        const data = await reverseGeocode(latitude, longitude);
        const resolved = extractResolvedLocation(data);

        if (resolved.fullAddress) {
          address.value = resolved.fullAddress;
        } else {
          address.value = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
        }

        if (resolved.city) {
          city.value = resolved.city;
        }

        status.textContent = resolved.city
          ? 'Provider address and Panipat area updated from current location.'
          : 'Provider address updated from current location. Please confirm the Panipat area if needed.';
      } catch (error) {
        address.value = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
        status.textContent = 'Exact provider address could not be detected, so coordinates were added instead. You can edit them manually.';
      } finally {
        withLocationButtonState(button, 'Use Current Location', false);
      }
    },
    function() {
      status.textContent = 'Location access was denied. You can still type provider address and Panipat area manually.';
      withLocationButtonState(button, 'Use Current Location', false);
    },
    {
      enableHighAccuracy: true,
      timeout: 10000,
      maximumAge: 300000
    }
  );
}

async function submitRegisterForm(event) {
  event.preventDefault();

  const role = document.getElementById('selected-role').value;
  const form = document.getElementById('register-form');
  const button = document.getElementById('submit-button');
  const debugButton = document.querySelector('.debug-token-btn');
  const originalText = button.textContent;
  const csrfToken = document.querySelector('input[name="_token"]').value;

  hideRegisterFeedback();
  clearRegisterFieldErrors();

  button.disabled = true;
  if (debugButton) {
    debugButton.disabled = true;
  }
  form?.classList.add('is-submitting');
  button.textContent = role === 'user' ? 'Creating customer account...' : 'Creating provider account...';
  showRegisterFeedback('Please wait while we save your account details.', 'success');

  try {
    const payload = await buildRegisterPayload();

    if (!payload.profile_image_data) {
      showRegisterFeedback('Please upload a profile image or selfie before continuing.', 'error');
      document.querySelector('.photo-panel')?.classList.add('is-invalid');
      return;
    }

    const response = await fetch('{{ route('register.store') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(payload)
    });

    const result = await response.json();

    if (!response.ok) {
      if (result.errors) {
        applyRegisterValidationErrors(result.errors);
      } else {
        showRegisterFeedback(result.message || 'Something went wrong while saving your profile.', 'error');
      }
      return;
    }

    showRegisterFeedback(result.message + (payload.mobile_token ? ' Mobile notification token saved too.' : ''));
    window.setTimeout(() => {
      window.location.href = result.redirect || '{{ route('dashboard') }}';
    }, 900);
  } catch (error) {
    showRegisterFeedback('Unable to submit right now. Please try again.', 'error');
  } finally {
    button.disabled = false;
    if (debugButton) {
      debugButton.disabled = false;
    }
    form?.classList.remove('is-submitting');
    button.textContent = originalText;
  }
}
</script>
@endsection
