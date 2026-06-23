@extends('layouts.app')

@section('title', 'HomiEase | My Requests')

@section('content')
@php
  $user = auth()->user();
  $bookingRequests = $bookingRequests ?? collect();
@endphp
<style>
body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 25%),
    linear-gradient(180deg, #FCFBFF 0%, #F8FAFC 100%);
}

.requests-shell {
  max-width: 980px;
  margin: 0 auto;
  padding: 1rem;
}

.panel {
  background: rgba(255,255,255,0.95);
  border: 1px solid rgba(226,232,240,0.96);
  border-radius: 28px;
  padding: clamp(1rem, 4vw, 1.4rem);
  box-shadow: 0 22px 55px rgba(15,23,42,0.06);
}

.request-list {
  display: grid;
  gap: 1rem;
  margin-top: 1rem;
}

.request-card {
  border: 1px solid #E2E8F0;
  border-radius: 22px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.request-head {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  align-items: flex-start;
  margin-bottom: 0.7rem;
}

.request-head strong {
  display: block;
  color: #0F172A;
  margin-bottom: 0.25rem;
}

.request-card p {
  margin: 0;
  color: #64748B;
  line-height: 1.55;
}

.status {
  padding: 0.45rem 0.8rem;
  border-radius: 999px;
  font-size: 0.76rem;
  font-weight: 800;
}

.status.live {
  background: #ECFDF5;
  color: #047857;
}

.status.pending {
  background: #FEF3C7;
  color: #92400E;
}

.meta-row {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
  margin-top: 0.8rem;
}

.meta-row span {
  padding: 0.45rem 0.75rem;
  border-radius: 999px;
  background: #F5F3FF;
  color: #7C3AED;
  font-size: 0.76rem;
  font-weight: 800;
}

.provider-form {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
  margin-top: 0.9rem;
}

.provider-form button {
  border: none;
  border-radius: 12px;
  padding: 0.7rem 0.95rem;
  font-weight: 800;
  cursor: pointer;
}

.provider-form .accept { background: #7C3AED; color: #fff; }
.provider-form .reject { background: #FFF1F2; color: #BE123C; }

.flash-banner {
  margin-top: 1rem;
  padding: 0.9rem 1rem;
  border-radius: 18px;
  background: #ECFDF5;
  color: #047857;
  font-weight: 700;
}
</style>

<div class="requests-shell">
  <div class="panel">
    <h1 style="margin:0;color:#0F172A;">My Requests</h1>
    <p style="color:#64748B;line-height:1.6;">
      {{ $user?->role === 'provider' ? 'Review and respond to customer booking requests.' : 'Track active and past service requests in one clean mobile list.' }}
    </p>

    @if (session('booking_status'))
      <div class="flash-banner">{{ session('booking_status') }}</div>
    @endif

    <div class="request-list">
      @forelse ($bookingRequests as $bookingRequest)
        <div class="request-card">
          <div class="request-head">
            <div>
              <strong>{{ $bookingRequest->service_name }}</strong>
              <p>
                {{ $user?->role === 'provider'
                  ? 'Requested by '.$bookingRequest->customer?->name
                  : 'Provider: '.$bookingRequest->provider?->name }}
              </p>
            </div>
            <span class="status {{ in_array($bookingRequest->status, ['accepted', 'completed'], true) ? 'live' : 'pending' }}">{{ ucfirst($bookingRequest->status) }}</span>
          </div>
          <div class="meta-row">
            <span>{{ $user?->role === 'provider' ? ($bookingRequest->city ?: 'Area shared in request') : 'Selected service confirmed' }}</span>
            <span>{{ $bookingRequest->scheduled_date?->format('d M Y') }}</span>
            <span>{{ $bookingRequest->scheduled_time }}</span>
            <span>{{ $bookingRequest->requested_price ? 'Rs. '.number_format((float) $bookingRequest->requested_price, 0) : 'Fixed rates agreed' }}</span>
          </div>
          @if ($bookingRequest->notes)
            <p style="margin-top:0.8rem;">{{ $bookingRequest->notes }}</p>
          @endif

          @if ($user?->role === 'provider' && in_array($bookingRequest->status, ['pending', 'countered'], true))
            <div class="provider-form">
              <form method="POST" action="{{ route('booking.requests.update-status', $bookingRequest) }}">
                @csrf
                <input type="hidden" name="status" value="accepted">
                <button type="submit" class="accept">Accept</button>
              </form>
              <form method="POST" action="{{ route('booking.requests.update-status', $bookingRequest) }}">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="reject">Reject</button>
              </form>
            </div>
          @endif
        </div>
      @empty
        <div class="request-card">
          <div class="request-head">
            <div>
              <strong>No requests yet</strong>
              <p>{{ $user?->role === 'provider' ? 'Customer booking requests will appear here.' : 'Open a provider profile and send your first booking request.' }}</p>
            </div>
            <span class="status pending">Waiting</span>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection
