@extends('layouts.app')

@section('title', 'HomeEase | Messages')

@section('content')
<style>
body {
  background:
    radial-gradient(circle at top left, rgba(14, 165, 233, 0.10), transparent 24%),
    linear-gradient(180deg, #FCFEFF 0%, #F8FAFC 100%);
}

.messages-shell {
  max-width: 980px;
  margin: 0 auto;
  padding: 1rem;
}

.messages-layout {
  display: grid;
  grid-template-columns: 340px 1fr;
  gap: 1rem;
}

.pane {
  background: rgba(255,255,255,0.95);
  border: 1px solid rgba(226,232,240,0.96);
  border-radius: 28px;
  padding: 1rem;
  box-shadow: 0 22px 55px rgba(15,23,42,0.06);
}

.thread-list,
.chat-stream {
  display: grid;
  gap: 0.8rem;
}

.thread,
.bubble {
  border: 1px solid #E2E8F0;
  border-radius: 18px;
  padding: 0.9rem;
  background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
}

.thread strong,
.bubble strong {
  display: block;
  color: #0F172A;
  margin-bottom: 0.25rem;
}

.thread p,
.bubble p {
  margin: 0;
  color: #64748B;
  line-height: 1.55;
}

.composer {
  margin-top: 1rem;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 0.8rem;
}

.composer input {
  width: 100%;
  border: 1.5px solid #E2E8F0;
  border-radius: 18px;
  padding: 0.95rem 1rem;
  font: inherit;
}

.composer button {
  border: none;
  border-radius: 18px;
  padding: 0.95rem 1.2rem;
  background: #7C3AED;
  color: white;
  font-weight: 800;
}

@media (max-width: 900px) {
  .messages-layout {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .messages-shell {
    padding: 0.85rem;
  }

  .pane {
    border-radius: 22px;
    padding: 1rem;
  }

  .composer {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="messages-shell">
  <div class="messages-layout">
    <div class="pane">
      <h1 style="margin-top:0;color:#0F172A;">Messages</h1>
      <div class="thread-list">
        <div class="thread">
          <strong>Riya Sharma</strong>
          <p>Confirmed the cooking visit for tomorrow morning.</p>
        </div>
        <div class="thread">
          <strong>Support Team</strong>
          <p>Your refund request is under review.</p>
        </div>
        <div class="thread">
          <strong>Amit Singh</strong>
          <p>Please share gate or floor access before arrival.</p>
        </div>
      </div>
    </div>

    <div class="pane">
      <h2 style="margin-top:0;color:#0F172A;">Conversation</h2>
      <div class="chat-stream">
        <div class="bubble">
          <strong>You</strong>
          <p>Please arrive between 9 and 10 AM if possible.</p>
        </div>
        <div class="bubble">
          <strong>Provider</strong>
          <p>Yes, that timing works. I will call once I am nearby.</p>
        </div>
      </div>

      <div class="composer">
        <input type="text" placeholder="Type a message">
        <button type="button">Send</button>
      </div>
    </div>
  </div>
</div>
@endsection
