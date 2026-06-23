@extends('layouts.app')

@section('title', 'HomeEase | My Profile')

@section('content')
@php
  $user = $userProfile ?? auth()->user();
  $initials = collect(explode(' ', trim((string) ($user?->name ?? 'HomeEase User'))))
      ->filter()
      ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
      ->take(2)
      ->implode('');
  $isProvider = ($user?->role ?? 'user') === 'provider';
  $displayEmail = $user?->email && !str_ends_with($user->email, '@homeease.local') ? $user->email : '';
@endphp

<style>
:root {
  --primary: #7C3AED;
  --primary-dark: #5B21B6;
  --primary-light: #F5F3FF;
  --dark: #0F172A;
  --gray: #64748B;
  --white: #FFFFFF;
  --border: #E2E8F0;
  --bg: #F8FAFC;
  --success-bg: #ECFDF5;
  --success-text: #047857;
  --danger-bg: #FEF2F2;
  --danger-text: #B91C1C;
}

body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 28%),
    linear-gradient(180deg, #FCFBFF 0%, var(--bg) 100%);
}

.profile-shell {
  max-width: 1180px;
  margin: 0 auto;
  padding: clamp(1rem, 4vw, 2rem);
}

.profile-hero,
.profile-grid {
  display: grid;
  grid-template-columns: minmax(0, 1.15fr) minmax(280px, 0.85fr);
  gap: 1.2rem;
}

.profile-grid {
  margin-top: 1.2rem;
}

.hero-card,
.summary-card,
.form-card,
.token-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 30px;
  box-shadow: 0 24px 60px rgba(15, 23, 42, 0.06);
  padding: clamp(1.2rem, 4vw, 2rem);
}

.eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  padding: 0.65rem 0.95rem;
  border-radius: 999px;
  background: var(--primary-light);
  color: var(--primary);
  font-size: 0.78rem;
  font-weight: 800;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  margin-bottom: 1rem;
}

.hero-top {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  align-items: flex-start;
}

.hero-copy h1 {
  margin: 0 0 0.5rem;
  font-size: clamp(1.85rem, 4.5vw, 2.8rem);
  line-height: 1.05;
  letter-spacing: -0.05em;
  color: var(--dark);
}

.hero-copy p {
  margin: 0;
  color: var(--gray);
  line-height: 1.7;
  max-width: 58ch;
}

.avatar-card {
  display: inline-flex;
  align-items: center;
  gap: 0.85rem;
  padding: 0.85rem 1rem;
  border-radius: 22px;
  border: 1px solid rgba(124, 58, 237, 0.12);
  background: linear-gradient(135deg, #ffffff 0%, #f8f5ff 100%);
}

.avatar {
  width: 54px;
  height: 54px;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--primary), #A78BFA);
  color: #fff;
  font-size: 1rem;
  font-weight: 800;
  flex-shrink: 0;
}

.avatar-card strong {
  display: block;
  color: var(--dark);
}

.avatar-card span {
  color: var(--gray);
  font-size: 0.86rem;
}

.hero-metrics {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 0.85rem;
  margin-top: 1.2rem;
}

.metric {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.metric strong {
  display: block;
  color: var(--dark);
  font-size: 1.3rem;
  margin-bottom: 0.2rem;
}

.metric span {
  color: var(--gray);
  font-size: 0.84rem;
  line-height: 1.5;
}

.summary-card {
  background: linear-gradient(145deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: #fff;
}

.summary-card h2 {
  margin: 0 0 0.5rem;
  font-size: 1.55rem;
}

.summary-card p {
  margin: 0 0 1rem;
  opacity: 0.9;
  line-height: 1.65;
}

.summary-list {
  display: grid;
  gap: 0.8rem;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  padding: 0.9rem 1rem;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.12);
}

.summary-item span,
.summary-item strong {
  font-size: 0.9rem;
}

.section-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1rem;
}

.section-head h3 {
  margin: 0 0 0.35rem;
  font-size: 1.25rem;
  color: var(--dark);
}

.section-head p {
  margin: 0;
  color: var(--gray);
  line-height: 1.6;
  font-size: 0.92rem;
}

.flash-message,
.error-box {
  border-radius: 18px;
  padding: 0.95rem 1rem;
  margin-bottom: 1rem;
  font-size: 0.92rem;
  line-height: 1.55;
}

.flash-message {
  background: var(--success-bg);
  border: 1px solid #A7F3D0;
  color: var(--success-text);
}

.error-box {
  background: var(--danger-bg);
  border: 1px solid #FECACA;
  color: var(--danger-text);
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
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
  font-size: 0.78rem;
  font-weight: 800;
  color: var(--gray);
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.field input,
.field textarea,
.field select {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 18px;
  padding: 0.95rem 1rem;
  font: inherit;
  color: var(--dark);
  background: #fff;
}

.field textarea {
  min-height: 120px;
  resize: vertical;
}

.field input:focus,
.field textarea:focus,
.field select:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.12);
}

.field-note {
  color: var(--gray);
  font-size: 0.8rem;
  line-height: 1.5;
}

.submit-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}

.submit-row p {
  margin: 0;
  color: var(--gray);
  line-height: 1.6;
  font-size: 0.9rem;
}

.primary-btn,
.secondary-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 18px;
  padding: 0.95rem 1.25rem;
  font-weight: 800;
  text-decoration: none;
}

.primary-btn {
  border: none;
  background: linear-gradient(135deg, var(--primary), #8B5CF6);
  color: #fff;
  cursor: pointer;
  box-shadow: 0 18px 36px rgba(124, 58, 237, 0.22);
}

.secondary-link {
  border: 1px solid var(--border);
  background: #fff;
  color: var(--dark);
}

.danger-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  border: none;
  border-radius: 18px;
  padding: 0.95rem 1.25rem;
  font: inherit;
  font-weight: 800;
  background: #FFF1F2;
  color: #BE123C;
  cursor: pointer;
}

.full-width-action {
  width: 100%;
}

.token-card pre {
  margin: 0;
  white-space: pre-wrap;
  word-break: break-word;
  color: var(--dark);
  background: #F8FAFC;
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 1rem;
  font-size: 0.82rem;
  line-height: 1.55;
}

@media (max-width: 1024px) {
  .profile-hero,
  .profile-grid,
  .hero-metrics {
    grid-template-columns: 1fr;
  }

  .hero-top,
  .submit-row {
    flex-direction: column;
    align-items: flex-start;
  }
}

@media (max-width: 640px) {
  .profile-shell {
    padding: 0.85rem 0.85rem 5.5rem;
  }

  .hero-card,
  .summary-card,
  .form-card,
  .token-card {
    border-radius: 24px;
    padding: 1rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
  }

  .primary-btn,
  .secondary-link {
    width: 100%;
  }
}
</style>

<div class="profile-shell">
  <section class="profile-hero">
    <div class="hero-card">
      <div class="eyebrow">My Profile</div>

      <div class="hero-top">
        <div class="hero-copy">
          <h1>Manage your {{ $isProvider ? 'provider' : 'customer' }} profile.</h1>
          <p>
            This page is only for the signed-in user account. Update your contact details, address, notes,
            and mobile notification token here without affecting the separate professional/public profile route.
          </p>
        </div>

        <div class="avatar-card">
          <div class="avatar">{{ $initials ?: 'HE' }}</div>
          <div>
            <strong>{{ $user->name }}</strong>
            <span>{{ ucfirst($user->role ?? 'user') }} account</span>
          </div>
        </div>
      </div>

      <div class="hero-metrics">
        <div class="metric">
          <strong>{{ $user->created_at?->format('M Y') ?? now()->format('M Y') }}</strong>
          <span>Member since registration</span>
        </div>
        <div class="metric">
          <strong>{{ $user->mobile_token ? 'Ready' : 'Pending' }}</strong>
          <span>Notification token status</span>
        </div>
        <div class="metric">
          <strong>{{ $isProvider ? 'Provider' : 'Customer' }}</strong>
          <span>Current account role</span>
        </div>
      </div>
    </div>

    <aside class="summary-card">
      <h2>Saved Details</h2>
      <p>A quick snapshot of the profile information currently stored on your account.</p>

      <div class="summary-list">
        <div class="summary-item">
          <span>Name</span>
          <strong>{{ $user->name }}</strong>
        </div>
        <div class="summary-item">
          <span>Phone</span>
          <strong>{{ $user->phone ?: 'Not added' }}</strong>
        </div>
        <div class="summary-item">
          <span>{{ $isProvider ? 'City / Area' : 'Help Type' }}</span>
          <strong>{{ $isProvider ? ($user->city ?: 'Not added') : ($user->help_type ?: 'Not added') }}</strong>
        </div>
        <div class="summary-item">
          <span>Notifications</span>
          <strong>{{ $user->mobile_token ? 'Token saved' : 'Not saved' }}</strong>
        </div>
      </div>
    </aside>
  </section>

  <section class="profile-grid">
    <div class="form-card">
      <div class="section-head">
        <div>
          <h3>Update Profile</h3>
          <p>Change the fields you want and save the profile to keep the dashboard and account data in sync.</p>
        </div>
      </div>

      @if (session('status'))
        <div class="flash-message">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
        <div class="error-box">{{ implode(' ', $errors->all()) }}</div>
      @endif

      <form method="POST" action="{{ route('my.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-grid">
          <div class="field">
            <label for="name">Full Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
          </div>

          <div class="field">
            <label for="phone">Phone Number</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}">
          </div>

          <div class="field full">
            <label for="email">Email Address</label>
            <input id="email" name="email" type="email" value="{{ old('email', $displayEmail) }}" placeholder="Optional">
          </div>

          <div class="field {{ $isProvider ? '' : 'full' }}">
            <label for="city">{{ $isProvider ? 'City / Area' : 'City / Area (Optional)' }}</label>
            <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}">
          </div>

          @if ($isProvider)
            <div class="field">
              <label for="aadhaar_number">Aadhaar Number</label>
              <input id="aadhaar_number" name="aadhaar_number" type="text" inputmode="numeric" maxlength="12" value="{{ old('aadhaar_number', $user->aadhaar_number) }}" required>
            </div>
          @else
            <div class="field">
              <label for="help_type">Preferred Help Type</label>
              <select id="help_type" name="help_type">
                <option value="">Select a service</option>
                @foreach (['Electrician', 'Plumber', 'AC / Cooler Repair', 'Driver'] as $service)
                  <option value="{{ $service }}" {{ old('help_type', $user->help_type) === $service ? 'selected' : '' }}>{{ $service }}</option>
                @endforeach
              </select>
            </div>
          @endif

          <div class="field full">
            <label for="address">Address</label>
            <textarea id="address" name="address">{{ old('address', $user->address) }}</textarea>
          </div>

          <div class="field full">
            <label for="notes">{{ $isProvider ? 'Work Notes / Bio' : 'Request Notes' }}</label>
            <textarea id="notes" name="notes">{{ old('notes', $user->notes) }}</textarea>
          </div>

          <div class="field full">
            <label for="mobile_token">Mobile Notification Token</label>
            <textarea id="mobile_token" name="mobile_token" placeholder="Optional mobile token from your app or device">{{ old('mobile_token', $user->mobile_token) }}</textarea>
            <div class="field-note">You can paste a refreshed mobile token here if your app updates it later.</div>
          </div>
        </div>

        <div class="submit-row">
          <button class="primary-btn" type="submit">Save Profile</button>
        </div>
      </form>
    </div>

    <aside class="token-card">
      <div class="section-head">
        <div>
          <h3>Account Actions</h3>
          <p>Quick shortcuts related to your own account area.</p>
        </div>
      </div>

      <div class="summary-list" style="margin-bottom: 1rem;">
        <div class="summary-item" style="background:#F8FAFC; color:var(--dark);">
          <span>Dashboard</span>
          <strong><a href="{{ route('dashboard') }}" style="color:inherit; text-decoration:none;">Open</a></strong>
        </div>
        <div class="summary-item" style="background:#F8FAFC; color:var(--dark);">
          <span>Professional Profile</span>
          <strong><a href="{{ route('profile') }}" style="color:inherit; text-decoration:none;">View</a></strong>
          </div>
      </div>

      <div class="section-head" style="margin-top: 1rem;">
        <div>
          <h3>Current Token</h3>
          <p>{{ $user->mobile_token_updated_at ? 'Last updated on '.$user->mobile_token_updated_at->format('d M Y, h:i A') : 'No token has been saved yet.' }}</p>
        </div>
      </div>

      <pre>{{ $user->mobile_token ?: 'No mobile notification token stored for this account yet.' }}</pre>

      <div style="margin-top: 1rem;">
        <a href="{{ route('dashboard') }}" class="secondary-link">Back To Dashboard</a>
      </div>

      @if (! $isProvider)
        <div style="margin-top: 0.75rem;">
          <a href="{{ route('register', ['role' => 'provider']) }}" class="primary-btn full-width-action" style="text-decoration:none;">Register as Professional</a>
        </div>
      @endif

      <form action="{{ route('logout') }}" method="POST" style="margin-top: 0.75rem;">
        @csrf
        <button type="submit" class="danger-btn">Logout</button>
      </form>
    </aside>
  </section>
</div>
@endsection
