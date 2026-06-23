@extends('layouts.app')

@section('title', 'HomeEase | Notifications')

@section('content')
@php
  $notificationsFeed = $notificationsFeed ?? collect();
@endphp
<style>
body {
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 25%),
    linear-gradient(180deg, #FCFBFF 0%, #F8FAFC 100%);
}

.page-shell {
  max-width: 760px;
  margin: 0 auto;
  padding: 1rem;
}

.app-card {
  background: rgba(255,255,255,0.95);
  border: 1px solid rgba(226,232,240,0.96);
  border-radius: 28px;
  padding: clamp(1rem, 4vw, 1.4rem);
  box-shadow: 0 22px 55px rgba(15,23,42,0.06);
}

.head h1 { margin: 0 0 0.4rem; color: #0F172A; }
.head p, .note p { color: #64748B; line-height: 1.6; }

.feed { display: grid; gap: 0.9rem; margin-top: 1rem; }

.item {
  border: 1px solid #E2E8F0;
  border-radius: 20px;
  padding: 1rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.item strong {
  display: block;
  margin-bottom: 0.25rem;
  color: #0F172A;
}

.meta {
  display: inline-flex;
  margin-top: 0.7rem;
  padding: 0.4rem 0.7rem;
  border-radius: 999px;
  background: #F5F3FF;
  color: #7C3AED;
  font-size: 0.76rem;
  font-weight: 800;
}
</style>

<div class="page-shell">
  <div class="app-card">
    <div class="head">
      <h1>Notifications</h1>
      <p>Booking updates, provider replies, and account reminders show here in one clean feed.</p>
    </div>

    <div class="feed">
      @forelse ($notificationsFeed as $notification)
        <div class="item">
          <strong>{{ $notification->title }}</strong>
          <p>{{ $notification->body }}</p>
          <span class="meta">{{ $notification->created_at?->diffForHumans() ?: 'Just now' }}</span>
        </div>
      @empty
        <div class="item">
          <strong>No notifications yet</strong>
          <p>When you send or receive booking requests, the updates will appear here.</p>
          <span class="meta">Waiting</span>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection
