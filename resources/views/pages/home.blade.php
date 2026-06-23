@extends('layouts.app')

@section('title', 'Homiease | Book Trusted Emergency Home Services In Mohali')
@section('meta_description', 'Book trusted emergency home services in Mohali with Homiease. Fast electrician, plumber and AC repair help in 30 to 60 minutes with verified workers and no hidden charges.')
@section('meta_keywords', 'Homiease Mohali, emergency electrician Mohali, plumber Mohali, AC repair Mohali, trusted home services Mohali, fast home service Mohali')
@section('canonical', 'https://homiease.in/')
@section('og_title', 'Homiease | Trusted Emergency Home Services In Mohali')
@section('og_description', 'Electrician, plumber and AC repair in Mohali in 30 to 60 minutes. Verified workers, quick service and no hidden charges.')
@section('twitter_title', 'Homiease | Emergency Home Services In Mohali')
@section('twitter_description', 'Book trusted electrician, plumber and AC repair services in Mohali with fast response and no hidden charges.')
@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "Homiease",
  "url": "https://homiease.in/",
  "description": "Book trusted emergency home services in Mohali with fast electrician, plumber and AC repair support.",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "https://homiease.in/list?search={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "Homiease",
  "url": "https://homiease.in/",
  "image": "{{ asset('logo.png') }}",
  "telephone": "+91-00000-00000",
  "areaServed": {
    "@@type": "City",
    "name": "Mohali"
  },
  "address": {
    "@@type": "PostalAddress",
    "addressLocality": "Mohali",
    "addressCountry": "IN"
  },
  "description": "Trusted emergency home services in Mohali for electrician, plumber and AC repair bookings with quick response and transparent pricing.",
  "sameAs": [
    "https://homiease.in/"
  ]
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {
      "@@type": "Question",
      "name": "How fast can I book emergency home service in Mohali?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Homiease is positioned for quick emergency booking support in Mohali, with service-focused messaging around 30 to 60 minute response."
      }
    },
    {
      "@@type": "Question",
      "name": "Which services can I book on Homiease?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "You can browse electrician, plumber, AC and cooler repair, and driver-related service offerings depending on provider availability."
      }
    },
    {
      "@@type": "Question",
      "name": "Are there hidden charges on Homiease?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "The website messaging highlights transparent pricing and no hidden charges to help users book with more confidence."
      }
    }
  ]
}
</script>
@endsection

@section('content')
@php
  $targetServiceTypes = ['electrician', 'plumber', 'ac_cooler_repair', 'driver'];
  $visibleOfferings = ($offerings ?? collect())->whereIn('service_type', $targetServiceTypes)->values();
  $popularOfferings = $visibleOfferings->take(3);
  $serviceLabels = [
      'all' => 'All Services',
      'electrician' => 'Electricians',
      'plumber' => 'Plumbers',
      'ac_cooler_repair' => 'AC / Cooler Repair',
      'driver' => 'Drivers',
  ];

  $formatPrice = static function ($offering): array {
      $fixedSummary = \App\Models\ProviderOffering::fixedPricingSummaryFor($offering->service_type);
      $display = $fixedSummary ?: ($offering->price ?: 'Price on request');
      $unit = '';

      return [$display, $unit];
  };

  $priceTeaser = static function ($offering): string {
      return match ($offering->service_type) {
          'electrician' => 'Visit fee from Rs. 99',
          'plumber' => 'Visit fee from Rs. 99',
          'ac_cooler_repair' => 'Service checks from Rs. 149',
          'driver' => str_contains(strtolower((string) $offering->service_subtype), 'with car')
              ? 'With car options available'
              : 'Driver only from Rs. 800',
          default => 'Transparent fixed rates',
      };
  };

  $servicePitch = static function ($offering): string {
      return match ($offering->service_type) {
          'electrician' => 'Fast repairs for switches, fans, wiring and urgent electrical faults.',
          'plumber' => 'Quick help for tap issues, leakage fixes and pipe work.',
          'ac_cooler_repair' => 'Book AC and cooler experts for gas refill, servicing and urgent cooling issues.',
          'driver' => 'Choose a driver only, driver with car, office pickup or outstation duty.',
          default => 'Trusted local service with simple booking.',
      };
  };

  $formatLocation = static function ($provider): string {
      return $provider->city ?: $provider->address ?: 'Location not added yet';
  };

  $formatImage = static function ($provider): string {
      if ($provider->profile_image_path) {
          return \Illuminate\Support\Facades\Storage::url($provider->profile_image_path);
      }

      return 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80';
  };

  $getMeta = static function ($offering): array {
      $meta = [];

      if ($offering->service_subtype) {
          $meta[] = \Illuminate\Support\Str::headline($offering->service_subtype);
      }

      if ($offering->service_mode) {
          $meta[] = \Illuminate\Support\Str::headline($offering->service_mode);
      }

      if ($offering->experience_years) {
          $meta[] = $offering->experience_years.'+ years exp.';
      }

      return array_slice($meta, 0, 3);
  };

  $serviceCount = $visibleOfferings->pluck('service_type')->filter()->unique()->count();
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
  @media (max-width: 560px) {
    .mobile-shortcuts {
        padding: 0 1rem 0.9rem;
    }
  }
  .card.hidden {
  display: none;
}
  :root {
    --primary: #7C3AED;
    --primary-light: #F5F3FF;
    --accent: #C4B5FD;
    --success: #10B981;
    --dark: #0F172A;
    --gray: #64748B;
    --white: #FFFFFF;
    --border: #E2E8F0;
    --bg-soft: #F8FAFC;
  }

  .hero {
    padding: 22px 8% 38px;
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(320px, 0.9fr);
    align-items: center;
    gap: 32px;
    background:
      radial-gradient(circle at top left, rgba(124, 58, 237, 0.18), transparent 28%),
      linear-gradient(180deg, #FCFBFF 0%, #F5F3FF 100%);
  }

  .hero-copy {
    display: grid;
    gap: 18px;
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: fit-content;
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(124, 58, 237, 0.14);
    color: var(--primary);
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .hero-content h1 {
    font-size: clamp(2.25rem, 5vw, 4rem);
    line-height: 0.98;
    margin: 0;
    letter-spacing: -0.06em;
    max-width: 11ch;
  }

  .hero-content h1 span {
    color: var(--primary);
  }

  .hero-content p {
    color: var(--gray);
    margin: 0;
    font-size: clamp(1rem, 2vw, 1.08rem);
    line-height: 1.7;
    max-width: 58ch;
  }

  .hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
  }

  .quick-search-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: -4px;
  }

  .quick-search-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 34px;
    padding: 0 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(226, 232, 240, 0.96);
    color: var(--gray);
    font-size: 0.76rem;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s ease;
  }

  .quick-search-tag:hover {
    color: var(--primary);
    border-color: rgba(124, 58, 237, 0.2);
    background: #fff;
  }

  .hero-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 18px;
    border-radius: 18px;
    font-weight: 800;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .hero-link.primary {
    background: linear-gradient(135deg, var(--primary), #8B5CF6);
    color: var(--white);
    box-shadow: 0 16px 34px rgba(124, 58, 237, 0.24);
  }

  .hero-link.secondary {
    background: rgba(255, 255, 255, 0.92);
    color: var(--dark);
    border: 1px solid var(--border);
  }

  .hero-link:hover {
    transform: translateY(-2px);
  }

  .hero-metrics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
  }

  .metric-card {
    background: rgba(255, 255, 255, 0.94);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 22px;
    padding: 16px;
  }

  .metric-card strong {
    display: block;
    font-size: 1.45rem;
    margin-bottom: 4px;
    color: var(--dark);
  }

  .metric-card span {
    color: var(--gray);
    font-size: 0.84rem;
    font-weight: 600;
  }

  .search-container {
    background: rgba(255, 255, 255, 0.96);
    padding: 8px;
    border-radius: 22px;
    display: grid;
    grid-template-columns: minmax(148px, 192px) 1fr auto;
    align-items: center;
    gap: 8px;
    box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
    max-width: 680px;
    border: 1px solid rgba(226, 232, 240, 0.96);
  }

  .location-btn {
    display: grid;
    grid-template-columns: auto 1fr;
    align-items: center;
    gap: 10px;
    min-height: 48px;
    padding: 0 14px;
    border-radius: 16px;
    background: linear-gradient(180deg, #FAFAFF 0%, #F5F3FF 100%);
    cursor: pointer;
    color: var(--dark);
    transition: 0.2s ease;
  }

  .location-btn:hover {
    background: #F7F3FF;
  }

  .location-btn i {
    width: 30px;
    height: 30px;
    border-radius: 11px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(124, 58, 237, 0.14);
    color: var(--primary);
    font-size: 0.9rem;
  }

  .location-copy {
    display: grid;
    gap: 2px;
    min-width: 0;
  }

  .location-label {
    font-size: 0.66rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--gray);
  }

  #loc-text {
    font-size: 0.82rem;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .search-container input {
    width: 100%;
    border: none;
    padding: 0 6px;
    outline: none;
    font-size: 0.95rem;
    min-height: 48px;
    background: transparent;
    color: var(--dark);
  }

  .search-container button {
    background: linear-gradient(135deg, var(--primary), #8B5CF6);
    color: white;
    border: none;
    padding: 0 18px;
    border-radius: 16px;
    font-weight: 800;
    cursor: pointer;
    min-height: 48px;
    box-shadow: 0 10px 22px rgba(124, 58, 237, 0.22);
  }

  .hero-panel {
    background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 32px;
    padding: 20px;
    box-shadow: 0 26px 60px rgba(15, 23, 42, 0.08);
  }

  .panel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
  }

  .panel-head h3 {
    font-size: 1.05rem;
    margin: 0;
  }

  .panel-chip {
    padding: 8px 12px;
    border-radius: 999px;
    background: #ECFDF5;
    color: #047857;
    font-size: 0.76rem;
    font-weight: 800;
  }

  .panel-stack {
    display: grid;
    gap: 14px;
  }

  .panel-card {
    display: grid;
    grid-template-columns: 64px 1fr auto;
    gap: 14px;
    align-items: center;
    padding: 14px;
    border-radius: 22px;
    background: #FFFFFF;
    border: 1px solid #EEF2FF;
  }

  .panel-card img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 18px;
  }

  .panel-card h4 {
    margin: 0 0 4px;
    font-size: 1rem;
  }

  .panel-card p {
    margin: 0;
    color: var(--gray);
    font-size: 0.84rem;
  }

  .panel-price {
    text-align: right;
  }

  .panel-price strong {
    display: block;
    color: var(--primary);
    font-size: 1rem;
  }

  .panel-price span {
    color: var(--gray);
    font-size: 0.8rem;
  }

  .trust-section {
    padding: 0 8% 18px;
  }

  .trust-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
  }

  .trust-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 18px;
  }

  .trust-card h3 {
    margin: 0 0 6px;
    font-size: 1rem;
  }

  .trust-card p {
    margin: 0;
    color: var(--gray);
    line-height: 1.6;
    font-size: 0.88rem;
  }

  .filter-wrapper {
    padding: 12px 8% 10px;
    position: sticky;
    top: 0;
    z-index: 999;
    background: rgba(252, 251, 255, 0.9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(226, 232, 240, 0.8);
  }

  .filter-shell {
    max-width: 1240px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 22px;
    padding: 14px;
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.07);
  }

  .filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }

  .filter-label {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .filter-label strong {
    font-size: 0.92rem;
    color: var(--dark);
  }

  .filter-label span {
    font-size: 0.78rem;
    color: var(--gray);
  }

  .filter-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 7px 11px;
    border-radius: 12px;
    background: #F8F5FF;
    color: var(--primary);
    font-size: 0.76rem;
    font-weight: 800;
  }

  .filter-container {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    scrollbar-width: none;
    padding-bottom: 4px;
    scroll-snap-type: x proximity;
  }

  .filter-container::-webkit-scrollbar {
    display: none;
  }

  .filter-btn {
    padding: 10px 14px;
    border-radius: 14px;
    border: 1px solid var(--border);
    background: #F8FAFC;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition: 0.3s;
    color: var(--gray);
    scroll-snap-align: start;
    font-size: 0.84rem;
  }

  .filter-btn.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
    box-shadow: 0 10px 20px rgba(124, 58, 237, 0.2);
  }

  .marketplace {
    padding: 36px 8% 40px;
  }

  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 12px;
  }

  .view-all {
    color: var(--primary);
    text-decoration: none;
    font-weight: 700;
  }

  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.4rem;
  }

  .card {
    background: var(--white);
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid #F1F5F9;
    transition: 0.4s;
    position: relative;
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .card.hidden {
    display: none;
  }

  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
  }

  .status-pill {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(255, 255, 255, 0.9);
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--success);
  }

  .card-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
  }

  .card-body {
    padding: 1.5rem;
  }

  .mini-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 10px 0 0;
  }

  .mini-meta span {
    padding: 6px 10px;
    border-radius: 999px;
    background: #F8FAFC;
    color: var(--gray);
    font-size: 0.76rem;
    font-weight: 700;
  }

  .category-tag {
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
  }

  .name {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 5px 0;
  }

  .card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    border-top: 1px solid #f1f1f1;
    padding-top: 1rem;
  }

  .price {
    font-weight: 800;
    font-size: 1.1rem;
    color: var(--dark);
  }

  .book-btn {
    background: var(--primary);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
  }

  .extra-section,
  .testimonials {
    padding: 24px 8% 48px;
    background: var(--white);
  }

  .testimonials-header,
  .extra-header {
    margin-bottom: 1.6rem;
    text-align: center;
  }

  .static-cards {
  padding: 60px 20px;
  background: #f9fafb;
  text-align: center;
}

.static-section-header h2 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.static-section-header p {
  color: #6c757d;
  margin-bottom: 40px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 25px;
}

.static-card {
  background: #ffffff;
  padding: 30px 20px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.static-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
}

.card-icon {
  font-size: 50px;
  margin-bottom: 20px;
  display: inline-block;
}

.static-card h3 {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 10px;
}

.static-card p {
  font-size: 0.95rem;
  color: #6c757d;
}

  .extra-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
  }

  .extra-card {
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 22px;
    background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
  }

  .extra-card h3 {
    margin: 0 0 10px;
    font-size: 1rem;
  }

  .extra-card p,
  .extra-card li {
    color: var(--gray);
    line-height: 1.6;
    font-size: 0.92rem;
  }

  .extra-card ul {
    margin: 0;
    padding-left: 18px;
  }

  .testimonial-card {
    background: linear-gradient(180deg, #FFFFFF 0%, var(--primary-light) 100%);
    border-radius: 20px;
    padding: 22px;
    margin: 0;
    border: 1px solid rgba(226, 232, 240, 0.95);
    transition: transform 0.3s;
  }

  .testimonial-text {
    font-style: italic;
    color: var(--gray);
  }

  .testimonial-author {
    font-weight: bold;
    margin-top: 10px;
  }

  @media (max-width: 1100px) {
    .hero,
    .trust-grid,
    .extra-grid,
    .hero-metrics {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media (max-width: 900px) {
    .hero {
      grid-template-columns: 1fr;
      padding-top: 18px;
      gap: 22px;
    }

    .hero-content h1 {
      max-width: 100%;
    }

    .search-container {
      grid-template-columns: 1fr;
      gap: 10px;
      padding: 10px;
    }

    .location-btn {
      justify-content: flex-start;
      min-height: 46px;
    }

    .search-container button {
      width: 100%;
    }

    .trust-grid,
    .extra-grid,
    .hero-metrics {
      grid-template-columns: 1fr;
    }

    .section-header {
      flex-direction: column;
      align-items: flex-start;
    }
  }

  @media (max-width: 640px) {
    .hero {
      padding: 14px 5% 28px;
    }

    .hero-badge {
      font-size: 0.68rem;
      padding: 7px 11px;
    }

    .hero-content h1 {
      font-size: 1.8rem;
      line-height: 1.12;
      letter-spacing: -0.03em;
    }

    .hero-content p {
      font-size: 0.9rem;
      line-height: 1.55;
    }

    .search-container input,
    .search-container button,
    .location-btn,
    .hero-link {
      font-size: 0.9rem;
    }

    .search-container {
      border-radius: 18px;
      gap: 8px;
    }

    .location-btn {
      padding: 0 12px;
      border-radius: 14px;
    }

    .location-btn i {
      width: 28px;
      height: 28px;
      border-radius: 10px;
      font-size: 0.8rem;
    }

    .location-label {
      font-size: 0.6rem;
    }

    #loc-text {
      font-size: 0.78rem;
    }

    .hero-link {
      padding: 12px 16px;
    }

    .quick-search-tag {
      min-height: 32px;
      padding: 0 10px;
      font-size: 0.72rem;
    }

    .metric-card strong {
      font-size: 1.15rem;
    }

    .metric-card span {
      font-size: 0.78rem;
      line-height: 1.45;
    }

    .hero-panel,
    .trust-section {
      display: none;
    }

    .marketplace,
    .trust-section,
    .extra-section,
    .static-cards,
    .testimonials,
    .filter-wrapper {
      padding-left: 5%;
      padding-right: 5%;
    }

    .filter-shell {
      border-radius: 20px;
      padding: 12px;
    }

    #provider-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
    }

    .filter-header {
      flex-direction: column;
      align-items: flex-start;
      margin-bottom: 10px;
    }

    .filter-label strong,
    .section-header h2,
    .extra-header h2,
    .static-section-header h2,
    .testimonials-header h2 {
      font-size: 1.2rem;
      line-height: 1.25;
    }

    .filter-label span,
    .section-header p,
    .extra-header p,
    .static-section-header p,
    .testimonials-header p,
    .trust-card p,
    .extra-card p,
    .testimonial-text,
    .static-card p {
      font-size: 0.86rem;
      line-height: 1.55;
    }

    .filter-status {
      min-height: 34px;
      font-size: 0.72rem;
    }

    .panel-card {
      grid-template-columns: 56px 1fr;
    }

    .panel-price {
      grid-column: 2;
      text-align: left;
    }

    .card-img {
      height: 140px;
    }

    .card-body,
    .trust-card,
    .extra-card,
    .static-card,
    .testimonial-card {
      padding: 18px;
    }

    .category-tag {
      font-size: 0.66rem;
    }

    .card-footer {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      margin-top: 0.85rem;
      padding-top: 0.85rem;
    }

    #provider-grid .card-body {
      padding: 14px;
    }

    #provider-grid .name {
      font-size: 1rem;
      line-height: 1.3;
    }

    #provider-grid .card-body p,
    .extra-card li,
    .testimonial-author,
    .static-card h3,
    .trust-card h3,
    .extra-card h3,
    .testimonial-card h3 {
      font-size: 0.88rem;
      line-height: 1.5;
    }

    #provider-grid .mini-meta {
      gap: 6px;
      margin-top: 8px;
    }

    #provider-grid .mini-meta span {
      padding: 5px 8px;
      font-size: 0.68rem;
    }

    #provider-grid .price {
      font-size: 0.95rem;
    }

    .book-btn {
      width: 100%;
      padding: 9px 14px;
      font-size: 0.86rem;
    }
  }

  @media (max-width: 560px) {
    .filter-wrapper {
      top: 0;
      padding-top: 8px;
    }

    .hero {
      padding-top: 10px;
      padding-bottom: 24px;
    }

    .hero-content h1 {
      font-size: 1.6rem;
    }

    .hero-content p {
      font-size: 0.85rem;
    }

    .filter-shell {
      border-radius: 18px;
      padding: 10px;
    }

    .filter-label strong {
      font-size: 0.86rem;
    }

    .filter-label span {
      font-size: 0.74rem;
    }

    .filter-container {
      gap: 8px;
    }

    .filter-btn {
      padding: 9px 13px;
      font-size: 0.78rem;
    }

    .card-body,
    .trust-card,
    .extra-card,
    .static-card,
    .testimonial-card {
      padding: 15px;
    }

    .book-btn {
      font-size: 0.82rem;
    }
  }

  @media (max-width: 420px) {
    #provider-grid {
      grid-template-columns: 1fr;
    }

    .hero-content h1 {
      font-size: 1.45rem;
    }

    .section-header h2,
    .extra-header h2,
    .static-section-header h2,
    .testimonials-header h2 {
      font-size: 1.08rem;
    }

    #provider-grid .name {
      font-size: 0.95rem;
    }
  }
</style>

<header class="hero">
  <div class="hero-copy">
    <div class="hero-badge">Home Service App</div>
    <div class="hero-content">
      <h1>Book trusted emergency home services in Mohali <span>in 30–60 mins.</span></h1>
      <p>Electrician, plumber and AC repair in one clean app-style flow with fixed rates and quick booking.</p>
    </div>

    <div class="search-container">
      <div class="location-btn" onclick="detectLocation()" tabindex="0" role="button">
        <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
        <div class="location-copy">
          <span class="location-label">Location</span>
          <span id="loc-text">Detect Location</span>
        </div>
      </div>
      <input type="text" id="hero-search-input" placeholder="Search electrician, plumber or AC repair">
      <button type="button" id="hero-search-btn" onclick="runHeroSearch()">Search</button>
    </div>

    <div class="quick-search-tags">
      <button type="button" class="quick-search-tag" onclick="setHeroSearch('Electrician')">Electrician</button>
      <button type="button" class="quick-search-tag" onclick="setHeroSearch('Plumber')">Plumber</button>
      <button type="button" class="quick-search-tag" onclick="setHeroSearch('AC Repair')">AC Repair</button>
      <button type="button" class="quick-search-tag" onclick="setHeroSearch('Driver')">Driver</button>
    </div>

    <div class="hero-actions">
      <a href="{{ route('register', ['role' => 'user']) }}" class="hero-link primary">Book Now</a>
      <a href="{{ route('register', ['role' => 'provider']) }}" class="hero-link secondary">Join Provider</a>
    </div>

    <div class="hero-metrics">
      <div class="metric-card">
        <strong>{{ $visibleOfferings->pluck('user_id')->unique()->count() }}</strong>
        <span>Verified workers</span>
      </div>
      <div class="metric-card">
        <strong>{{ $visibleOfferings->count() }}</strong>
        <span>Quick service in 30–60 mins</span>
      </div>
      <div class="metric-card">
        <strong>{{ $serviceCount }}</strong>
        <span>No hidden charges</span>
      </div>
    </div>
  </div>

  <aside class="hero-panel">
    <div class="panel-head">
      <h3>Popular bookings</h3>
      <span class="panel-chip">Live</span>
    </div>

    <div class="panel-stack">
      @forelse ($popularOfferings as $offering)
        @php
          $provider = $offering->user;
          [$panelPrice, $panelUnit] = $formatPrice($offering);
        @endphp
        <div class="panel-card">
          <img src="{{ $formatImage($provider) }}" alt="{{ $offering->service_type }}">
          <div>
            <h4>{{ $provider->name }}</h4>
            <p>{{ $servicePitch($offering) }} in {{ $formatLocation($provider) }}</p>
          </div>
          <div class="panel-price">
            <strong>{{ $priceTeaser($offering) }}</strong>
            <span>{{ $panelPrice }}</span>
          </div>
        </div>
      @empty
        <div class="panel-card">
          <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300" alt="Provider">
          <div>
            <h4>No providers yet</h4>
            <p>Provider cards will show here after registration.</p>
          </div>
          <div class="panel-price">
            <strong>Join now</strong>
            <span>live soon</span>
          </div>
        </div>
      @endforelse
    </div>
  </aside>
</header>

<section class="trust-section">
  <div class="trust-grid">
    <div class="trust-card">
      <h3>Verified workers</h3>
      <p>Trusted local pros shown first.</p>
    </div>
    <div class="trust-card">
      <h3>Quick service</h3>
      <p>Fast booking flow for urgent jobs.</p>
    </div>
    <div class="trust-card">
      <h3>No hidden charges</h3>
      <p>Clear prices before you request.</p>
    </div>
    <div class="trust-card">
      <h3>Local in Mohali</h3>
      <p>Built for nearby home service booking.</p>
    </div>
  </div>
</section>

<div class="filter-wrapper">
  <div class="filter-shell">
    <div class="filter-header">
      <div class="filter-label">
        <strong>Browse services</strong>
        <span>Tap a service to see nearby experts</span>
      </div>
      <div class="filter-status" id="filter-status">{{ $visibleOfferings->count() }} experts live</div>
    </div>
    <div class="filter-container">
      @foreach ($serviceLabels as $serviceKey => $serviceLabel)
        <button class="filter-btn {{ $serviceKey === 'all' ? 'active' : '' }}" onclick="filterServices('{{ $serviceKey }}', this)">{{ $serviceLabel }}</button>
      @endforeach
    </div>
  </div>
</div>

<main class="marketplace">
  <div class="section-header">
    <h2 id="service-title">Top services near you</h2>
    <a href="/list" class="view-all">See all</a>
  </div>

  <p id="search-feedback" style="display:none; margin: -0.75rem 0 1.25rem; color: var(--gray); font-weight: 600;"></p>

  <div class="grid" id="provider-grid">
    @forelse ($visibleOfferings as $offering)
      @php
        $provider = $offering->user;
        [$displayPrice, $displayUnit] = $formatPrice($offering);
        $metaItems = $getMeta($offering);
      @endphp
      <a href="{{ route('profile', ['offering' => $offering->id]) }}">
        <div class="card" data-category="{{ $offering->service_type }}">
          <div class="status-pill"><div class="dot"></div> available</div>
          <img src="{{ $formatImage($provider) }}" class="card-img" alt="{{ $offering->service_type }}">
          <div class="card-body">
            <span class="category-tag">{{ $offering->offering_name ?: \Illuminate\Support\Str::headline($offering->service_type) }}</span>
            <h3 class="name">{{ $provider->name }}</h3>
            <p style="color: var(--gray); font-size: 0.85rem;">{{ $formatLocation($provider) }}</p>
            <p style="color: var(--dark); font-size: 0.9rem; line-height: 1.55; margin: 0.55rem 0 0.25rem;">{{ $servicePitch($offering) }}</p>
            <div class="mini-meta">
              @foreach ($metaItems as $metaItem)
                <span>{{ $metaItem }}</span>
              @endforeach
              @if(count($metaItems) === 0)
    <span>Service available</span>
@endif
            </div>
            <div class="card-footer">
              <div class="price">{{ $priceTeaser($offering) }}<span>{{ $displayPrice }}</span></div>
              <span class="book-btn">View Fixed Rates</span>
            </div>
          </div>
        </div>
      </a>
    @empty
      <div class="empty-state" style="grid-column: 1 / -1;">No providers are available yet.</div>
    @endforelse
  </div>
</main>

<section class="extra-section">
  <div class="extra-header">
    <h2>Why families choose Homiease</h2>
    <p>Quick help, clear pricing, and a smoother booking flow.</p>
  </div>

  <div class="extra-grid">
    <div class="extra-card">
      <h3>Made for busy days</h3>
      <ul>
        <li>Book help quickly when wiring, leaks, or cooling issues cannot wait</li>
        <li>Find the right service without calling multiple people</li>
        <li>Get support that fits your routine and saves time for your family</li>
      </ul>
    </div>

    <div class="extra-card">
      <h3>Simple and transparent</h3>
      <ul>
        <li>Clear pricing details before you send a request</li>
        <li>Verified workers so you feel more comfortable booking</li>
        <li>Easy mobile-friendly flow that works even in a hurry</li>
      </ul>
    </div>

    <div class="extra-card">
      <h3>Peace of mind at home</h3>
      <p>Homiease is designed to make everyday life easier by helping you get trusted local service faster, with less confusion and more confidence.</p>
    </div>
  </div>
</section>

<section class="static-cards">
  <div class="static-section-header">
    <h2>Book The Most Requested Home Services</h2>
    <p>Every service is presented in a way that feels clear, dependable, and easy to book.</p>
  </div>

  <div class="grid">
    <div class="static-card">
      <i class="bi bi-lightning-charge card-icon"></i>
      <h3>Electrician Services</h3>
      <p>Book for switch and socket work, fan repair, and urgent wiring needs with visit fees starting from Rs. 99.</p>
    </div>

    <div class="static-card">
      <i class="bi bi-tools card-icon"></i>
      <h3>Plumber Services</h3>
      <p>Tap repair, leakage fixes, and pipe work from trusted local plumbers with transparent fixed rates.</p>
    </div>

    <div class="static-card">
      <i class="bi bi-snow card-icon"></i>
      <h3>AC / Cooler Repair</h3>
      <p>Get help for gas check, refill, and general service before cooling problems become urgent.</p>
    </div>

    <div class="static-card">
      <i class="bi bi-car-front card-icon"></i>
      <h3>Driver Booking</h3>
      <p>Choose driver only, driver with car, office pickup, or outstation duty based on your exact travel need.</p>
    </div>
  </div>
</section>

<section class="testimonials">
  <div class="testimonials-header">
    <h2>What customers want most</h2>
    <p>People usually come to Homiease for fast help, honest pricing, and a smoother experience during stressful home problems.</p>
  </div>
  <div class="grid">
    <div class="testimonial-card">
      <p class="testimonial-text">"Seeing the electrician visit fee upfront makes it much easier to book quickly instead of calling multiple people."</p>
      <p class="testimonial-author">- Priya K.</p>
    </div>
    <div class="testimonial-card">
      <p class="testimonial-text">"The AC service pricing feels much more trustworthy when the common jobs are already explained clearly."</p>
      <p class="testimonial-author">- Raj S.</p>
    </div>
    <div class="testimonial-card">
      <p class="testimonial-text">"The plumber booking flow feels simple, and I can understand what I may pay before sending the request."</p>
      <p class="testimonial-author">- Anita R.</p>
    </div>
    <div class="testimonial-card">
      <p class="testimonial-text">"Driver only and driver with car being separate options is exactly what I needed. It removes confusion."</p>
      <p class="testimonial-author">- Vikram T.</p>
    </div>
  </div>
</section>

<script>
 
  let isDetectingLocation = false;
  let activeServiceCategory = 'all';
  let activeSearchQuery = '';

  async function resolveLocationName(latitude, longitude) {
    try {
      const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`, {
        headers: {
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Reverse geocoding failed');
      }

      const data = await response.json();
      const address = data.address || {};
      const city = address.city || address.town || address.village || address.state_district || address.county;
      const state = address.state;

      if (city && state) {
        return `${city}, ${state}`;
      }

      return city || state || 'Current Location';
    } catch (error) {
      return 'Current Location';
    }
  }

  function detectLocation() {
    const text = document.getElementById('loc-text');
    if (!text || isDetectingLocation) return;

    if (!navigator.geolocation) {
      text.innerText = 'Location Unsupported';
      return;
    }

    isDetectingLocation = true;
    text.innerText = 'Finding you...';

    navigator.geolocation.getCurrentPosition(
      async (position) => {
        const { latitude, longitude } = position.coords;
        const locationName = await resolveLocationName(latitude, longitude);
        text.innerText = locationName;
        isDetectingLocation = false;
      },
      () => {
        text.innerText = 'Enable Location';
        isDetectingLocation = false;
      },
      {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 300000
      }
    );
  }

  function applyMarketplaceFilters() {
    const cards = document.querySelectorAll('#provider-grid .card');
    const title = document.getElementById('service-title');
    const filterStatus = document.getElementById('filter-status');
    const searchFeedback = document.getElementById('search-feedback');
    let visibleCount = 0;
    const normalizedQuery = activeSearchQuery.trim().toLowerCase();

    cards.forEach((card) => {
      const wrapper = card.closest('a');
      const cardCategory = card.getAttribute('data-category');
      const cardText = card.innerText.toLowerCase();
      const matchesCategory = activeServiceCategory === 'all' || cardCategory === activeServiceCategory;
      const matchesSearch = !normalizedQuery || cardText.includes(normalizedQuery);

      if (matchesCategory && matchesSearch) {
        wrapper.style.display = 'block';
        visibleCount++;
      } else {
        wrapper.style.display = 'none';
      }
    });

    const categoryNames = {
      electrician: 'Electricians',
      plumber: 'Plumbers',
      ac_cooler_repair: 'AC / Cooler Repair',
      driver: 'Drivers'
    };

    title.textContent = activeServiceCategory === 'all'
      ? 'Top services near you'
      : 'Available ' + (categoryNames[activeServiceCategory] || activeServiceCategory);

    if (filterStatus) {
      filterStatus.textContent = `${visibleCount} expert${visibleCount === 1 ? '' : 's'} live`;
    }

    if (searchFeedback) {
      if (normalizedQuery) {
        searchFeedback.style.display = 'block';
        searchFeedback.textContent = `${visibleCount} result${visibleCount === 1 ? '' : 's'} for "${activeSearchQuery.trim()}"`;
      } else {
        searchFeedback.style.display = 'none';
        searchFeedback.textContent = '';
      }
    }
  }

  function filterServices(category, btn) {
    activeServiceCategory = category;

    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach((b) => b.classList.remove('active'));
    btn.classList.add('active');

    applyMarketplaceFilters();
  }

  function runHeroSearch() {
    const input = document.getElementById('hero-search-input');
    const marketplace = document.querySelector('.marketplace');
    if (!input) return;

    activeSearchQuery = input.value || '';
    applyMarketplaceFilters();

    if (marketplace) {
      marketplace.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function setHeroSearch(value) {
    const input = document.getElementById('hero-search-input');

    if (!input) {
      return;
    }

    input.value = value;
    runHeroSearch();
  }

  document.addEventListener('DOMContentLoaded', () => {
    const activeButton = document.querySelector('.filter-btn.active');
    if (activeButton) {
      filterServices('all', activeButton);
    }

    const heroSearchInput = document.getElementById('hero-search-input');
    if (heroSearchInput) {
      heroSearchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
          event.preventDefault();
          runHeroSearch();
        }
      });
    }

    detectLocation();
  });

 
</script>
@endsection
