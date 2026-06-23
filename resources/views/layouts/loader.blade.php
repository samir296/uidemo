<!-- ================= GLOBAL LOADER ================= -->
<div id="global-loader">
  <!-- Background Shapes -->
  <div class="loader-bg-shape shape-one"></div>
  <div class="loader-bg-shape shape-two"></div>
  <div class="loader-bg-shape shape-three"></div>

  <!-- Loader Card -->
  <div class="app-loader-card">
    <div class="app-loader-logo">
      <!-- Circular Spinner -->
      <svg viewBox="0 0 120 120" class="loader-circle" aria-hidden="true">
        <circle class="loader-circle-track" cx="60" cy="60" r="44"></circle>
        <circle class="loader-circle-fill" cx="60" cy="60" r="44"></circle>
      </svg>

      <!-- Logo -->
      <div class="logo-core">
      <img src="{{ asset('logo.png') }}" alt="HomeEase logo" class="loader-logo-image">

      </div>
    </div>
  </div>
</div>

<!-- ================= STYLES ================= -->
<style>
:root {
  --loader-primary: #7C3AED;
  --loader-primary-light: #A78BFA;
  --loader-primary-soft: #DDD6FE;
  --loader-bg-1: #F8FAFC;
  --loader-bg-2: #EEF2FF;
  --loader-bg-3: #F5F3FF;
  --loader-text: #0F172A;
  --loader-muted: #64748B;
  --loader-white: #FFFFFF;
}

/* FULL SCREEN */
#global-loader {
  position: fixed;
  inset: 0;
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background:
    radial-gradient(circle at top left, rgba(124, 58, 237, 0.16), transparent 28%),
    radial-gradient(circle at bottom right, rgba(167, 139, 250, 0.18), transparent 30%),
    linear-gradient(135deg, var(--loader-bg-1) 0%, var(--loader-bg-2) 50%, var(--loader-bg-3) 100%);
  transition: opacity 0.25s ease, visibility 0.25s ease;
}

/* BACKGROUND FLOATING SHAPES */
.loader-bg-shape {
  position: absolute;
  border-radius: 50%;
  filter: blur(8px);
  opacity: 0.6;
  animation: floatShape 8s ease-in-out infinite;
}

.shape-one {
  width: 220px;
  height: 220px;
  top: 8%;
  left: 8%;
  background: radial-gradient(circle, rgba(124, 58, 237, 0.18), transparent 70%);
}

.shape-two {
  width: 280px;
  height: 280px;
  right: 6%;
  bottom: 10%;
  background: radial-gradient(circle, rgba(167, 139, 250, 0.18), transparent 72%);
  animation-delay: 1.5s;
}

.shape-three {
  width: 180px;
  height: 180px;
  bottom: 16%;
  left: 18%;
  background: radial-gradient(circle, rgba(196, 181, 253, 0.22), transparent 72%);
  animation-delay: 0.8s;
}

/* CENTER CARD */
.app-loader-card {
  display: flex;
  align-items: center;
  justify-content: center;
}

/* LOGO AREA */
.app-loader-logo {
  position: relative;
  width: 132px;
  height: 132px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* SPINNER */
.loader-circle {
  position: absolute;
  inset: 0;
  width: 132px;
  height: 132px;
  transform: rotate(-90deg);
  animation: loaderCircleSpin 1.15s linear infinite;
}

.loader-circle-track,
.loader-circle-fill {
  fill: none;
  stroke-width: 7;
  stroke-linecap: round;
}

.loader-circle-track {
  stroke: rgba(124, 58, 237, 0.12);
}

.loader-circle-fill {
  stroke: var(--loader-primary);
  stroke-dasharray: 86 190;
  stroke-dashoffset: 0;
}

/* LOGO CORE */
.logo-core {
  width: 102px;
  height: 102px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 6px;
  box-shadow: 0 10px 26px rgba(124, 58, 237, 0.12);
  animation: coreBounce 1.8s ease-in-out infinite;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.95);
}

.loader-logo-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
  filter: drop-shadow(0 8px 16px rgba(124, 58, 237, 0.12));
}

/* HIDE STATE */
#global-loader.fade-out {
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
}

/* ANIMATIONS */
@keyframes coreBounce {
  0%, 100% {
    transform: translateY(0px) scale(1);
  }
  50% {
    transform: translateY(-4px) scale(1.03);
  }
}

@keyframes loaderCircleSpin {
  0% {
    transform: rotate(-90deg);
  }
  100% {
    transform: rotate(270deg);
  }
}

@keyframes floatShape {
  0%, 100% {
    transform: translateY(0px) translateX(0px);
  }
  50% {
    transform: translateY(-12px) translateX(8px);
  }
}

/* MOBILE RESPONSIVE */
@media (max-width: 480px) {
  .app-loader-logo {
    width: 108px;
    height: 108px;
  }

  .loader-circle {
    width: 108px;
    height: 108px;
  }

  .logo-core {
    width: 82px;
    height: 82px;
  }
}
</style>

<!-- ================= SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const loader = document.getElementById('global-loader');

  // Ensure loader is visible initially
  loader.style.display = 'flex';

  // Hide loader when the page fully loads
  window.addEventListener('load', function () {
    setTimeout(() => {
      loader.classList.add('fade-out');

      // Remove loader from DOM after animation
      setTimeout(() => {
        loader.style.display = 'none';
      }, 250);
    }, 1000); // Adjust delay as needed
  });
});
</script>