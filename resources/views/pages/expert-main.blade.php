@extends('layouts.app')

@section('title', 'HomeEase | Become Provider')

@section('content')
<style>
:root {
  --primary: #7C3AED;
  --primary-light: #F5F3FF;
  --dark: #0F172A;
  --gray: #64748B;
  --success: #22C55E;
  --white: #FFFFFF;
  --bg: #FBFAFF;
  --border: #E2E8F0;
}

.availability-section {
  background: var(--white);
  margin: clamp(1rem, 3vw, 1.5rem) clamp(1rem, 4vw, 2rem);
  padding: clamp(1.5rem, 4vw, 2rem);
  border-radius: clamp(20px, 5vw, 30px);
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 3px solid var(--primary-light);
  box-shadow: 0 clamp(8px, 2vw, 12px) clamp(20px, 4vw, 30px) rgba(124, 58, 237, 0.08);
}
.availability-text h2 { 
  font-size: clamp(1.1rem, 4vw, 1.3rem); 
  font-weight: 800; 
  color: var(--primary); 
}
.availability-text p { 
  font-size: clamp(0.8rem, 3vw, 1rem); 
  color: var(--gray); 
  font-weight: 600; 
}

.toggle-btn {
  width: clamp(60px, 18vw, 75px); 
  height: clamp(32px, 10vw, 38px); 
  background: var(--primary);
  border-radius: 50px; 
  position: relative; 
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
  transition: all 0.3s;
}
.toggle-btn:hover {
  transform: scale(1.05);
}
.toggle-circle {
  width: clamp(24px, 8vw, 30px); 
  height: clamp(24px, 8vw, 30px); 
  background: var(--white);
  border-radius: 50%; 
  position: absolute; 
  right: clamp(4px, 1.5vw, 6px); 
  top: clamp(3px, 1vw, 4px);
  transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.container { 
  padding: 0 clamp(1rem, 5vw, 2rem); 
  max-width: 600px;
  margin: 0 auto;
}
.section-title { 
  font-size: clamp(1.2rem, 4vw, 1.5rem); 
  font-weight: 800; 
  margin: clamp(1.5rem, 6vw, 2rem) 0 clamp(1rem, 3vw, 1.2rem); 
  display: flex; 
  align-items: center; 
  gap: clamp(8px, 2vw, 12px); 
}

.request-card {
  background: var(--white);
  border-radius: clamp(25px, 6vw, 35px);
  padding: clamp(1.5rem, 5vw, 2.5rem);
  border: 4px solid var(--primary);
  box-shadow: 0 clamp(12px, 3vw, 18px) clamp(30px, 6vw, 45px) rgba(124, 58, 237, 0.15);
}
.job-type { 
  background: var(--primary-light); 
  color: var(--primary); 
  padding: clamp(5px, 1.5vw, 8px) clamp(12px, 3vw, 18px); 
  border-radius: clamp(8px, 2vw, 12px); 
  font-weight: 800; 
  font-size: clamp(0.75rem, 2.5vw, 0.9rem); 
  display: inline-block; 
  margin-bottom: clamp(1rem, 3vw, 1.5rem); 
}
.client-box { 
  display: flex; 
  align-items: center; 
  gap: clamp(1rem, 3vw, 1.5rem); 
  margin-bottom: clamp(1.2rem, 4vw, 2rem); 
}
.client-avatar { 
  width: clamp(50px, 15vw, 65px); 
  height: clamp(50px, 15vw, 65px); 
  background: #F1F5F9; 
  border-radius: clamp(15px, 5vw, 22px); 
  display: flex;
  align-items: center; 
  justify-content: center; 
  font-size: clamp(1.3rem, 6vw, 1.7rem);
}
.client-name { 
  font-weight: 800; 
  font-size: clamp(1rem, 3vw, 1.2rem); 
}
.client-earn { 
  color: var(--gray); 
  font-weight: 700; 
  font-size: clamp(0.9rem, 2.5vw, 1.1rem); 
}

.address-box { 
  margin-bottom: clamp(2rem, 6vw, 3rem); 
  background: #F8FAFC; 
  padding: clamp(1rem, 3vw, 1.5rem); 
  border-radius: clamp(15px, 4vw, 24px); 
}
.address-label {
  font-size: clamp(0.75rem, 2vw, 0.95rem); 
  color: var(--gray); 
  margin-bottom: clamp(4px, 1vw, 8px); 
  font-weight: 700;
}
.address-text {
  font-size: clamp(0.95rem, 2.8vw, 1.1rem); 
  color: var(--dark); 
  font-weight: 600; 
}

/* HUGE ACTION BUTTONS */
.action-btns { 
  display: grid; 
  grid-template-columns: 1fr; 
  gap: clamp(1rem, 3vw, 1.5rem); 
}
.btn {
  padding: clamp(1.2rem, 4vw, 1.6rem); 
  border-radius: clamp(16px, 4vw, 24px); 
  border: none; 
  font-size: clamp(1rem, 3vw, 1.25rem); 
  font-weight: 800; 
  cursor: pointer;
  display: flex; 
  align-items: center; 
  justify-content: center; 
  gap: clamp(8px, 2vw, 12px); 
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.btn-accept { 
  background: linear-gradient(135deg, var(--success), #16A34A); 
  color: var(--white); 
  box-shadow: 0 clamp(10px, 3vw, 15px) clamp(25px, 5vw, 35px) rgba(34, 197, 94, 0.4);
}
.btn-accept:hover { 
  transform: scale(1.02) translateY(-2px); 
  box-shadow: 0 clamp(15px, 4vw, 25px) clamp(35px, 7vw, 50px) rgba(34, 197, 94, 0.5);
}
.btn-decline { 
  background: linear-gradient(135deg, #FEE2E2, #FECACA); 
  color: #DC2626; 
  font-size: clamp(0.95rem, 2.8vw, 1.1rem); 
  border: 2px solid #FECACA;
}
.btn-decline:hover { 
  transform: scale(1.02);
  background: #FEF2F2;
}

@media (max-width: 480px) {
  .availability-section {
    flex-direction: column;
    gap: 1rem;
    text-align: center;
  }
  .toggle-btn {
    align-self: center;
  }
}
</style>

<div class="availability-section">
  <div class="availability-text">
    <h2>I am Ready to Work</h2>
    <p>Clients can see you now</p>
  </div>
  <div class="toggle-btn" onclick="toggleWork()">
    <div class="toggle-circle" id="circle"></div>
  </div>
</div>

<div class="container">
  <h3 class="section-title">🔔 New Job Request</h3>
  
  <div class="request-card">
    <span class="job-type">HOUSE CLEANING</span>
    <div class="client-box">
      <div class="client-avatar">👨</div>
      <div>
        <h3 class="client-name">Mr. Amit Kumar</h3>
        <p class="client-earn">Earn: $20.00</p>
      </div>
    </div>

    <div class="address-box">
      <p class="address-label">📍 ADDRESS</p>
      <p class="address-text">Phase 7, Near Gurudwara, Mohali</p>
    </div>

    <div class="action-btns">
      <button class="btn btn-accept" onclick="acceptJob()">
        ✅ ACCEPT REQUEST
      </button>
      <button class="btn btn-decline" onclick="declineJob()">
        ✕ DECLINE
      </button>
    </div>
  </div>
</div>

<script>
let isWorking = true;

function toggleWork() {
  const circle = document.getElementById('circle');
  const bg = document.querySelector('.toggle-btn');
  if(isWorking) {
    circle.style.right = 'auto';
    circle.style.left = 'clamp(4px, 1.5vw, 6px)';
    bg.style.background = '#CBD5E1';
    isWorking = false;
  } else {
    circle.style.left = 'auto';
    circle.style.right = 'clamp(4px, 1.5vw, 6px)';
    bg.style.background = 'var(--primary)';
    isWorking = true;
  }
}

function acceptJob() {
  alert('✅ Job Accepted! Client will be notified.');
}

function declineJob() {
  if (confirm('Are you sure you want to decline this job?')) {
    document.querySelector('.request-card').style.opacity = '0.5';
    document.querySelector('.request-card').innerHTML += '<p style="text-align: center; color: var(--gray); font-size: 0.9rem; margin-top: 1rem;">Job declined. Check back for more requests.</p>';
  }
}
</script>
@endsection

