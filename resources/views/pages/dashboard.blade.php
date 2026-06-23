@extends('layouts.app')

@section('title', 'HomeEase | Dashboard')

@section('content')
@php
  $user = auth()->user();
  $initials = collect(explode(' ', trim((string) ($user?->name ?? 'HomeEase User'))))
      ->filter()
      ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
      ->take(2)
      ->implode('');
  $role = $user?->role ?? 'user';
  $providerOfferings = $user?->providerOfferings ?? collect();
  $incomingRequests = $user?->providerBookingRequests ?? collect();
  $sentRequests = $user?->customerBookingRequests ?? collect();
  $latestNotifications = $user?->appNotifications?->take(3) ?? collect();
  $memberSince = $user?->created_at?->format('F Y') ?? now()->format('F Y');
  $helpType = $user?->help_type ?: 'No service selected yet';
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
  --success: #10B981;
  --warning-bg: #FEF3C7;
  --warning-text: #92400E;
}

body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 28%),
    linear-gradient(180deg, #FCFBFF 0%, var(--bg) 100%);
}

.dashboard-shell {
  max-width: 1240px;
  margin: 0 auto;
  padding: clamp(1rem, 4vw, 2rem);
}

.dashboard-hero {
  display: grid;
  grid-template-columns: minmax(0, 1.25fr) minmax(280px, 0.75fr);
  gap: 1.25rem;
  align-items: stretch;
}

.hero-card,
.summary-card,
.panel-card,
.profile-card,
.empty-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 30px;
  box-shadow: 0 24px 60px rgba(15, 23, 42, 0.06);
}

.hero-card {
  padding: clamp(1.4rem, 4vw, 2.1rem);
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
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
  margin: 0 0 0.6rem;
  font-size: clamp(1.8rem, 4.5vw, 2.8rem);
  line-height: 1.05;
  letter-spacing: -0.05em;
  color: var(--dark);
}

.hero-copy p {
  margin: 0;
  max-width: 58ch;
  color: var(--gray);
  line-height: 1.7;
  font-size: 0.98rem;
}

.user-chip {
  display: inline-flex;
  align-items: center;
  gap: 0.85rem;
  padding: 0.8rem 1rem;
  border-radius: 22px;
  background: linear-gradient(135deg, #ffffff 0%, #f8f5ff 100%);
  border: 1px solid rgba(124, 58, 237, 0.12);
  min-width: 220px;
}

.avatar {
  width: 52px;
  height: 52px;
  border-radius: 18px;
  background: linear-gradient(135deg, var(--primary), #A78BFA);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 1rem;
  letter-spacing: 0.05em;
  flex-shrink: 0;
}

.user-chip strong {
  display: block;
  color: var(--dark);
  font-size: 0.98rem;
}

.user-chip span {
  color: var(--gray);
  font-size: 0.86rem;
}

.metric-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 0.9rem;
  margin-top: 1.4rem;
}

.metric-card {
  border: 1px solid var(--border);
  border-radius: 24px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.metric-card strong {
  display: block;
  font-size: 1.4rem;
  color: var(--dark);
  margin-bottom: 0.3rem;
}

.metric-card span {
  color: var(--gray);
  font-size: 0.85rem;
  line-height: 1.5;
}

.summary-card {
  padding: clamp(1.4rem, 4vw, 2rem);
  background: linear-gradient(145deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: #fff;
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
  font-size: 1.55rem;
  margin: 0 0 0.55rem;
}

.summary-card p {
  margin: 0 0 1.2rem;
  opacity: 0.9;
  line-height: 1.65;
}

.summary-list {
  display: grid;
  gap: 0.85rem;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  padding: 0.95rem 1rem;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.12);
}

.summary-item span {
  font-size: 0.88rem;
}

.summary-item strong {
  font-size: 0.96rem;
}

.dashboard-grid {
  display: grid;
  grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
  gap: 1.25rem;
  margin-top: 1.25rem;
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
  color: var(--dark);
  font-size: 1.25rem;
}

.section-head p {
  margin: 0;
  color: var(--gray);
  line-height: 1.6;
  font-size: 0.92rem;
}

.action-row {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.action-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.85rem 1rem;
  border-radius: 16px;
  font-weight: 800;
  text-decoration: none;
  border: 1px solid var(--border);
}

.action-link.primary {
  background: linear-gradient(135deg, var(--primary), #8B5CF6);
  color: #fff;
  border: none;
}

.action-link.secondary {
  background: #fff;
  color: var(--dark);
}

.panel-card {
  padding: 1.3rem;
}

.activity-list {
  display: grid;
  gap: 0.95rem;
}

.activity-item {
  border: 1px solid var(--border);
  border-radius: 24px;
  padding: 1rem;
  display: grid;
  grid-template-columns: auto 1fr auto;
  gap: 0.95rem;
  align-items: center;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.activity-badge {
  width: 54px;
  height: 54px;
  border-radius: 18px;
  background: var(--primary-light);
  color: var(--primary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 0.92rem;
}

.activity-copy strong {
  display: block;
  color: var(--dark);
  font-size: 1rem;
  margin-bottom: 0.2rem;
}

.activity-copy span {
  display: block;
  color: var(--gray);
  font-size: 0.86rem;
  line-height: 1.55;
}

.status-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 36px;
  padding: 0.55rem 0.85rem;
  border-radius: 999px;
  font-size: 0.76rem;
  font-weight: 800;
  white-space: nowrap;
}

.status-pill.success {
  background: #ECFDF5;
  color: #047857;
}

.status-pill.warning {
  background: var(--warning-bg);
  color: var(--warning-text);
}

.profile-card {
  padding: 1.3rem;
}

.profile-stack {
  display: grid;
  gap: 0.85rem;
}

.profile-line {
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 0.95rem 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.profile-line small {
  display: block;
  color: var(--gray);
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  margin-bottom: 0.4rem;
}

.profile-line strong,
.profile-line span {
  color: var(--dark);
  line-height: 1.55;
  font-size: 0.95rem;
}

.empty-card {
  padding: 1.35rem;
}

.empty-card p {
  color: var(--gray);
  line-height: 1.65;
  margin: 0;
}

.flash-banner {
  margin-bottom: 1rem;
  padding: 0.9rem 1rem;
  border-radius: 18px;
  background: #ECFDF5;
  color: #047857;
  font-weight: 700;
}

@media (max-width: 1024px) {
  .dashboard-hero,
  .dashboard-grid,
  .metric-grid {
    grid-template-columns: 1fr;
  }

  .hero-top {
    flex-direction: column;
  }
}

@media (max-width: 640px) {
  .dashboard-shell {
    padding: 0.85rem 0.85rem 5.5rem;
  }

  .hero-card,
  .summary-card,
  .panel-card,
  .profile-card,
  .empty-card {
    border-radius: 24px;
  }

  .hero-card,
  .summary-card,
  .panel-card,
  .profile-card,
  .empty-card {
    padding: 1rem;
  }

  .hero-copy h1 {
    font-size: 1.9rem;
  }

  .user-chip {
    width: 100%;
    min-width: 0;
  }

  .metric-grid {
    gap: 0.7rem;
  }

  .activity-item {
    grid-template-columns: 1fr;
    align-items: flex-start;
  }

  .activity-badge {
    width: 48px;
    height: 48px;
    border-radius: 16px;
  }

  .action-row,
  .action-link {
    width: 100%;
  }

  .action-link {
    text-align: center;
  }
}
</style>

<div class="dashboard-shell">
  @if (session('booking_status'))
    <div class="flash-banner">{{ session('booking_status') }}</div>
  @endif

  <section class="dashboard-hero">
    <div class="hero-card">
      <div class="hero-badge">{{ $role === 'provider' ? 'Provider Dashboard' : 'Customer Dashboard' }}</div>

      <div class="hero-top">
        <div class="hero-copy">
          <h1>
            {{ $role === 'provider' ? 'Welcome back, '.$user->name.'.' : 'Hi '.$user->name.', your HomeEase account is ready.' }}
          </h1>
          <p>
            {{ $role === 'provider'
              ? 'Your dashboard now uses the real registration data you submitted. Review your contact details, service offerings, and mobile notification token status from one place.'
              : 'Your dashboard now pulls from the real signup data you saved. You can quickly review your service preference, contact details, and notification setup here.' }}
          </p>
        </div>

        <div class="user-chip">
          <div class="avatar">{{ $initials ?: 'HE' }}</div>
          <div>
            <strong>{{ $user->name }}</strong>
            <span>{{ $user->email && !str_ends_with($user->email, '@homeease.local') ? $user->email : ($user->phone ?: 'No phone added yet') }}</span>
          </div>
        </div>
      </div>

      <div class="metric-grid">
        <div class="metric-card">
          <strong>{{ $role === 'provider' ? $incomingRequests->where('status', 'pending')->count() : $sentRequests->count() }}</strong>
          <span>{{ $role === 'provider' ? 'Pending booking requests' : 'Booking requests sent' }}</span>
        </div>
        <div class="metric-card">
          <strong>{{ $user->mobile_token ? 'Ready' : 'Pending' }}</strong>
          <span>Mobile notification token {{ $user->mobile_token ? 'saved successfully' : 'not available yet' }}</span>
        </div>
        <div class="metric-card">
          <strong>{{ $memberSince }}</strong>
          <span>Member since your registration was completed</span>
        </div>
      </div>
    </div>

    <aside class="summary-card">
      <h2>{{ $role === 'provider' ? 'Account Summary' : 'Profile Snapshot' }}</h2>
      <p>{{ $role === 'provider' ? 'A quick look at the provider profile details currently saved in your account.' : 'A quick look at the customer profile details currently saved in your account.' }}</p>

      <div class="summary-list">
        <div class="summary-item">
          <span>Role</span>
          <strong>{{ ucfirst($role) }}</strong>
        </div>
        <div class="summary-item">
          <span>Phone</span>
          <strong>{{ $user->phone ?: 'Not added' }}</strong>
        </div>
        <div class="summary-item">
          <span>{{ $role === 'provider' ? 'City / Area' : 'Preferred help' }}</span>
          <strong>{{ $role === 'provider' ? ($user->city ?: 'Not added') : $helpType }}</strong>
        </div>
        <div class="summary-item">
          <span>Notifications</span>
          <strong>{{ $user->mobile_token ? 'Token saved' : 'Token missing' }}</strong>
        </div>
      </div>
    </aside>
  </section>

  <section class="dashboard-grid">
    <div>
      <div class="panel-card">
        <div class="section-head">
          <div>
            <h3>{{ $role === 'provider' ? 'Incoming Booking Requests' : 'Your Booking Requests' }}</h3>
            <p>{{ $role === 'provider' ? 'Accept, reject, or counter new customer requests from here.' : 'Track the requests you have already sent to providers.' }}</p>
          </div>
        </div>

        @if ($role === 'provider' && $incomingRequests->isNotEmpty())
          <div class="activity-list">
            @foreach ($incomingRequests->take(6) as $bookingRequest)
              <div class="activity-item">
                <div class="activity-badge">{{ strtoupper(substr($bookingRequest->service_type, 0, 2)) }}</div>
                <div class="activity-copy">
                  <strong>{{ $bookingRequest->customer?->name }} requested {{ $bookingRequest->service_name }}</strong>
                  <span>{{ $bookingRequest->city ?: 'Area shared privately in request' }}</span>
                  <span>{{ $bookingRequest->scheduled_date?->format('d M Y') }} | {{ $bookingRequest->scheduled_time }}</span>
                </div>
                <div style="display:grid; gap:0.5rem;">
                  <span class="status-pill {{ $bookingRequest->status === 'pending' ? 'warning' : 'success' }}">{{ ucfirst($bookingRequest->status) }}</span>
                  @if (in_array($bookingRequest->status, ['pending', 'countered'], true))
                    <form method="POST" action="{{ route('booking.requests.update-status', $bookingRequest) }}" style="display:grid; gap:0.45rem;">
                      @csrf
                      <input type="hidden" name="status" value="accepted">
                      <button type="submit" class="action-link primary" style="padding:0.6rem 0.75rem;">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('booking.requests.update-status', $bookingRequest) }}" style="display:grid; gap:0.45rem;">
                      @csrf
                      <input type="hidden" name="status" value="rejected">
                      <button type="submit" class="action-link secondary" style="padding:0.6rem 0.75rem;">Reject</button>
                    </form>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @elseif ($role === 'user' && $sentRequests->isNotEmpty())
          <div class="activity-list">
            @foreach ($sentRequests->take(6) as $bookingRequest)
              <div class="activity-item">
                <div class="activity-badge">{{ strtoupper(substr($bookingRequest->service_type, 0, 2)) }}</div>
                <div class="activity-copy">
                  <strong>{{ $bookingRequest->service_name }}</strong>
                  <span>{{ $bookingRequest->provider?->name }}</span>
                  <span>{{ $bookingRequest->scheduled_date?->format('d M Y') }} | {{ $bookingRequest->scheduled_time }}</span>
                </div>
                <span class="status-pill {{ in_array($bookingRequest->status, ['accepted', 'completed'], true) ? 'success' : 'warning' }}">{{ ucfirst($bookingRequest->status) }}</span>
              </div>
            @endforeach
          </div>
        @else
          <div class="empty-card">
            <p>No booking requests are available yet. Open a provider profile and send your first request, or wait for customers to contact you if you are a provider.</p>
          </div>
        @endif
      </div>
    </div>

    <aside class="profile-card">
      <div class="section-head">
        <div>
          <h3>Profile Details</h3>
          <p>These are the fields currently stored for this signed-in account.</p>
        </div>
      </div>

      <div class="profile-stack">
        <div class="profile-line">
          <small>Name</small>
          <strong>{{ $user->name }}</strong>
        </div>

        <div class="profile-line">
          <small>Email</small>
          <span>{{ $user->email && !str_ends_with($user->email, '@homeease.local') ? $user->email : 'Auto-generated local account email' }}</span>
        </div>

        <div class="profile-line">
          <small>Phone</small>
          <span>{{ $user->phone ?: 'Not added yet' }}</span>
        </div>

        <div class="profile-line">
          <small>Address</small>
          <span>{{ $user->address ?: 'Not added yet' }}</span>
        </div>

        @if ($role === 'provider')
          <div class="profile-line">
            <small>Aadhaar</small>
            <span>{{ $user->aadhaar_number ? 'Ending in '.substr($user->aadhaar_number, -4) : 'Not added yet' }}</span>
          </div>
        @endif

        <div class="profile-line">
          <small>Notification Token</small>
          <span>{{ $user->mobile_token ? 'Saved on '.$user->mobile_token_updated_at?->format('d M Y, h:i A') : 'No mobile token saved yet' }}</span>
        </div>
      </div>

      <div class="action-row" style="margin-top: 1rem;">
        <a href="{{ route('my.requests') }}" class="action-link primary">{{ $role === 'provider' ? 'Open All Requests' : 'Track My Requests' }}</a>
        <a href="{{ route('my.profile') }}" class="action-link secondary">Open My Profile</a>
      </div>

      @if ($latestNotifications->isNotEmpty())
        <div class="section-head" style="margin-top:1.25rem;">
          <div>
            <h3>Latest Notifications</h3>
            <p>Recent booking and account updates.</p>
          </div>
        </div>
        <div class="profile-stack">
          @foreach ($latestNotifications as $notification)
            <div class="profile-line">
              <small>{{ ucfirst(str_replace('_', ' ', $notification->type)) }}</small>
              <strong>{{ $notification->title }}</strong>
              <span>{{ $notification->body }}</span>
            </div>
          @endforeach
        </div>
      @endif
    </aside>
  </section>
</div>
@endsection
