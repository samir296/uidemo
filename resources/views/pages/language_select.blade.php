<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeEase | Choose Language</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7C3AED;
            --primary-light: #F5F3FF;
            --dark: #0F172A;
            --white: #FFFFFF;
            --bg: #FBFAFF;
            --border: #E2E8F0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg); color: var(--dark); }

        nav {
            background: var(--white); padding: 20px 8%;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 2px solid var(--primary-light);
        }

        .container { padding: 30px 8%; }

        .header-section { text-align: center; margin-bottom: 30px; }
        .header-section h1 { font-size: 1.6rem; font-weight: 800; margin-bottom: 8px; }
        .header-section p { color: #64748B; font-weight: 600; font-size: 0.9rem; }

        /* --- Language Grid --- */
        .lang-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 15px;
        }

        .lang-card {
            background: var(--white); padding: 25px 15px; border-radius: 30px;
            border: 2px solid var(--border); text-align: center;
            cursor: pointer; transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative; overflow: hidden;
        }

        .lang-card.active {
            border-color: var(--primary);
            background: var(--primary-light);
            transform: scale(1.05);
        }

        .lang-card .flag { font-size: 2.2rem; display: block; margin-bottom: 10px; }
        .lang-card .native-name { font-size: 1.1rem; font-weight: 800; display: block; color: var(--dark); }
        .lang-card .english-name { font-size: 0.75rem; font-weight: 700; color: #94A3B8; text-transform: uppercase; }

        .check-mark {
            position: absolute; top: 10px; right: 10px;
            background: var(--primary); color: white;
            width: 22px; height: 22px; border-radius: 50%;
            display: none; align-items: center; justify-content: center; font-size: 0.7rem;
        }
        .lang-card.active .check-mark { display: flex; }

        /* --- Confirm Button --- */
        .btn-confirm {
            background: var(--primary); color: white; border: none;
            padding: 22px; border-radius: 22px; width: 100%;
            font-size: 1.1rem; font-weight: 800; cursor: pointer;
            margin-top: 40px; box-shadow: 0 10px 20px rgba(124, 58, 237, 0.2);
        }
    </style>
</head>
<body>
@include('layouts.header')

    <nav>
        <a href="settings.html" style="text-decoration: none; font-size: 1.5rem; color: var(--primary);">←</a>
        <h3 style="font-weight: 800;">Language</h3>
        <div style="width: 40px;"></div>
    </nav>

    <div class="container">
        <div class="header-section">
            <h1>Select Language</h1>
            <p>Choose your preferred language</p>
        </div>

        <div class="lang-grid">
            <div class="lang-card active" onclick="selectLang(this)">
                <div class="check-mark">✓</div>
                <span class="flag">🇺🇸</span>
                <span class="native-name">English</span>
                <span class="english-name">English</span>
            </div>

            <div class="lang-card" onclick="selectLang(this)">
                <div class="check-mark">✓</div>
                <span class="flag">🇮🇳</span>
                <span class="native-name">हिन्दी</span>
                <span class="english-name">Hindi</span>
            </div>

            <div class="lang-card" onclick="selectLang(this)">
                <div class="check-mark">✓</div>
                <span class="flag">🌾</span>
                <span class="native-name">ਪੰਜਾਬੀ</span>
                <span class="english-name">Punjabi</span>
            </div>

            <div class="lang-card" onclick="selectLang(this)">
                <div class="check-mark">✓</div>
                <span class="flag">🇪🇸</span>
                <span class="native-name">Español</span>
                <span class="english-name">Spanish</span>
            </div>
        </div>

        <button class="btn-confirm" onclick="alert('Language Updated!')">
            CONFIRM SELECTION
        </button>
    </div>

    <script>
        function selectLang(element) {
            // Remove active class from all
            document.querySelectorAll('.lang-card').forEach(card => {
                card.classList.remove('active');
            });
            // Add to clicked
            element.classList.add('active');
        }
    </script>

</body>
</html>