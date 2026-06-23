@extends('layouts.app')

@section('title', 'HomeEase | Favorites')

@section('content')
<style>
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --dark: #0F172A;
  --white: #FFFFFF;
  --bg: #FBFAFF;
  --heart: #EF4444;
  --border: #F1F5F9;
  --gray: #64748B;
}

.container { 
  padding: clamp(1rem, 4vw, 1.5rem) clamp(2rem, 6vw, 4rem); 
  max-width: 600px;
  margin: 0 auto;
}

.header-desc { 
  margin-bottom: clamp(1rem, 4vw, 1.5rem); 
  text-align: center;
}
.header-desc h1 { 
  font-size: clamp(1.3rem, 5vw, 1.6rem); 
  font-weight: 800; 
}
.header-desc p { 
  color: var(--gray); 
  font-weight: 600; 
  font-size: clamp(0.8rem, 3vw, 1rem); 
}

/* Favorite Card */
.fav-card {
  background: var(--white); 
  padding: clamp(1rem, 3vw, 1.5rem); 
  border-radius: clamp(20px, 5vw, 30px);
  margin-bottom: clamp(0.75rem, 2vw, 1rem); 
  border: 1px solid var(--border);
  display: flex; 
  align-items: center; 
  gap: clamp(0.75rem, 2vw, 1rem);
  box-shadow: 0 clamp(4px, 1vw, 8px) clamp(12px, 2vw, 20px) rgba(0,0,0,0.04);
  position: relative;
  transition: all 0.3s ease;
}
.fav-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}
.fav-heart {
  position: absolute; 
  top: clamp(8px, 2vw, 12px); 
  right: clamp(12px, 3vw, 18px);
  color: var(--heart); 
  font-size: clamp(1rem, 4vw, 1.3rem); 
  cursor: pointer;
  transition: all 0.2s;
}
.fav-heart:hover {
  transform: scale(1.2);
}

.fav-photo {
  width: clamp(50px, 15vw, 70px); 
  height: clamp(50px, 15vw, 70px); 
  border-radius: clamp(12px, 4vw, 22px);
  background: var(--primary-light); 
  display: flex;
  align-items: center; 
  justify-content: center; 
  font-size: clamp(1.4rem, 6vw, 1.9rem);
  border: 2px solid #EEE;
  flex-shrink: 0;
}

.fav-info { 
  flex-grow: 1; 
}
.fav-info h4 { 
  font-weight: 800; 
  font-size: clamp(0.95rem, 3.5vw, 1.1rem); 
  margin-bottom: clamp(2px, 0.5vw, 4px); 
}
.fav-info p { 
  font-size: clamp(0.75rem, 2.5vw, 0.85rem); 
  color: var(--gray); 
  font-weight: 700; 
}
.expert-tag {
  display: inline-block; 
  padding: clamp(3px, 1vw, 5px) clamp(8px, 2vw, 12px); 
  background: #F1F5F9;
  border-radius: clamp(6px, 1.5vw, 10px); 
  font-size: clamp(0.65rem, 2vw, 0.75rem); 
  font-weight: 800;
  color: var(--primary); 
  margin-top: clamp(4px, 1vw, 6px);
}

/* Quick Action Button */
.btn-book-again {
  background: var(--primary); 
  color: var(--white); 
  border: none;
  padding: clamp(8px, 2.5vw, 12px) clamp(14px, 4vw, 20px); 
  border-radius: clamp(10px, 2.5vw, 15px);
  font-weight: 800; 
  font-size: clamp(0.75rem, 2.5vw, 0.9rem); 
  cursor: pointer;
  transition: all 0.3s;
  white-space: nowrap;
}
.btn-book-again:hover {
  background: #6B21A8;
  transform: scale(1.05);
}
.btn-book-again:active { 
  transform: scale(0.98); 
}

/* Empty State */
.empty-fav {
  text-align: center; 
  padding: clamp(3rem, 15vh, 6rem) clamp(1rem, 5vw, 2rem); 
}
.empty-illustration {
  font-size: clamp(4rem, 20vw, 6rem);
  opacity: 0.5;
  margin-bottom: 1.5rem;
  display: block;
}
.empty-text h3 {
  font-size: clamp(1.2rem, 5vw, 1.5rem);
  font-weight: 800;
  margin-bottom: 0.5rem;
}
.empty-text p {
  font-size: clamp(0.9rem, 3vw, 1.1rem);
  color: var(--gray);
  max-width: 300px;
  margin: 0 auto 2rem;
}
.btn-add-fav {
  background: var(--primary);
  color: var(--white);
  border: none;
  padding: clamp(12px, 4vw, 16px) clamp(24px, 6vw, 32px);
  border-radius: clamp(12px, 3vw, 20px);
  font-weight: 800;
  font-size: clamp(0.9rem, 3vw, 1.1rem);
  cursor: pointer;
  transition: all 0.3s;
}
.btn-add-fav:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
}

@media (max-width: 480px) {
  .fav-card {
    gap: 1rem;
  }
  .fav-heart {
    font-size: 1.2rem;
  }
}
</style>

<div class="container">
  <div class="header-desc">
    <h1>My Favorites</h1>
    <p>Saved experts for quick access</p>
  </div>

  <div class="fav-card">
    <span class="fav-heart" onclick="removeFavorite(this)">❤️</span>
    <div class="fav-photo">👩‍🍳</div>
    <div class="fav-info">
      <h4>Sita Ram</h4>
      <p>★ 4.9 • 500m away</p>
      <span class="expert-tag">Cooking</span>
    </div>
    <button class="btn-book-again" onclick="bookExpert('Sita Ram')">Book Again</button>
  </div>

  <div class="fav-card">
    <span class="fav-heart" onclick="removeFavorite(this)">❤️</span>
    <div class="fav-photo">🧹</div>
    <div class="fav-info">
      <h4>Amit Kumar</h4>
      <p>★ 4.8 • 1.2km away</p>
      <span class="expert-tag">Cleaning</span>
    </div>
    <button class="btn-book-again" onclick="bookExpert('Amit Kumar')">Book Again</button>
  </div>

  <div class="fav-card">
    <span class="fav-heart" onclick="removeFavorite(this)">❤️</span>
    <div class="fav-photo">🌱</div>
    <div class="fav-info">
      <h4>Rahul V.</h4>
      <p>★ 4.7 • 800m away</p>
      <span class="expert-tag">Gardening</span>
    </div>
    <button class="btn-book-again" onclick="bookExpert('Rahul V.')">Book Again</button>
  </div>

  <button class="btn-add-fav" onclick="goToSearch()">
    + Add New Expert
  </button>
</div>

<div class="empty-fav">
  <span class="empty-illustration">❤️</span>
  <div class="empty-text">
    <h3>No Favorites Yet</h3>
    <p>Save experts you love for quick booking later. Find great service providers from Directory.</p>
  </div>
  <button class="btn-add-fav" onclick="goToSearch()">
    Find Experts
  </button>
</div>

<script>
let favorites = [
  'Sita Ram',
  'Amit Kumar', 
  'Rahul V.'
];

function removeFavorite(heartEl) {
  heartEl.style.color = '#D1D5DB';
  heartEl.innerHTML = '💔';
  setTimeout(() => {
    heartEl.parentElement.style.display = 'none';
    checkEmpty();
  }, 200);
}

function bookExpert(name) {
  alert(`Redirecting to book ${name}...`);
  // window.location.href = '/simple-form.html';
}

function goToSearch() {
  window.location.href = '/list';
}

function checkEmpty() {
  if (document.querySelectorAll('.fav-card').length === 0) {
    document.querySelector('.empty-fav').style.display = 'block';
  }
}

document.addEventListener('DOMContentLoaded', checkEmpty);
</script>
@endsection

