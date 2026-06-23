@extends('layouts.app')

@section('title', 'Homiease | Emergency Electrician, Plumber & AC Repair In Mohali')
@section('meta_description', 'Browse trusted electrician, plumber and AC repair services in Mohali with fast 30 to 60 minute support, verified workers and no hidden charges.')
@section('meta_keywords', 'emergency electrician Mohali, plumber Mohali, AC repair Mohali, verified workers Mohali, fast home service Mohali')
@section('canonical', 'https://homiease.in/list')
@section('og_title', 'Homiease | Browse Emergency Home Services In Mohali')
@section('og_description', 'Compare electrician, plumber and AC repair services in Mohali with verified workers and transparent pricing.')
@section('twitter_title', 'Homiease | Browse Mohali Home Services')
@section('twitter_description', 'Find trusted Mohali electrician, plumber and AC repair services with fast support and clear pricing.')
@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "CollectionPage",
  "name": "Emergency Home Services in Mohali",
  "url": "https://homiease.in/list",
  "description": "Browse emergency electrician, plumber and AC repair services in Mohali.",
  "about": [
    "Electrician",
    "Plumber",
    "AC Repair",
    "Cooler Repair",
    "Driver Service"
  ]
}
</script>
@endsection

@section('content')
@php
    $targetServiceTypes = ['electrician', 'plumber', 'ac_cooler_repair', 'driver'];
    $visibleOfferings = ($offerings ?? collect())->whereIn('service_type', $targetServiceTypes)->values();
    $serviceLabels = [
        'electrician' => 'Electricians',
        'plumber' => 'Plumbers',
        'ac_cooler_repair' => 'AC / Cooler Repair',
        'driver' => 'Drivers',
    ];

    $formatPrice = static function ($offering): array {
        $fixedSummary = \App\Models\ProviderOffering::fixedPricingSummaryFor($offering->service_type);
        $amount = $offering->price_amount;
        $display = $fixedSummary ?: ($amount !== null ? 'Rs. '.number_format((float) $amount, 0) : ($offering->price ?: 'Price on request'));
        $unit = $fixedSummary ? '' : ($offering->pricing_model ? '/'.str_replace('_', ' ', $offering->pricing_model) : '');

        return [$display, $unit];
    };

    $priceTeaser = static function ($offering): string {
        return match ($offering->service_type) {
            'electrician' => 'Visit fee from Rs. 99',
            'plumber' => 'Visit fee from Rs. 99',
            'ac_cooler_repair' => 'Checks from Rs. 149',
            'driver' => str_contains(strtolower((string) $offering->service_subtype), 'with car')
                ? 'With car available'
                : 'Driver only from Rs. 800',
            default => 'Fixed local rates',
        };
    };

    $servicePitch = static function ($offering): string {
        return match ($offering->service_type) {
            'electrician' => 'Switches, sockets, fans, wiring and urgent electrical fixes.',
            'plumber' => 'Tap repairs, leakage fixes and pipe work with transparent pricing.',
            'ac_cooler_repair' => 'Gas refill, gas check and cooling service support.',
            'driver' => 'Driver only, driver with car, office pickup and outstation duty.',
            default => 'Trusted local service support.',
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

    $formatDescription = static function ($offering): string {
        if ($offering->details) {
            return $offering->details;
        }

        if ($offering->notes) {
            return \Illuminate\Support\Str::limit($offering->notes, 120);
        }

        return 'Provider details will appear here once the professional completes more service information.';
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
            $meta[] = $offering->experience_years.' yrs exp';
        }

        return array_slice($meta, 0, 3);
    };

    $totalCount = $visibleOfferings->count();
@endphp

<style>
  :root {
    --primary: #7c3aed;
    --primary-soft: #f5f3ff;
    --text: #0f172a;
    --muted: #64748b;
    --surface: #ffffff;
    --border: #e2e8f0;
    --page: #f8fafc;
    --success: #10b981;
  }

  .directory-shell {
    background:
      radial-gradient(circle at top right, rgba(124, 58, 237, 0.16), transparent 24%),
      linear-gradient(180deg, #fcfbff 0%, #f8fafc 100%);
    min-height: calc(100vh - 80px);
  }

  .container {
    max-width: 1320px;
    margin: 0 auto;
    padding: 28px 5% 42px;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
  }

  .sidebar,
  .results-overview,
  .expert-card,
  .empty-state {
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(226, 232, 240, 0.92);
    box-shadow: 0 16px 34px rgba(15, 23, 42, 0.06);
  }

  .sidebar {
    position: sticky;
    top: 92px;
    height: fit-content;
    border-radius: 28px;
    padding: 24px;
  }

  .filter-section + .filter-section {
    margin-top: 22px;
  }

  .filter-section h4 {
    margin: 0 0 14px;
    color: var(--muted);
    font-size: 0.74rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .filter-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    color: var(--text);
    font-weight: 600;
    cursor: pointer;
  }

  .filter-item input {
    accent-color: var(--primary);
    width: 18px;
    height: 18px;
  }

  .directory-main {
    min-width: 0;
  }

  .results-overview {
    border-radius: 30px;
    padding: 24px;
    margin-bottom: 18px;
    background:
      radial-gradient(circle at top right, rgba(124, 58, 237, 0.15), transparent 34%),
      linear-gradient(145deg, #ffffff 0%, #f7f8ff 58%, #fef2f2 100%);
  }

  .results-kicker {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(124, 58, 237, 0.14);
    color: var(--primary);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 14px;
  }

  .results-overview h2 {
    margin: 0 0 10px;
    color: var(--text);
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    line-height: 1.15;
  }

  .results-overview h2 span {
    color: var(--primary);
  }

  .results-subtitle {
    margin: 0;
    color: var(--muted);
    line-height: 1.7;
    max-width: 760px;
  }

  .results-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
  }

  .summary-chip,
  .results-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    font-weight: 800;
  }

  .summary-chip {
    min-height: 40px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(226, 232, 240, 0.92);
    color: var(--text);
    font-size: 0.8rem;
  }

  .results-header {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 12px;
    margin-bottom: 16px;
  }

  .results-header h3 {
    margin: 0 0 6px;
    color: var(--text);
    font-size: 1.3rem;
  }

  .results-copy {
    color: var(--muted);
    font-size: 0.9rem;
  }

  .results-count {
    padding: 8px 12px;
    background: var(--primary-soft);
    color: var(--primary);
    font-size: 0.82rem;
  }

  .sort-dropdown {
    min-width: 180px;
    border: 1px solid var(--border);
    border-radius: 14px;
    background: #fff;
    padding: 12px 14px;
    color: var(--text);
    font-weight: 700;
    outline: none;
  }

  .mobile-filter-bar {
    display: none;
    gap: 10px;
    margin-bottom: 14px;
    position: sticky;
    top: 0;
    z-index: 30;
    padding: 10px;
    border-radius: 22px;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(226, 232, 240, 0.92);
    backdrop-filter: blur(14px);
  }

  .mobile-filter-scroll {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scrollbar-width: none;
    flex: 1;
  }

  .mobile-filter-scroll::-webkit-scrollbar {
    display: none;
  }

  .mobile-pill,
  .mobile-filter-open,
  .drawer-btn,
  .book-now-btn {
    font-weight: 800;
    cursor: pointer;
  }

  .mobile-pill {
    flex: 0 0 auto;
    padding: 10px 14px;
    border-radius: 999px;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text);
  }

  .mobile-pill.active {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
  }

  .mobile-filter-open {
    border: 0;
    border-radius: 14px;
    padding: 0 14px;
    background: var(--primary);
    color: #fff;
  }

  .expert-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .expert-card {
    display: grid;
    grid-template-columns: 132px minmax(0, 1fr) 108px;
    gap: 10px;
    padding: 10px;
    border-radius: 18px;
    transition: transform 0.2s ease, border-color 0.2s ease;
    cursor: pointer;
  }

  .expert-card.hidden {
    display: none;
  }

  .expert-card:hover {
    transform: translateY(-2px);
    border-color: rgba(124, 58, 237, 0.35);
  }

  .expert-img-wrapper {
    position: relative;
    width: 100%;
    height: 116px;
    border-radius: 14px;
    overflow: hidden;
  }

  .expert-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .badge-status {
    position: absolute;
    left: 10px;
    bottom: 10px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 10px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.95);
    color: #047857;
    font-size: 0.68rem;
    font-weight: 800;
  }

  .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--success);
  }

  .expert-info {
    min-width: 0;
    display: grid;
    align-content: center;
    gap: 5px;
  }

  .category-tag {
    color: var(--primary);
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .provider-line {
    margin: 0;
    color: var(--muted);
    font-size: 0.72rem;
    font-weight: 700;
  }

  .expert-name {
    margin: 0;
    color: var(--text);
    font-size: 0.88rem;
    line-height: 1.2;
  }

  .expert-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
  }

  .expert-meta span {
    padding: 4px 7px;
    border-radius: 999px;
    background: #f8fafc;
    color: var(--muted);
    font-size: 0.64rem;
    font-weight: 700;
  }

  .expert-desc {
    display: none;
  }

  .expert-price-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    gap: 6px;
    padding-left: 10px;
    border-left: 1px solid #f1f5f9;
  }

  .price-val {
    color: var(--primary);
    font-size: 0.88rem;
    font-weight: 800;
    text-align: right;
  }

  .price-val span {
    display: block;
    margin-top: 2px;
    color: var(--muted);
    font-size: 0.64rem;
    font-weight: 600;
  }

  .book-now-btn {
    width: 100%;
    border: 0;
    border-radius: 10px;
    min-height: 32px;
    background: var(--primary);
    color: #fff;
    font-size: 0.68rem;
    font-weight: 800;
    cursor: pointer;
  }

  .empty-state {
    display: none;
    border-radius: 24px;
    padding: 40px 20px;
    text-align: center;
    color: var(--muted);
    font-weight: 600;
  }

  .empty-state.show {
    display: block;
  }

  .mobile-filter-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.35);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: 0.2s ease;
    z-index: 9998;
  }

  .mobile-filter-overlay.show {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
  }

  .mobile-filter-drawer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: -100%;
    z-index: 9999;
    background: #fff;
    border-radius: 26px 26px 0 0;
    padding: 18px 16px 26px;
    box-shadow: 0 -20px 50px rgba(15, 23, 42, 0.16);
    transition: bottom 0.25s ease;
    max-height: 84vh;
    overflow-y: auto;
  }

  .mobile-filter-drawer.show {
    bottom: 0;
  }

  .drawer-handle {
    width: 54px;
    height: 5px;
    border-radius: 999px;
    background: #cbd5e1;
    margin: 0 auto 16px;
  }

  .drawer-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
  }

  .drawer-head h3 {
    margin: 0;
    color: var(--text);
  }

  .drawer-close {
    border: 1px solid var(--border);
    background: #f8fafc;
    border-radius: 12px;
    padding: 8px 12px;
    font-weight: 700;
    cursor: pointer;
  }

  .drawer-actions {
    display: flex;
    gap: 10px;
    margin-top: 18px;
  }

  .drawer-btn {
    flex: 1;
    min-height: 46px;
    border-radius: 14px;
    border: 1px solid var(--border);
  }

  .drawer-btn.primary {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  .drawer-btn.secondary {
    background: #fff;
    color: var(--text);
  }

  @media (max-width: 992px) {
    .container {
      grid-template-columns: 1fr;
      padding-left: 4%;
      padding-right: 4%;
    }

    .sidebar {
      display: none;
    }

    .mobile-filter-bar {
      display: flex;
    }

    .expert-card {
      grid-template-columns: 1fr;
      gap: 8px;
    }

    .expert-img-wrapper {
      height: 144px;
    }

    .expert-price-section {
      padding-left: 0;
      padding-top: 12px;
      border-left: 0;
      border-top: 1px solid #f1f5f9;
      align-items: stretch;
    }

    .price-val {
      text-align: left;
    }
  }

  @media (max-width: 640px) {
    .container {
      padding-top: 18px;
      padding-left: 10px;
      padding-right: 10px;
    }

    .results-overview {
      padding: 18px 16px;
      border-radius: 24px;
    }

    .results-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .sort-dropdown {
      width: 100%;
      min-width: 0;
    }

    .expert-list {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 10px;
    }

    .expert-card {
      padding: 8px;
      border-radius: 16px;
      height: 100%;
    }

    .expert-img-wrapper {
      height: 92px;
      border-radius: 12px;
    }

    .expert-name {
      font-size: 0.8rem;
    }

    .provider-line {
      font-size: 0.62rem;
    }

    .expert-meta span {
      font-size: 0.58rem;
      padding: 3px 5px;
    }

    .expert-desc {
      font-size: 0.7rem;
      line-height: 1.35;
      -webkit-line-clamp: 1;
    }

    .price-val {
      font-size: 0.8rem;
    }

    .price-val span {
      font-size: 0.58rem;
    }

    .book-now-btn {
      min-height: 30px;
      font-size: 0.62rem;
    }

    .drawer-actions {
      flex-direction: column;
    }
  }
</style>

<div class="directory-shell">
  <div class="container">
    <aside class="sidebar">
      <div class="filter-section">
        <h4>Categories</h4>
        @foreach ($serviceLabels as $value => $label)
          <label class="filter-item">
            <input type="checkbox" class="cat-filter" value="{{ $value }}" checked onchange="updateList()">
            {{ $label }}
          </label>
        @endforeach
      </div>

      <div class="filter-section">
        <h4>Budget</h4>
    <label class="filter-item"><input type="radio" name="budget" value="all" checked onchange="updateList()"> Show All</label>
    <label class="filter-item"><input type="radio" name="budget" value="low" onchange="updateList()"> Entry-friendly pricing</label>
    <label class="filter-item"><input type="radio" name="budget" value="high" onchange="updateList()"> Premium / bigger jobs</label>
      </div>
    </aside>

    <main class="directory-main">
      <div class="mobile-filter-bar">
        <div class="mobile-filter-scroll">
          <button type="button" class="mobile-pill active" data-cat="all" onclick="selectMobileCategory('all', this)">All</button>
          @foreach ($serviceLabels as $value => $label)
            <button type="button" class="mobile-pill" data-cat="{{ $value }}" onclick="selectMobileCategory('{{ $value }}', this)">{{ $label }}</button>
          @endforeach
        </div>
        <button type="button" class="mobile-filter-open" onclick="openMobileFilters()">Filter</button>
      </div>

      <section class="results-overview">
        <div class="results-kicker">Home Service App</div>
        <h2>Find trusted <span>services near you</span></h2>
        <p class="results-subtitle">Browse verified electricians, plumbers, AC repair experts and drivers in one clean list.</p>
        <div class="results-summary">
          <div class="summary-chip"><strong id="resultsCount">{{ $totalCount }}</strong>&nbsp;live</div>
          <div class="summary-chip">{{ $visibleOfferings->pluck('user_id')->unique()->count() }} professionals</div>
          <div class="summary-chip">{{ $visibleOfferings->pluck('service_type')->filter()->unique()->count() }} categories</div>
        </div>
      </section>

      <div class="results-header">
        <div>
          <h3>Available experts</h3>
          <div class="results-copy">Use filters to find the right provider faster.</div>
        </div>
        <div class="results-count" id="resultsCountBadge">{{ $totalCount }} match{{ $totalCount === 1 ? '' : 'es' }}</div>
        <select class="sort-dropdown" onchange="sortData(this.value)">
          <option value="default">Sort by latest</option>
          <option value="low">Best entry price first</option>
          <option value="high">Premium options first</option>
        </select>
      </div>

      <div class="expert-list" id="expert-container">
        @foreach ($visibleOfferings as $index => $offering)
          @php
              $provider = $offering->user;
              [$displayPrice, $displayUnit] = $formatPrice($offering);
              $meta = $getMeta($offering);
              $sortablePrice = \App\Models\ProviderOffering::minimumFixedPriceFor($offering->service_type);
          @endphp
          <div class="expert-card" data-cat="{{ $offering->service_type }}" data-price="{{ $sortablePrice }}" data-order="{{ $index }}" data-profile-url="{{ route('profile', ['offering' => $offering->id]) }}" onclick="goToProfile(this)" onkeydown="handleCardKeydown(event, this)" tabindex="0" role="link" aria-label="Open {{ $offering->offering_name ?: \Illuminate\Support\Str::headline($offering->service_type) }} profile">
            <div class="expert-img-wrapper">
              <img src="{{ $formatImage($provider) }}" class="expert-img" alt="{{ $provider->name }}">
              <div class="badge-status"><span class="dot"></span> Online</div>
            </div>
            <div class="expert-info">
              <span class="category-tag">{{ $offering->offering_name ?: \Illuminate\Support\Str::headline($offering->service_type) }}</span>
              <h3 class="expert-name">{{ $servicePitch($offering) }}</h3>
              <p class="provider-line">{{ $provider->name }}</p>
              <div class="expert-meta">
                @if (!empty($meta))
                  <span>{{ $meta[0] }}</span>
                @endif
                <span>{{ $formatLocation($provider) }}</span>
              </div>
            </div>
            <div class="expert-price-section">
              <div class="price-val">
                {{ $priceTeaser($offering) }}
                <span>{{ $displayPrice }}</span>
              </div>
              <button type="button" class="book-now-btn" onclick="event.stopPropagation(); goToProfile(this)">View</button>
            </div>
          </div>
        @endforeach
      </div>

      <div class="empty-state" id="emptyState">
        No experts match your selected filters.
      </div>
    </main>
  </div>
</div>

<div class="mobile-filter-overlay" id="mobileFilterOverlay" onclick="closeMobileFilters()"></div>

<div class="mobile-filter-drawer" id="mobileFilterDrawer">
  <div class="drawer-handle"></div>
  <div class="drawer-head">
    <h3>Filter Experts</h3>
    <button type="button" class="drawer-close" onclick="closeMobileFilters()">Close</button>
  </div>

  <div class="filter-section">
    <h4>Categories</h4>
    @foreach ($serviceLabels as $value => $label)
      <label class="filter-item">
        <input type="checkbox" class="mobile-cat-filter" value="{{ $value }}" checked>
        {{ $label }}
      </label>
    @endforeach
  </div>

  <div class="filter-section">
    <h4>Budget</h4>
    <label class="filter-item"><input type="radio" name="mobile-budget" value="all" checked> Show All</label>
    <label class="filter-item"><input type="radio" name="mobile-budget" value="low"> Entry-friendly pricing</label>
    <label class="filter-item"><input type="radio" name="mobile-budget" value="high"> Premium / bigger jobs</label>
  </div>

  <div class="drawer-actions">
    <button type="button" class="drawer-btn secondary" onclick="resetMobileFilters()">Reset</button>
    <button type="button" class="drawer-btn primary" onclick="applyMobileFilters()">Apply Filters</button>
  </div>
</div>

<script>
  function goToProfile(source) {
    const card = source?.classList?.contains('expert-card')
      ? source
      : source?.closest('.expert-card');
    const profileUrl = card?.dataset.profileUrl;

    window.location.href = profileUrl || "{{ route('profile') }}";
  }

  function handleCardKeydown(event, card) {
    if (event.key === 'Enter' || event.key === ' ') {
      event.preventDefault();
      goToProfile(card);
    }
  }

  function getDesktopSelectedCats() {
    return Array.from(document.querySelectorAll('.sidebar .cat-filter:checked')).map((input) => input.value);
  }

  function getDesktopBudget() {
    const selected = document.querySelector('.sidebar input[name="budget"]:checked');
    return selected ? selected.value : 'all';
  }

  function updateList() {
    const selectedCats = getDesktopSelectedCats();
    const budgetFilter = getDesktopBudget();
    const cards = document.querySelectorAll('.expert-card');
    const emptyState = document.getElementById('emptyState');
    const resultsCount = document.getElementById('resultsCount');
    const resultsCountBadge = document.getElementById('resultsCountBadge');
    let visibleCount = 0;

    cards.forEach((card) => {
      const cat = card.dataset.cat;
      const price = parseInt(card.dataset.price || '0', 10);
      let show = selectedCats.includes(cat);

      if (budgetFilter === 'low' && price >= 1500) {
        show = false;
      }

      if (budgetFilter === 'high' && price < 1500) {
        show = false;
      }

      card.classList.toggle('hidden', !show);
      if (show) {
        visibleCount += 1;
      }
    });

    emptyState.classList.toggle('show', visibleCount === 0);
    if (resultsCount) resultsCount.textContent = visibleCount;
    if (resultsCountBadge) resultsCountBadge.textContent = `${visibleCount} match${visibleCount === 1 ? '' : 'es'}`;
    syncMobileQuickPills(selectedCats);
  }

  function sortData(order) {
    const container = document.getElementById('expert-container');
    const items = Array.from(container.querySelectorAll('.expert-card'));

    if (order === 'default') {
      items.sort((a, b) => parseInt(a.dataset.order || '0', 10) - parseInt(b.dataset.order || '0', 10));
    } else {
      items.sort((a, b) => {
        const aPrice = parseInt(a.dataset.price || '0', 10);
        const bPrice = parseInt(b.dataset.price || '0', 10);
        return order === 'low' ? aPrice - bPrice : bPrice - aPrice;
      });
    }

    items.forEach((item) => container.appendChild(item));
  }

  function openMobileFilters() {
    document.getElementById('mobileFilterOverlay').classList.add('show');
    document.getElementById('mobileFilterDrawer').classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileFilters() {
    document.getElementById('mobileFilterOverlay').classList.remove('show');
    document.getElementById('mobileFilterDrawer').classList.remove('show');
    document.body.style.overflow = '';
  }

  function applyMobileFilters() {
    const mobileCats = Array.from(document.querySelectorAll('.mobile-cat-filter:checked')).map((input) => input.value);
    const mobileBudget = document.querySelector('input[name="mobile-budget"]:checked')?.value || 'all';

    document.querySelectorAll('.sidebar .cat-filter').forEach((input) => {
      input.checked = mobileCats.includes(input.value);
    });

    document.querySelectorAll('.sidebar input[name="budget"]').forEach((input) => {
      input.checked = input.value === mobileBudget;
    });

    updateList();
    closeMobileFilters();
  }

  function resetMobileFilters() {
    document.querySelectorAll('.mobile-cat-filter').forEach((input) => {
      input.checked = true;
    });

    const allBudget = document.querySelector('input[name="mobile-budget"][value="all"]');
    if (allBudget) {
      allBudget.checked = true;
    }
  }

  function selectMobileCategory(category, button) {
    document.querySelectorAll('.mobile-pill').forEach((pill) => pill.classList.remove('active'));
    button.classList.add('active');

    const desktopInputs = document.querySelectorAll('.sidebar .cat-filter');
    const mobileInputs = document.querySelectorAll('.mobile-cat-filter');

    if (category === 'all') {
      desktopInputs.forEach((input) => { input.checked = true; });
      mobileInputs.forEach((input) => { input.checked = true; });
    } else {
      desktopInputs.forEach((input) => { input.checked = input.value === category; });
      mobileInputs.forEach((input) => { input.checked = input.value === category; });
    }

    const desktopBudget = document.querySelector('.sidebar input[name="budget"][value="all"]');
    const mobileBudget = document.querySelector('input[name="mobile-budget"][value="all"]');

    if (desktopBudget) desktopBudget.checked = true;
    if (mobileBudget) mobileBudget.checked = true;

    updateList();
  }

  function syncMobileQuickPills(selectedCats) {
    document.querySelectorAll('.mobile-pill').forEach((pill) => pill.classList.remove('active'));
    const totalCategories = {{ count($serviceLabels) }};

    if (selectedCats.length === totalCategories) {
      const allPill = document.querySelector('.mobile-pill[data-cat="all"]');
      if (allPill) allPill.classList.add('active');
      return;
    }

    if (selectedCats.length === 1) {
      const selectedPill = document.querySelector(`.mobile-pill[data-cat="${selectedCats[0]}"]`);
      if (selectedPill) selectedPill.classList.add('active');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    updateList();
  });
</script>
@endsection
