@php
  $currentLocale = app()->getLocale();
  $registerRole = request('role');
  $authUser = auth()->user();
  $isAuthenticated = $authUser instanceof \App\Models\User;
  $isProviderAccount = $isAuthenticated && $authUser->role === 'provider';
  $languageLabels = [
      'en' => 'English',
      'hi' => 'Hindi',
  ];
@endphp

<style>
  @media (max-width: 940px) {
    .mobile-shortcuts, .bottom-nav {
        display: none;
    }
}
@media (max-width: 940px) {
    .top-nav {
        flex-wrap: nowrap;
        padding-bottom: 0.85rem;
    }}
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --bg: #FFFFFF;
  --border: #E2E8F0;
  --text: #0F172A;
  --text-muted: #64748B;
  --shadow-sm: 0 8px 30px rgba(15, 23, 42, 0.05);
}

* { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', -apple-system, sans-serif; }

.site-header {
  position: sticky;
  top: 0;
  z-index: 1100;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid var(--border);
  box-shadow: var(--shadow-sm);
}

.top-nav {
  max-width: 1240px;
  margin: 0 auto;
  padding: 0.95rem 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.brand-block {
  display: flex;
  flex-direction: column;
  text-decoration: none;
}

.mobile-help-trigger {
  display: none;
  width: 42px;
  height: 42px;
  border: 1px solid var(--border);
  border-radius: 14px;
  background: #FFFFFF;
  color: var(--text);
  align-items: center;
  justify-content: center;
  padding: 0;
}

.mobile-help-trigger svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.logo {
  font-size: 1.4rem;
  font-weight: 800;
  color: var(--primary);
  letter-spacing: -0.03em;
  line-height: 1;
}

.tagline {
  color: var(--text-muted);
  font-size: 0.76rem;
  margin-top: 0.25rem;
}

.desktop-nav {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  flex-wrap: wrap;
}

.desktop-nav a,
.mobile-shortcuts a,
.bottom-nav a {
  text-decoration: none;
}

.nav-link {
  color: var(--text);
  font-weight: 700;
  font-size: 0.92rem;
  padding: 0.72rem 0.95rem;
  border-radius: 14px;
  transition: background 0.2s ease, color 0.2s ease;
}

.nav-link:hover,
.nav-link.active {
  background: var(--primary-light);
  color: var(--primary);
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.mobile-inline-actions {
  display: none;
  align-items: center;
  gap: 0.5rem;
  margin-left: auto;
}

.mobile-header-install {
  display: none;
  padding: 0 1rem 0.72rem;
}

.mobile-header-install-action {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 42px;
  border: none;
  border-radius: 14px;
  padding: 0.68rem 0.95rem;
  background: linear-gradient(135deg, #7C3AED, #6D28D9);
  color: #FFFFFF;
  font-family: inherit;
  font-size: 0.8rem;
  font-weight: 800;
  cursor: pointer;
  white-space: nowrap;
  box-shadow: 0 12px 24px rgba(124, 58, 237, 0.22);
  transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
}

.mobile-header-install-action:active {
  transform: translateY(1px) scale(0.99);
  box-shadow: 0 10px 20px rgba(109, 40, 217, 0.2);
}

.mobile-header-install-action:disabled {
  cursor: default;
}

.mobile-header-install-action-label {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  font-size: 0.8rem;
  font-weight: 800;
  line-height: 1;
}

.mobile-header-install-action-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 16px;
  height: 16px;
}

.mobile-header-install-action-badge svg {
  width: 16px;
  height: 16px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.mobile-header-install-action.is-installed {
  background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
  color: #047857;
  box-shadow: none;
}

.mobile-header-install-hint {
  margin: 0.42rem 0 0;
  color: var(--text-muted);
  font-size: 0.7rem;
  line-height: 1.45;
}

.header-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.78rem 1.05rem;
  border-radius: 14px;
  font-size: 0.9rem;
  font-weight: 800;
  white-space: nowrap;
}

.header-btn.secondary {
  background: #F8FAFC;
  color: var(--text);
}

.header-btn.danger {
  background: #FFF1F2;
  color: #BE123C;
}

.header-btn.primary {
  background: var(--primary);
  color: #FFFFFF;
}

.lang-form {
  margin: 0;
}

.lang-picker {
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 0.75rem 0.95rem;
  font: inherit;
  font-size: 0.88rem;
  font-weight: 700;
  color: var(--text);
  background: #FFFFFF;
  cursor: pointer;
  min-width: 120px;
}

.mobile-shortcuts {
  display: none;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  padding: 0 1.25rem 0.95rem;
  max-width: 1240px;
  margin: 0 auto;
}

.mobile-primary {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.9rem 1rem;
  border-radius: 16px;
  background: var(--primary);
  color: #FFFFFF;
  font-weight: 800;
  text-align: center;
}

.mobile-lang {
  width: auto;
  min-width: 110px;
  padding: 0.9rem 0.85rem;
  border-radius: 16px;
  background: #F8FAFC;
}

.bottom-nav {
  display: none;
  justify-content: space-around;
  align-items: center;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.98);
  border-top: 1px solid var(--border);
  box-shadow: 0 -8px 24px rgba(15, 23, 42, 0.08);
  padding: 0.5rem 0 max(0.5rem, env(safe-area-inset-bottom));
  min-height: 72px;
  z-index: 1000;
}

.bottom-nav a {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  color: var(--text-muted);
  font-weight: 700;
  font-size: 0.7rem;
  min-height: 60px;
}

.bottom-nav button {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  min-height: 60px;
  border: none;
  background: transparent;
  color: var(--text-muted);
  font-weight: 700;
  font-size: 0.7rem;
  font-family: inherit;
}

.bottom-nav a.active {
  color: var(--primary);
}

.bottom-nav .nav-icon {
  width: 24px;
  height: 24px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.bottom-nav .nav-icon svg {
  width: 20px;
  height: 20px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.mobile-utility-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.35);
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: 0.25s ease;
  z-index: 1200;
}

.mobile-utility-overlay.show {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.mobile-utility-sheet {
  position: fixed;
  left: 0;
  right: 0;
  bottom: -100%;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  z-index: 1201;
  background: #FFFFFF;
  border-radius: 24px 24px 0 0;
  padding: 18px 16px calc(18px + env(safe-area-inset-bottom, 0px));
  box-shadow: 0 -18px 45px rgba(15, 23, 42, 0.16);
  transition: bottom 0.28s ease, opacity 0.2s ease, visibility 0.2s ease;
  touch-action: pan-y;
}

.mobile-utility-sheet.show {
  bottom: 0;
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.mobile-utility-handle {
  width: 52px;
  height: 5px;
  border-radius: 999px;
  background: #CBD5E1;
  margin: 0 auto 14px;
  cursor: grab;
}

.mobile-utility-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 16px;
}

.mobile-utility-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 0;
  flex: 1;
}

.mobile-utility-brand img {
  width: 52px;
  height: 52px;
  object-fit: contain;
  border-radius: 16px;
  background: #FFFFFF;
  box-shadow: 0 8px 20px rgba(124, 58, 237, 0.12);
  padding: 6px;
}

.mobile-utility-brand strong {
  display: block;
  font-size: 1rem;
  color: var(--text);
}

.mobile-utility-brand span {
  display: block;
  margin-top: 3px;
  color: var(--text-muted);
  font-size: 0.8rem;
  font-weight: 600;
}

.mobile-utility-close {
  border: 1px solid var(--border);
  border-radius: 12px;
  background: #F8FAFC;
  color: var(--text);
  padding: 8px 12px;
  font: inherit;
  font-weight: 700;
  flex-shrink: 0;
}

.mobile-utility-grid {
  display: grid;
  gap: 12px;
}

.mobile-utility-card {
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 14px;
  background: #FFFFFF;
}

.mobile-utility-card label,
.mobile-utility-card span {
  display: block;
  margin-bottom: 8px;
  color: var(--text);
  font-size: 0.88rem;
  font-weight: 700;
}

.mobile-utility-card .lang-picker {
  width: 100%;
  min-width: 0;
}

.mobile-utility-link {
  display: inline-flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  min-height: 48px;
  border-radius: 14px;
  background: var(--primary);
  color: #FFFFFF;
  text-decoration: none;
  font-weight: 800;
}

.mobile-utility-shortcuts {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
}

.mobile-utility-shortcut {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-height: 96px;
  padding: 14px 12px;
  border: 1px solid var(--border);
  border-radius: 18px;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
  color: var(--text);
  text-decoration: none;
  justify-content: center;
}

.shortcut-icon {
  width: 40px;
  height: 40px;
  border-radius: 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: var(--primary-light);
  color: var(--primary);
}

.shortcut-icon svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.mobile-utility-shortcut strong {
  margin: 0;
  font-size: 0.9rem;
}

.mobile-utility-shortcut span {
  margin: 0;
  color: var(--text-muted);
  font-size: 0.74rem;
  font-weight: 600;
  line-height: 1.45;
}

.mobile-utility-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 42px;
  height: 42px;
  border-radius: 14px;
  background: var(--primary-light);
  color: var(--primary);
  font-size: 0.9rem;
  font-weight: 800;
  margin-bottom: 10px;
}

.page-content {
  padding-bottom: calc(78px + env(safe-area-inset-bottom, 0px));
}

@media (max-width: 940px) {
  img.logo-image
 {
    width: 100px;
    /* height: 93px; */
}
  .site-header {
    position: static;
    box-shadow: none;
  }

  .top-nav {
    justify-content: flex-end;
    padding: 0.9rem 1rem 0.75rem;
  }

  .brand-block {
    display: none;
  }

  .desktop-nav {
    display: none;
  }

  .header-actions {
    display: none;
  }

  .mobile-inline-actions {
    display: flex;
  }

  .mobile-header-install {
    display: block;
  }

  .mobile-help-trigger {
    display: inline-flex;
  }

  .mobile-shortcuts {
    display: none;
  }

  .mobile-primary {
    flex: 0 0 auto;
    min-height: 42px;
    padding: 0.7rem 0.9rem;
    border-radius: 14px;
    font-size: 0.82rem;
  }

  .mobile-lang {
    min-width: 92px;
    min-height: 42px;
    padding: 0.65rem 0.7rem;
    border-radius: 14px;
    font-size: 0.8rem;
  }

  .bottom-nav {
    display: flex;
  }
}

@media (max-width: 560px) {
  img.logo-image
 {
    width: 100px;
    /* height: 93px; */
}
  .top-nav {
    padding: 0.9rem 1rem 0.75rem;
  }

  .tagline {
    display: none;
  }

  .top-nav {
    align-items: center;
  }

  .mobile-inline-actions {
    gap: 0.35rem;
  }

  .mobile-primary {
    min-height: 40px;
    border-radius: 14px;
    padding: 0.65rem 0.78rem;
    font-size: 0.76rem;
  }

  .mobile-header-install {
    padding: 0 1rem 0.68rem;
  }

  .mobile-header-install-action {
    min-height: 42px;
    font-size: 0.8rem;
  }

  .mobile-lang {
    min-width: 84px;
    min-height: 40px;
    border-radius: 14px;
    padding: 0.6rem 0.55rem;
    font-size: 0.76rem;
  }

  .mobile-utility-shortcuts {
    grid-template-columns: 1fr;
  }

  .mobile-utility-head {
    align-items: flex-start;
  }

  .mobile-utility-brand {
    gap: 10px;
  }

  .mobile-utility-brand img {
    width: 44px;
    height: 44px;
  }

  .mobile-utility-brand strong {
    font-size: 0.92rem;
  }

  .mobile-utility-brand span {
    font-size: 0.74rem;
  }

  .mobile-utility-close {
    padding: 7px 10px;
    font-size: 0.82rem;
  }
}

@media (max-width: 420px) {
  .mobile-inline-actions {
    gap: 0.3rem;
  }

  .mobile-primary {
    padding: 0.62rem 0.68rem;
    font-size: 0.72rem;
  }

  .mobile-header-install {
    padding: 0 1rem 0.62rem;
  }

  .mobile-header-install-action {
    min-height: 40px;
    border-radius: 14px;
    font-size: 0.76rem;
    padding: 0.62rem 0.82rem;
  }

  .mobile-lang {
    min-width: 76px;
    padding: 0.58rem 0.45rem;
    font-size: 0.72rem;
  }

  .mobile-utility-head {
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }

  .mobile-utility-brand {
    width: 100%;
  }

  .mobile-utility-close {
    align-self: flex-end;
    min-width: 84px;
  }
}

@media (max-width: 380px) {
  .mobile-utility-brand {
    gap: 8px;
  }

  .mobile-utility-brand img {
    width: 40px;
    height: 40px;
    border-radius: 12px;
  }

  .mobile-utility-brand strong {
    font-size: 0.86rem;
  }

  .mobile-utility-brand span {
    font-size: 0.7rem;
  }

  .mobile-utility-close {
    padding: 6px 9px;
    font-size: 0.78rem;
  }
}
img.logo-image {
    width: 150px;
    /* height: 93px; */
}

.new-mobile-ui {
  display: flex;
  align-items: center;
  gap: 8px;
}

@media (min-width: 941px) {
  .new-mobile-ui {
    display: none;
  }
}

/* COMMON PILL */
.mobile-pill {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 7px 10px;
  border-radius: 14px;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
}

/* ICON */
.mobile-pill svg {
  width: 14px;
  height: 14px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
}

/* PRIMARY (Work) */
.mobile-pill.primary {
  background: linear-gradient(135deg, #7C3AED, #6D28D9);
  color: #fff;
}

/* LIGHT (Language) */
.mobile-pill.light {
  background: #F1F5F9;
  color: #0F172A;
}

.mobile-pill.light select {
  border: none;
  background: transparent;
  font-size: 11px;
  font-weight: 700;
  outline: none;
}

/* DOWNLOAD CTA */
.mobile-pill.download {
  background: #0F172A;
  color: #fff;
}
</style>

<header class="site-header">
  <nav class="top-nav" aria-label="Main navigation">
    <a href="{{ url('/home') }}" class="brand-block" aria-label="HomeEase Home">
      <img src="{{ asset('/logo.png') }}" alt="HomeEase Logo" class="logo-image">
      
    </a>

    <div class="desktop-nav">
      <a href="{{ url('/home') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home') }}</a>
      <a href="{{ url('/list') }}" class="nav-link {{ request()->is('list') ? 'active' : '' }}">{{ __('Services') }}</a>
      <a href="{{ url('/support') }}" class="nav-link {{ request()->is('support') ? 'active' : '' }}">Support</a>
      <a href="{{ url('/safty') }}" class="nav-link {{ request()->is('safty') ? 'active' : '' }}">Safety</a>
      @if (! $isAuthenticated)
        <a href="{{ route('login') }}" class="nav-link {{ request()->is('login') ? 'active' : '' }}">Login</a>
        <a href="{{ route('register', ['role' => 'user']) }}" class="nav-link {{ request()->is('register') && $registerRole !== 'provider' ? 'active' : '' }}">Register</a>
      @endif
      <a href="{{ url('/contact-us') }}" class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}">Contact Us</a>
      @if (! $isProviderAccount)
        <a href="{{ route('register', ['role' => 'provider']) }}" class="nav-link {{ request()->is('register') && $registerRole === 'provider' ? 'active' : '' }}">Work &amp; Earn</a>
      @endif
    </div>

    <div class="header-actions">
      <form class="lang-form" action="{{ route('language.switch', $currentLocale) }}" method="GET">
        <select class="lang-picker" aria-label="Select language" onchange="if (this.value) window.location.href = this.value;">
          @foreach ($languageLabels as $code => $label)
            <option value="{{ route('language.switch', $code) }}" {{ $currentLocale === $code ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </form>

    </div>

<div class="mobile-inline-actions new-mobile-ui">

  @if ($isAuthenticated)
    <a href="{{ route('my.profile') }}" class="mobile-pill primary">
      <svg viewBox="0 0 24 24">
        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
        <path d="M4 20a8 8 0 0 1 16 0"></path>
      </svg>
      <span>MyProfile</span>
    </a>
    @if (! $isProviderAccount)
      <a href="{{ route('register', ['role' => 'provider']) }}" class="mobile-pill light">
        <svg viewBox="0 0 24 24">
          <path d="M3 7h18"></path>
          <path d="M5 7v10h14V7"></path>
          <path d="M9 7V5h6v2"></path>
        </svg>
        <span>GoPro</span>
      </a>
    @endif
  @elseif (! $isProviderAccount)
    <a href="{{ route('register', ['role' => 'provider']) }}" class="mobile-pill primary">
      <svg viewBox="0 0 24 24">
        <path d="M3 7h18"></path>
        <path d="M5 7v10h14V7"></path>
        <path d="M9 7V5h6v2"></path>
      </svg>
      <span>Work&Earn</span>
    </a>
  @endif

  <!-- Language -->
  <!--<div class="mobile-pill light">-->
  <!--  <svg viewBox="0 0 24 24">-->
  <!--    <circle cx="12" cy="12" r="10"></circle>-->
  <!--    <path d="M2 12h20"></path>-->
  <!--  </svg>-->
  <!--  <select onchange="if (this.value) window.location.href = this.value;">-->
  <!--    @foreach ($languageLabels as $code => $label)-->
  <!--      <option value="{{ route('language.switch', $code) }}" {{ $currentLocale === $code ? 'selected' : '' }}>-->
  <!--        {{ $label }}-->
  <!--      </option>-->
  <!--    @endforeach-->
  <!--  </select>-->
  <!--</div>-->

  <!-- Download App -->
  <button id="mobileHeaderInstallButton" class="mobile-pill download">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <!-- download arrow -->
    <path d="M12 3v12"></path>
    <path d="m7 10 5 5 5-5"></path>
    <!-- tray -->
    <path d="M5 21h14"></path>
  </svg>
  <span> Download App</span>
</button>

</div>
    <button type="button" class="mobile-help-trigger" aria-label="Open help menu" onclick="openMobileUtilitySheet()">
      <svg viewBox="0 0 24 24"><path d="M4 7h16"></path><path d="M4 12h16"></path><path d="M4 17h16"></path></svg>
    </button>
  </nav>

<!--<div class="mobile-header-install">-->
<!--  <button type="button" id="mobileHeaderInstallButton" class="mobile-header-install-action">-->
<!--    <span class="mobile-header-install-action-label">-->
<!--      <span class="mobile-header-install-action-badge" aria-hidden="true">-->
<!--        <svg viewBox="0 0 24 24">-->
<!--          <path d="M12 3v12"></path>-->
<!--          <path d="m7 10 5 5 5-5"></path>-->
<!--          <path d="M5 21h14"></path>-->
<!--        </svg>-->
<!--      </span>-->
<!--      <span>Download App</span>-->
<!--    </span>-->
<!--  </button>-->
<!--</div>-->

  <div class="mobile-shortcuts">
    @if ($isAuthenticated)
      <a href="{{ route('my.profile') }}" class="mobile-primary">My Profile</a>
      @if (! $isProviderAccount)
        <a href="{{ route('register', ['role' => 'provider']) }}" class="mobile-primary">Register as Professional</a>
      @endif
      <form action="{{ route('logout') }}" method="POST" style="margin:0; display:flex; flex:1;">
        @csrf
        <button type="submit" class="mobile-primary" style="width:100%; border:none; background:#0F172A; cursor:pointer;">Logout</button>
      </form>
    @else
      <a href="{{ route('register', ['role' => 'provider']) }}" class="mobile-primary">Work &amp; Earn</a>
    @endif
    <select class="lang-picker mobile-lang" aria-label="Select language" onchange="if (this.value) window.location.href = this.value;">
      @foreach ($languageLabels as $code => $label)
        <option value="{{ route('language.switch', $code) }}" {{ $currentLocale === $code ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
  </div>
</header>

<nav class="bottom-nav" role="navigation" aria-label="Mobile navigation">
  <a href="{{ url('/home') }}" class="{{ request()->is('/') ? 'active' : '' }}" aria-label="Home">
    <span class="nav-icon" aria-hidden="true">
      <svg viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path></svg>
    </span>
    <span>{{ __('Home') }}</span>
  </a>

  <a href="{{ url('/list') }}" class="{{ request()->is('list') ? 'active' : '' }}" aria-label="Directory">
    <span class="nav-icon" aria-hidden="true">
      <svg viewBox="0 0 24 24"><path d="M4 7h16"></path><path d="M4 12h16"></path><path d="M4 17h16"></path></svg>
    </span>
    <span>{{ __('Services') }}</span>
  </a>

  <a href="{{ $isAuthenticated ? route('my.profile') : route('login') }}" class="{{ $isAuthenticated ? (request()->is('my-profile') ? 'active' : '') : (request()->is('login') ? 'active' : '') }}" aria-label="{{ $isAuthenticated ? 'My Profile' : 'Login' }}">
    <span class="nav-icon" aria-hidden="true">
      @if ($isAuthenticated)
        <svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path><path d="M4 20a8 8 0 0 1 16 0"></path></svg>
      @else
        <svg viewBox="0 0 24 24"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
      @endif
    </span>
    <span>{{ $isAuthenticated ? 'Profile' : 'Login' }}</span>
  </a>

  <a href="{{ url('/contact-us') }}" class="{{ request()->is('contact-us') ? 'active' : '' }}" aria-label="Contact">
    <span class="nav-icon" aria-hidden="true">
      <svg viewBox="0 0 24 24"><path d="M4 6h16v12H4z"></path><path d="m4 8 8 6 8-6"></path></svg>
    </span>
    <span>Contact</span>
  </a>

</nav>

<div class="mobile-utility-overlay" id="mobileUtilityOverlay" onclick="closeMobileUtilitySheet()"></div>

<div class="mobile-utility-sheet" id="mobileUtilitySheet" aria-hidden="true">
  <div class="mobile-utility-handle"></div>
  <div class="mobile-utility-head">
    <div class="mobile-utility-brand">
      <img src="{{ asset('/logo.png') }}" alt="HomeEase Logo">
      <div>
        <strong>Help &amp; Support</strong>
        <span>Quick access to support-related pages</span>
      </div>
    </div>
    <button type="button" class="mobile-utility-close" onclick="closeMobileUtilitySheet()">Close</button>
  </div>
  <div class="mobile-utility-grid">
    <div class="mobile-utility-card">
      <div class="mobile-utility-pill">H</div>
      <span>Help pages</span>
      <div class="mobile-utility-shortcuts">
        <a href="{{ url('/support') }}" class="mobile-utility-shortcut" onclick="closeMobileUtilitySheet()">
          <span class="shortcut-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M12 3c4.97 0 9 3.58 9 8 0 1.98-.8 3.79-2.14 5.18V21l-4.06-2.03c-.86.2-1.81.31-2.8.31-4.97 0-9-3.58-9-8s4.03-8 9-8Z"></path></svg>
          </span>
          <strong>Support</strong>
          <span>Help center</span>
        </a>
        <a href="{{ url('/safty') }}" class="mobile-utility-shortcut" onclick="closeMobileUtilitySheet()">
          <span class="shortcut-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M12 3 5 6v6c0 4.5 3 8 7 9 4-1 7-4.5 7-9V6l-7-3Z"></path><path d="M9.5 12.5 11 14l3.5-4"></path></svg>
          </span>
          <strong>Safety</strong>
          <span>Trust help</span>
        </a>
        <a href="{{ url('/messages') }}" class="mobile-utility-shortcut" onclick="closeMobileUtilitySheet()">
          <span class="shortcut-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M4 5h16v10H8l-4 4V5Z"></path></svg>
          </span>
          <strong>Messages</strong>
          <span>Support chat</span>
        </a>
        <a href="{{ url('/notifications') }}" class="mobile-utility-shortcut" onclick="closeMobileUtilitySheet()">
          <span class="shortcut-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M6 8a6 6 0 1 1 12 0c0 7 3 7 3 9H3c0-2 3-2 3-9"></path><path d="M10 20a2 2 0 0 0 4 0"></path></svg>
          </span>
          <strong>Alerts</strong>
          <span>Updates</span>
        </a>
      </div>
    </div>
  </div>
</div>
