@extends('layouts.app')

@php
  $offering = $selectedOffering;
  $provider = $offering?->user;
  $pricingOptions = \App\Models\ProviderOffering::fixedPricingOptionsFor($offering?->service_type);
  $profileImage = $provider?->profile_image_path
      ? \Illuminate\Support\Facades\Storage::url($provider->profile_image_path)
      : 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=400';
  $serviceTitle = $offering?->offering_name ?: ($offering?->service_type ? \Illuminate\Support\Str::headline($offering->service_type) : 'Home Service');
  $seoTitle = $provider ? "{$serviceTitle} in Mohali | {$provider->name} | Homiease" : 'Homiease | Expert Profile';
  $seoDescription = $provider
      ? "Book {$serviceTitle} in Mohali with {$provider->name}. View service details, pricing guidance, and send a booking request on Homiease."
      : 'Browse trusted home service professionals on Homiease.';
  $canonicalUrl = $offering ? url('/profile?offering='.$offering->id) : url('/profile');
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('meta_keywords', 'electrician profile Mohali, plumber profile Mohali, AC repair Mohali, Homiease provider, local service professional')
@section('canonical', $canonicalUrl)
@section('og_title', $seoTitle)
@section('og_description', $seoDescription)
@section('og_image', $profileImage)
@section('twitter_title', $seoTitle)
@section('twitter_description', $seoDescription)
@section('twitter_image', $profileImage)
@section('structured_data')
@if ($offering && $provider)
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "{{ $serviceTitle }}",
  "provider": {
    "@@type": "Person",
    "name": "{{ $provider->name }}"
  },
  "areaServed": {
    "@@type": "City",
    "name": "{{ $provider->city ?: 'Mohali' }}"
  },
  "description": "{{ $offering->details ?: 'Trusted local service available on Homiease.' }}",
  "url": "{{ $canonicalUrl }}"
}
</script>
@endif
@endsection

@section('content')
@php
  $priceValue = \App\Models\ProviderOffering::fixedPricingSummaryFor($offering?->service_type) ?: ($offering?->price ?: 'Price on request');
  $priceUnit = '';
  $authUser = auth()->user();
  $requestServiceName = $offering?->offering_name ?: \Illuminate\Support\Str::headline($offering?->service_type ?: 'home_service');
  $aboutSummary = \Illuminate\Support\Str::limit(
      trim((string) ($offering?->details ?: 'This professional is available for direct booking through HomeEase.')),
      150
  );
  $serviceNoteSummary = \Illuminate\Support\Str::limit(
      trim((string) ($offering?->notes ?: 'Availability and final timing will be confirmed after your request.')),
      110
  );
@endphp
<style>
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --dark: #0F172A;
  --gray: #64748B;
  --white: #FFFFFF;
  --border: #E2E8F0;
  --success: #10B981;
  --bg: #FAFAFB;
}

.main-content {
  max-width: 1200px;
  margin: clamp(1rem, 5vw, 3rem) auto;
  padding: 0 clamp(1rem, 5vw, 5%);
  display: grid;
  grid-template-columns: 1fr minmax(auto, 380px);
  gap: clamp(1.5rem, 5vw, 2.5rem);
}

.card {
  background: var(--white);
  padding: clamp(1.5rem, 4vw, 2.5rem);
  border-radius: clamp(20px, 4vw, 32px);
  border: 1px solid var(--border);
  margin-bottom: clamp(1rem, 3vw, 1.5rem);
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.profile-hero {
  display: flex;
  gap: clamp(1rem, 4vw, 1.5rem);
  align-items: flex-start;
  margin-bottom: clamp(1rem, 3vw, 2rem);
}

.profile-hero-copy {
  display: grid;
  gap: 0.45rem;
}

.profile-service-title {
  font-size: clamp(2rem, 6vw, 2.8rem);
  font-weight: 900;
  letter-spacing: -1px;
  margin: 0;
  color: var(--dark);
}

.profile-provider-line {
  color: var(--gray);
  font-size: clamp(0.9rem, 2.5vw, 1rem);
  font-weight: 600;
  margin: 0;
}

.profile-provider-line strong {
  color: var(--dark);
}

.profile-img {
  width: clamp(100px, 22vw, 140px);
  height: clamp(100px, 22vw, 140px);
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid var(--primary-light);
  flex-shrink: 0;
}

.verify-tag {
  background: var(--primary-light);
  color: var(--primary);
  padding: clamp(4px, 1vw, 6px) clamp(10px, 2vw, 14px);
  border-radius: 50px;
  font-size: clamp(0.65rem, 2vw, 0.75rem);
  font-weight: 800;
  letter-spacing: 0.5px;
  display: inline-block;
  margin-bottom: 0.75rem;
}

.stats-bar {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  background: #F8FAFC;
  padding: clamp(1rem, 3vw, 1.5rem);
  border-radius: clamp(12px, 3vw, 20px);
  text-align: center;
  gap: 0.5rem;
}

.stat-box { padding: 0.5rem 0; }

.stat-box h4 {
  font-size: clamp(1rem, 4vw, 1.3rem);
  font-weight: 800;
  color: var(--dark);
  margin: 0 0 0.25rem;
}

.stat-box p {
  font-size: clamp(0.65rem, 2vw, 0.8rem);
  color: var(--gray);
  font-weight: 600;
  text-transform: uppercase;
  margin: 0;
}

.section-h {
  font-size: clamp(1.1rem, 3vw, 1.4rem);
  font-weight: 800;
  margin: clamp(1.5rem, 4vw, 2.5rem) 0 clamp(0.75rem, 2vw, 1rem);
}

.about-text {
  color: var(--gray);
  font-size: clamp(0.9rem, 2.5vw, 1rem);
  line-height: 1.7;
}

.skills-list {
  display: flex;
  flex-wrap: wrap;
  gap: clamp(6px, 1.5vw, 10px);
}

.skill-item {
  background: #F1F5F9;
  padding: clamp(6px, 1.5vw, 8px) clamp(12px, 3vw, 20px);
  border-radius: 50px;
  font-size: clamp(0.75rem, 2vw, 0.9rem);
  font-weight: 600;
  color: var(--dark);
}

.profile-highlights {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0.8rem;
  margin-top: 1.15rem;
}

.highlight-card {
  padding: 0.9rem 1rem;
  border: 1px solid var(--border);
  border-radius: 18px;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.highlight-card small {
  display: block;
  margin-bottom: 0.35rem;
  color: var(--gray);
  font-size: 0.68rem;
  font-weight: 800;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.highlight-card strong,
.highlight-card span {
  color: var(--dark);
  font-size: 0.92rem;
  line-height: 1.5;
}

.booking-sidebar {
  background: var(--white);
  padding: clamp(1.5rem, 4vw, 2.2rem);
  border-radius: clamp(20px, 4vw, 32px);
  border: 1px solid var(--border);
  position: sticky;
  top: clamp(5rem, 10vh, 6rem);
  height: fit-content;
  box-shadow: 0 clamp(15px, 4vw, 25px) clamp(40px, 8vw, 50px) -12px rgba(0, 0, 0, 0.06);
}

.price-tag {
  font-size: clamp(1.8rem, 6vw, 2.4rem);
  font-weight: 800;
  margin-bottom: clamp(1rem, 3vw, 1.5rem);
}

.price-tag span {
  font-size: clamp(0.8rem, 2.5vw, 1rem);
  color: var(--gray);
  font-weight: 500;
}

.availability-badge {
  background: #F0FDF4;
  color: #15803D;
  padding: clamp(8px, 2vw, 12px);
  border-radius: clamp(8px, 2vw, 12px);
  font-size: clamp(0.7rem, 2vw, 0.85rem);
  font-weight: 800;
  text-align: center;
  margin-bottom: clamp(1.5rem, 4vw, 2rem);
}

.form-label {
  display: block;
  font-size: clamp(0.7rem, 2vw, 0.85rem);
  font-weight: 800;
  color: var(--gray);
  margin-bottom: clamp(6px, 1.5vw, 10px);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.input-field {
  width: 100%;
  padding: clamp(12px, 3vw, 16px);
  border-radius: clamp(10px, 2.5vw, 14px);
  border: 2px solid var(--border);
  margin-bottom: clamp(1rem, 3vw, 1.5rem);
  outline: none;
  transition: all 0.3s;
  font-size: clamp(0.9rem, 2.5vw, 1rem);
  font-weight: 500;
  font-family: inherit;
}

.input-field:focus {
  border-color: var(--primary);
  background: var(--primary-light);
}

.btn-book-final {
  background: linear-gradient(135deg, var(--primary), #A78BFA);
  color: var(--white);
  width: 100%;
  padding: clamp(14px, 4vw, 20px);
  border-radius: clamp(14px, 3vw, 20px);
  border: none;
  font-weight: 800;
  font-size: clamp(1rem, 3vw, 1.15rem);
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  margin-top: clamp(8px, 2vw, 12px);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 clamp(10px, 3vw, 15px) clamp(25px, 6vw, 35px) rgba(124, 58, 237, 0.3);
}

.note-text {
  text-align: center;
  font-size: clamp(0.65rem, 2vw, 0.8rem);
  color: var(--gray);
  margin-top: clamp(10px, 3vw, 18px);
  line-height: 1.4;
}

.price-options {
  display: grid;
  gap: 0.8rem;
  margin: 1rem 0 1.25rem;
}

.booking-sections {
  display: grid;
  gap: 0.9rem;
}

.booking-section {
  border: 1px solid var(--border);
  border-radius: 20px;
  background: #FCFCFF;
  overflow: hidden;
}

.booking-section summary {
  list-style: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  padding: 1rem 1.05rem;
  cursor: pointer;
}

.booking-section summary::-webkit-details-marker {
  display: none;
}

.booking-section summary strong {
  color: var(--dark);
  font-size: 0.98rem;
}

.booking-section summary span {
  color: var(--gray);
  font-size: 0.84rem;
}

.booking-section[open] summary {
  border-bottom: 1px solid var(--border);
  background: #fff;
}

.booking-section-body {
  padding: 1rem 1rem 0.1rem;
}

.service-preview {
  display: grid;
  gap: 0.7rem;
  padding: 1rem;
  border: 1px solid var(--border);
  border-radius: 18px;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
  margin-bottom: 1rem;
}

.service-preview strong {
  color: var(--dark);
  font-size: 1rem;
}

.service-preview span {
  color: var(--gray);
  font-size: 0.9rem;
  line-height: 1.55;
}

.price-option {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 0.85rem 0.9rem;
  border: 1px solid var(--border);
  border-radius: 16px;
  background: #F8FAFC;
}

.price-option strong {
  display: block;
  color: var(--dark);
}

.price-option span {
  color: var(--gray);
  font-size: 0.92rem;
}

.agreement-box {
  display: flex;
  align-items: flex-start;
  gap: 0.7rem;
  margin-top: 1rem;
  padding: 0.9rem 1rem;
  border-radius: 16px;
  background: #F8FAFC;
  color: var(--dark);
}

.flash {
  padding: 0.95rem 1rem;
  border-radius: 16px;
  margin-bottom: 1rem;
  font-weight: 700;
}

.flash.success {
  background: #ECFDF5;
  color: #047857;
}

.flash.error {
  background: #FEF2F2;
  color: #B91C1C;
}

.privacy-note {
  margin: -0.4rem 0 1rem;
  color: var(--gray);
  font-size: 0.82rem;
  line-height: 1.55;
}

@media (max-width: 992px) {
  .main-content {
    grid-template-columns: 1fr;
    gap: clamp(1rem, 4vw, 2rem);
  }

  .booking-sidebar {
    position: static;
    margin-top: clamp(1rem, 3vw, 2rem);
  }
}

@media (max-width: 480px) {
  .main-content {
    margin: 0.75rem auto 1.5rem;
    padding: 0 0.75rem;
    gap: 0.9rem;
  }

  .card,
  .booking-sidebar {
    padding: 1rem;
    border-radius: 20px;
  }

  .profile-hero {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }

  .profile-hero h1 {
    font-size: 1.65rem !important;
    line-height: 1.15;
  }

  .profile-provider-line {
    font-size: 0.9rem !important;
  }

  .stats-bar {
    grid-template-columns: repeat(2, 1fr);
    padding: 0.85rem;
  }

  .profile-highlights {
    grid-template-columns: 1fr;
  }

  .stat-box h4 {
    font-size: 0.95rem;
  }

  .stat-box p {
    font-size: 0.62rem;
  }

  .section-h {
    font-size: 1rem;
    margin: 1.1rem 0 0.7rem;
  }

  .about-text,
  .review-text,
  .service-preview span,
  .privacy-note,
  .note-text {
    font-size: 0.82rem;
    line-height: 1.5;
  }

  .service-preview strong,
  .booking-section summary strong {
    font-size: 0.9rem;
  }

  .booking-section summary span {
    font-size: 0.76rem;
  }

  .booking-section summary {
    padding: 0.9rem;
  }

  .booking-section-body {
    padding: 0.9rem 0.9rem 0.1rem;
  }

  .price-tag {
    font-size: 1.55rem;
    margin-bottom: 0.9rem;
  }

  .price-tag span,
  .availability-badge {
    font-size: 0.74rem;
  }

  .form-label {
    font-size: 0.66rem;
    margin-bottom: 0.45rem;
  }

  .input-field {
    padding: 0.8rem 0.85rem;
    font-size: 0.88rem;
    margin-bottom: 0.9rem;
  }

  .price-option {
    padding: 0.75rem 0.8rem;
  }

  .price-option strong {
    font-size: 0.87rem;
  }

  .price-option span,
  .agreement-box span {
    font-size: 0.8rem;
  }

  .btn-book-final {
    padding: 0.9rem 1rem;
    font-size: 0.9rem;
    letter-spacing: 0.04em;
  }
}
</style>

<div class="main-content">
  @if (! $offering || ! $provider)
    <main class="card" style="grid-column: 1 / -1;">
      <h1 style="margin-top:0;">Provider not found</h1>
      <p class="about-text">Please go back to the home or list page and open a provider card again.</p>
    </main>
  @else
    <main>
      <section class="card">
        <div class="profile-hero">
          <img src="{{ $profileImage }}" class="profile-img" alt="{{ $provider->name }}">
          <div class="profile-hero-copy">
            <span class="verify-tag">VERIFIED EXPERT</span>
            <h1 class="profile-service-title">{{ $offering->offering_name ?: \Illuminate\Support\Str::headline($offering->service_type) }}</h1>
            <p class="profile-provider-line"><strong>{{ $provider->name }}</strong> • {{ $provider->city ?: 'Nearby provider' }}</p>
          </div>
        </div>

        <div class="stats-bar">
          <div class="stat-box">
            <h4>{{ $offering->experience_years ?: 1 }}+</h4>
            <p>Years</p>
          </div>
          <div class="stat-box" style="border-left: 1px solid #E2E8F0; border-right: 1px solid #E2E8F0;">
            <h4>{{ $provider->providerOfferings()->count() }}</h4>
            <p>Services</p>
          </div>
          <div class="stat-box">
            <h4>{{ $provider->mobile_token ? 'Live' : 'Web' }}</h4>
            <p>Notify</p>
          </div>
        </div>

        <h3 class="section-h">About the Expert</h3>
        <p class="about-text">
          {{ $aboutSummary }}
        </p>

        <div class="profile-highlights">
          <div class="highlight-card">
            <small>Service</small>
            <strong>{{ $offering->offering_name ?: \Illuminate\Support\Str::headline($offering->service_type) }}</strong>
          </div>
          <div class="highlight-card">
            <small>Timing</small>
            <span>{{ $offering->timing ?: 'Schedule shared after request' }}</span>
          </div>
          <div class="highlight-card">
            <small>Service note</small>
            <span>{{ $serviceNoteSummary }}</span>
          </div>
          <div class="highlight-card">
            <small>Area</small>
            <span>{{ $provider->city ?: 'Mohali and nearby areas' }}</span>
          </div>
        </div>

        <h3 class="section-h">Expertise & Skills</h3>
        <div class="skills-list">
          <div class="skill-item">{{ \Illuminate\Support\Str::headline($offering->service_type) }}</div>
          @if ($offering->service_subtype)
            <div class="skill-item">{{ \Illuminate\Support\Str::headline($offering->service_subtype) }}</div>
          @endif
          @if ($offering->service_mode)
            <div class="skill-item">{{ \Illuminate\Support\Str::headline($offering->service_mode) }}</div>
          @endif
          @if (filled(data_get($offering->service_attributes, 'work_option')))
            <div class="skill-item">{{ data_get($offering->service_attributes, 'work_option') }}</div>
          @endif
          <div class="skill-item">{{ $provider->city ?: 'Local service' }}</div>
        </div>
      </section>
    </main>

    <aside>
      <div class="booking-sidebar">
        @if (session('booking_status'))
          <div class="flash success">{{ session('booking_status') }}</div>
        @endif

        @if ($errors->any())
          <div class="flash error">{{ $errors->first() }}</div>
        @endif

        <div class="price-tag">{{ $priceValue }} <span>{{ $priceUnit }}</span></div>

        <div class="availability-badge">
          AVAILABLE FOR BOOKING REQUEST
        </div>

        @auth
          <form method="POST" action="{{ route('booking.requests.store') }}">
            @csrf
            <input type="hidden" name="provider_offering_id" value="{{ $offering->id }}">

            <div class="service-preview">
              <strong>{{ $requestServiceName }}</strong>
              <span>This request will only be sent for the service items this provider has already listed. Phone numbers stay private inside HomeEase.</span>
            </div>

            <div class="booking-sections">
              <details class="booking-section" open>
                <summary>
                  <div>
                    <strong>1. Choose service items</strong>
                    <span>Select the exact work you need</span>
                  </div>
                  <span>{{ $pricingOptions ? count($pricingOptions).' options' : 'Included' }}</span>
                </summary>
                <div class="booking-section-body">
                  @if ($pricingOptions)
                    <div class="price-options">
                      @foreach ($pricingOptions as $option)
                        <label class="price-option" for="service-item-{{ $loop->index }}">
                          <input
                            id="service-item-{{ $loop->index }}"
                            type="checkbox"
                            name="selected_service_items[]"
                            value="{{ $option['label'] }}"
                            {{ in_array($option['label'], old('selected_service_items', []), true) ? 'checked' : '' }}
                          >
                          <div>
                            <strong>{{ $option['label'] }}</strong>
                            <span>{{ $option['price'] }}</span>
                          </div>
                        </label>
                      @endforeach
                    </div>

                    <label class="agreement-box" for="price-agreement">
                      <input
                        id="price-agreement"
                        type="checkbox"
                        name="price_agreement"
                        value="1"
                        {{ old('price_agreement') ? 'checked' : '' }}
                      >
                      <span>I have checked the selected service prices and agree to continue with these fixed rates.</span>
                    </label>
                  @else
                    <p class="privacy-note">This provider has already shared pricing guidance for the selected service.</p>
                  @endif
                </div>
              </details>

              <details class="booking-section" open>
                <summary>
                  <div>
                    <strong>2. Schedule visit</strong>
                    <span>Add the day and time that works for you</span>
                  </div>
                  <span>Required</span>
                </summary>
                <div class="booking-section-body">
                  <label class="form-label">Booking Date</label>
                  <input type="date" class="input-field" name="scheduled_date" value="{{ old('scheduled_date') }}">

                  <label class="form-label">Preferred Time</label>
                  <input type="text" class="input-field" name="scheduled_time" placeholder="Tomorrow 5 PM or Morning 9-11 AM" value="{{ old('scheduled_time') }}">
                </div>
              </details>

              <details class="booking-section">
                <summary>
                  <div>
                    <strong>3. Address and contact</strong>
                    <span>Used privately for this booking request</span>
                  </div>
                  <span>Private</span>
                </summary>
                <div class="booking-section-body">
                  <label class="form-label">Your Phone Number</label>
                  <input type="tel" class="input-field" name="customer_phone" placeholder="+91 00000 00000" value="{{ old('customer_phone', $authUser?->phone) }}">
                  <p class="privacy-note">We keep this number private in the app request flow instead of showing it in booking cards.</p>

                  <label class="form-label">Service Address</label>
                  <textarea class="input-field" name="address" placeholder="Enter your service address">{{ old('address', $authUser?->address) }}</textarea>

                  <label class="form-label">City / Area</label>
                  <input type="text" class="input-field" name="city" placeholder="Mohali, Chandigarh, etc." value="{{ old('city', $authUser?->city) }}">
                </div>
              </details>

              <details class="booking-section">
                <summary>
                  <div>
                    <strong>4. Extra notes</strong>
                    <span>Optional instructions for easier service</span>
                  </div>
                  <span>Optional</span>
                </summary>
                <div class="booking-section-body">
                  <label class="form-label">Notes</label>
                  <textarea class="input-field" name="notes" placeholder="Add your exact requirement, floor, landmark, family size, or any special note">{{ old('notes') }}</textarea>
                </div>
              </details>
            </div>

            <div style="margin-top: 1rem; padding: clamp(1rem, 3vw, 1.5rem); background: #F8FAFC; border-radius: clamp(12px, 3vw, 16px);">
              <div style="display: flex; justify-content: space-between; font-size: clamp(0.85rem, 2.5vw, 1rem); margin-bottom: 0.5rem;">
                <span>Pricing</span>
                <span>Customer agrees to selected items</span>
              </div>
              <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: clamp(1rem, 3vw, 1.2rem); color: var(--primary);">
                <span>Status</span>
                <span>Pending approval</span>
              </div>
            </div>

            <button class="btn-book-final" type="submit">Request Booking</button>
            <p class="note-text">You won't be charged yet. The provider receives an in-app notification and a push notification when a mobile token is available.</p>
          </form>
        @else
          <a href="{{ route('register', ['role' => 'user']) }}" class="btn-book-final" style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">Login To Request</a>
          <p class="note-text">Create a customer account first, then you can send booking requests to providers.</p>
        @endauth
      </div>
    </aside>
  @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const dateField = document.querySelector('.input-field[type="date"]');

  if (dateField && !dateField.value) {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    dateField.value = tomorrow.toISOString().split('T')[0];
  }
});
</script>
@endsection
