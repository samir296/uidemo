@extends('layouts.app')

@section('title', 'HomeEase | Login')

@section('content')
<style>
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --text: #0F172A;
  --muted: #64748B;
  --border: #E2E8F0;
}

.login-shell {
  max-width: 1120px;
  margin: 0 auto;
  padding: clamp(1rem, 4vw, 2rem);
}

.login-grid {
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  gap: 1.25rem;
}

.login-card,
.info-card {
  background: rgba(255, 255, 255, 0.96);
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 32px;
  box-shadow: 0 26px 70px rgba(15, 23, 42, 0.06);
}

.login-card,
.info-card { padding: clamp(1.4rem, 4vw, 2rem); }

.eyebrow {
  display: inline-flex;
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

.login-card h1 {
  margin: 0 0 0.75rem;
  color: var(--text);
  font-size: clamp(2rem, 5vw, 3rem);
  line-height: 1.04;
}

.login-card p,
.info-card p {
  margin: 0;
  color: var(--muted);
  line-height: 1.7;
}

.login-form {
  display: grid;
  gap: 1rem;
  margin-top: 1.5rem;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 0.45rem;
}

.field label {
  font-size: 0.78rem;
  font-weight: 800;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.field input {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 18px;
  padding: 0.95rem 1rem;
  font: inherit;
}

.field input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.12);
}

.primary-btn,
.secondary-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 52px;
  border-radius: 18px;
  font-weight: 800;
  text-decoration: none;
}

.primary-btn {
  border: none;
  background: linear-gradient(135deg, var(--primary), #8B5CF6);
  color: #fff;
  cursor: pointer;
}

.secondary-link {
  border: 1px solid var(--border);
  color: var(--text);
  background: #fff;
}

.feedback {
  padding: 0.9rem 1rem;
  border-radius: 16px;
  font-weight: 700;
  margin-top: 1rem;
}

.feedback.error {
  background: #FEF2F2;
  color: #B91C1C;
}

.info-stack {
  display: grid;
  gap: 0.9rem;
  margin-top: 1.2rem;
}

.info-item {
  border: 1px solid var(--border);
  border-radius: 22px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.info-item strong {
  display: block;
  color: var(--text);
  margin-bottom: 0.3rem;
}

@media (max-width: 900px) {
  .login-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="login-shell">
  <div class="login-grid">
    <section class="login-card">
      <div class="eyebrow">Account Access</div>
      <h1>Login to continue your bookings.</h1>
      <p>Use your phone number or email with the password you set during registration.</p>

      @if ($errors->any())
        <div class="feedback error">{{ $errors->first() }}</div>
      @endif

      <form class="login-form" method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="field">
          <label for="login">Phone Number or Email</label>
          <input id="login" name="login" type="text" value="{{ old('login') }}" placeholder="+91 98765 43210 or email@example.com" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Enter your password" required>
        </div>

        <button class="primary-btn" type="submit">Login</button>
        <a href="{{ route('register', ['role' => 'user']) }}" class="secondary-link">Create Customer Account</a>
        <a href="{{ route('register', ['role' => 'provider']) }}" class="secondary-link">Create Provider Account</a>
      </form>
    </section>

    <aside class="info-card">
      <div class="eyebrow">Why Login</div>
      <h2 style="margin:0 0 0.7rem;color:var(--text);font-size:1.7rem;">Track requests, replies, and notifications.</h2>
      <p>Once logged in, customers can send booking requests and providers can accept or reject them from the dashboard.</p>

      <div class="info-stack">
        <div class="info-item">
          <strong>Customers</strong>
          <p>Book a provider, follow request status, and receive booking updates.</p>
        </div>
        <div class="info-item">
          <strong>Providers</strong>
          <p>Review incoming requests and respond from your account dashboard.</p>
        </div>
        <div class="info-item">
          <strong>Notifications</strong>
          <p>Push notifications and in-app updates work only when the account is properly signed in.</p>
        </div>
      </div>
    </aside>
  </div>
</div>
@endsection
