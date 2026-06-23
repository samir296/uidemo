<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeEase | Account Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7C3AED;
            --primary-light: #F5F3FF;
            --dark: #0F172A;
            --gray: #64748B;
            --white: #FFFFFF;
            --border: #F1F5F9;
            --bg: #FBFAFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.10), transparent 24%),
                linear-gradient(180deg, #FCFBFF 0%, var(--bg) 100%);
            color: var(--dark);
        }

        /* --- Settings Layout --- */
        .settings-wrapper {
            max-width: 980px;
            margin: 20px auto 36px;
            padding: 0 4%;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 18px;
        }

        .settings-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: rgba(255,255,255,0.72);
            border: 1px solid rgba(241,245,249,0.98);
            border-radius: 22px;
            padding: 12px;
            height: fit-content;
            position: sticky;
            top: 84px;
            backdrop-filter: blur(14px);
        }
        .nav-btn {
            padding: 11px 12px; text-decoration: none; color: var(--gray);
            font-weight: 700; font-size: 0.82rem; border-radius: 12px;
            transition: 0.3s;
        }
        .nav-btn:hover { background: var(--primary-light); color: var(--primary); }
        .nav-btn.active { background: var(--white); color: var(--primary); box-shadow: 0 8px 18px rgba(15,23,42,0.05); }

        .settings-main {
            display: grid;
            gap: 14px;
        }

        /* --- Content Sections --- */
        .settings-card {
            background: var(--white);
            padding: 22px;
            border-radius: 22px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 30px rgba(15,23,42,0.04);
        }

        .settings-card.compact {
            padding: 18px;
        }

        .settings-kicker {
            display: inline-flex;
            align-items: center;
            padding: 7px 10px;
            border-radius: 999px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.72rem;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 0 10px;
            border-radius: 999px;
            background: #ECFDF5;
            color: #047857;
            font-size: 0.74rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .section-h { font-size: 1.18rem; font-weight: 800; margin-bottom: 8px; }
        .section-copy { color: var(--gray); font-size: 0.88rem; line-height: 1.55; margin-bottom: 20px; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; }
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-group label { font-size: 0.72rem; font-weight: 800; color: var(--gray); text-transform: uppercase; }
        .input-group input {
            padding: 12px 13px; border-radius: 12px; border: 1.5px solid var(--border);
            outline: none; font-size: 0.92rem; transition: 0.3s;
            background: #FCFCFF;
        }
        .input-group input:focus { border-color: var(--primary); }

        /* --- Address Cards --- */
        .address-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px; border: 1.5px solid var(--border); border-radius: 16px;
            margin-bottom: 10px;
            background: #FCFCFF;
        }
        .address-info h4 { font-weight: 800; font-size: 0.92rem; }
        .address-info p { font-size: 0.8rem; color: var(--gray); }

        .address-view,
        .address-edit {
            width: 100%;
        }

        .address-edit {
            display: none;
            gap: 10px;
        }

        .address-edit.active {
            display: grid;
        }

        .address-item.editing .address-view {
            display: none;
        }

        .address-item.editing .address-actions .edit-link[data-mode="edit"] {
            display: none;
        }

        .address-field {
            width: 100%;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            outline: none;
            font-size: 0.86rem;
            background: #FFFFFF;
            color: var(--dark);
        }

        .address-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .edit-link {
            background: none;
            border: none;
            color: var(--primary);
            font-weight: 700;
            cursor: pointer;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .edit-link.cancel {
            color: var(--gray);
        }

        .edit-link.save-inline {
            display: none;
        }

        .address-item.editing .edit-link.save-inline,
        .address-item.editing .edit-link.cancel {
            display: inline-flex;
        }

        .btn-save {
            background: var(--primary); color: white; border: none;
            padding: 13px 22px; border-radius: 14px; font-weight: 800;
            cursor: pointer; transition: 0.3s; margin-top: 12px; font-size: 0.86rem;
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(124, 58, 237, 0.2); }

        @media (max-width: 850px) {
            .settings-wrapper { grid-template-columns: 1fr; }
            .settings-nav {
                flex-direction: row;
                overflow-x: auto;
                padding: 8px;
                position: static;
                border-radius: 18px;
                scrollbar-width: none;
            }
            .settings-nav::-webkit-scrollbar { display: none; }
            .nav-btn { white-space: nowrap; }
        }

        @media (max-width: 640px) {
            .settings-wrapper { margin: 14px auto 24px; padding: 0 10px; gap: 12px; }
            .settings-card { padding: 14px; border-radius: 18px; }
            .settings-card.compact { padding: 14px; }
            .page-head,
            .card-head { flex-direction: column; align-items: flex-start; }
            .section-h { font-size: 1.08rem; }
            .section-copy { font-size: 0.82rem; margin-bottom: 16px; }
            .form-row { grid-template-columns: 1fr; gap: 12px; margin-bottom: 12px; }
            .input-group input { font-size: 0.88rem; padding: 11px 12px; }
            .address-item { padding: 12px; align-items: flex-start; gap: 10px; border-radius: 14px; }
            .address-item button { padding: 0; }
            .address-actions { width: 100%; justify-content: flex-end; }
            .btn-save { width: 100%; min-height: 42px; }
        }
    </style>
</head>
<body>

@include('layouts.header')

    <div class="settings-wrapper">
        <aside class="settings-nav">
            <a href="#" class="nav-btn active">Personal Info</a>
            <a href="#" class="nav-btn">Saved Addresses</a>
            <a href="#" class="nav-btn">Payment Methods</a>
            <a href="#" class="nav-btn">Password & Security</a>
            <a href="#" class="nav-btn" style="color: #EF4444; margin-top: 20px;">Delete Account</a>
        </aside>

        <main class="settings-main">
            <section class="settings-card">
                <div class="page-head">
                    <div>
                        <div class="settings-kicker">Account Settings</div>
                        <h2 class="section-h">Personal Information</h2>
                        <p class="section-copy">Update the basic details used across your HomeEase account.</p>
                    </div>
                    <span class="status-chip">Profile active</span>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label>First Name</label>
                        <input type="text" value="Alex">
                    </div>
                    <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" value="Johnson">
                    </div>
                </div>

                <div class="input-group" style="margin-bottom: 16px;">
                    <label>Email Address</label>
                    <input type="email" value="alex.j@example.com">
                </div>

                <div class="input-group" style="margin-bottom: 0;">
                    <label>Phone Number</label>
                    <input type="tel" value="+91 98765 43210">
                </div>
            </section>

            <section class="settings-card compact">
                <div class="card-head">
                    <div>
                        <h2 class="section-h">Saved Addresses</h2>
                        <p class="section-copy" style="margin-bottom:0;">Keep your common locations ready for faster bookings.</p>
                    </div>
                    <button class="edit-link">Add New</button>
                </div>

                <div class="address-item" data-address-item>
                    <div class="address-info">
                        <div class="address-view">
                            <h4 data-address-title>Home</h4>
                            <p data-address-text>Sector 67, Mohali, Punjab - 160062</p>
                        </div>
                        <div class="address-edit">
                            <input class="address-field" type="text" value="Home" data-address-title-input>
                            <input class="address-field" type="text" value="Sector 67, Mohali, Punjab - 160062" data-address-text-input>
                        </div>
                    </div>
                    <div class="address-actions">
                        <button class="edit-link" type="button" data-mode="edit" onclick="editAddress(this)">Edit</button>
                        <button class="edit-link save-inline" type="button" onclick="saveAddress(this)">Save</button>
                        <button class="edit-link cancel" type="button" onclick="cancelAddressEdit(this)">Cancel</button>
                    </div>
                </div>

                <div class="address-item" style="margin-bottom:0;" data-address-item>
                    <div class="address-info">
                        <div class="address-view">
                            <h4 data-address-title>Work</h4>
                            <p data-address-text>QuarkCity Office, Phase 8B, Mohali</p>
                        </div>
                        <div class="address-edit">
                            <input class="address-field" type="text" value="Work" data-address-title-input>
                            <input class="address-field" type="text" value="QuarkCity Office, Phase 8B, Mohali" data-address-text-input>
                        </div>
                    </div>
                    <div class="address-actions">
                        <button class="edit-link" type="button" data-mode="edit" onclick="editAddress(this)">Edit</button>
                        <button class="edit-link save-inline" type="button" onclick="saveAddress(this)">Save</button>
                        <button class="edit-link cancel" type="button" onclick="cancelAddressEdit(this)">Cancel</button>
                    </div>
                </div>
            </section>

            <button class="btn-save" onclick="alert('Profile Updated Successfully!')">Save Changes</button>
        </main>
    </div>

    <script>
        function editAddress(button) {
            const item = button.closest('[data-address-item]');
            if (!item) return;

            item.classList.add('editing');
            item.querySelector('.address-edit')?.classList.add('active');
            item.querySelector('[data-address-title-input]')?.focus();
        }

        function saveAddress(button) {
            const item = button.closest('[data-address-item]');
            if (!item) return;

            const titleInput = item.querySelector('[data-address-title-input]');
            const textInput = item.querySelector('[data-address-text-input]');
            const titleView = item.querySelector('[data-address-title]');
            const textView = item.querySelector('[data-address-text]');

            if (titleInput && titleView) {
                titleView.textContent = titleInput.value.trim() || 'Address';
            }

            if (textInput && textView) {
                textView.textContent = textInput.value.trim() || 'Add address details';
            }

            item.classList.remove('editing');
            item.querySelector('.address-edit')?.classList.remove('active');
        }

        function cancelAddressEdit(button) {
            const item = button.closest('[data-address-item]');
            if (!item) return;

            const titleInput = item.querySelector('[data-address-title-input]');
            const textInput = item.querySelector('[data-address-text-input]');
            const titleView = item.querySelector('[data-address-title]');
            const textView = item.querySelector('[data-address-text]');

            if (titleInput && titleView) {
                titleInput.value = titleView.textContent.trim();
            }

            if (textInput && textView) {
                textInput.value = textView.textContent.trim();
            }

            item.classList.remove('editing');
            item.querySelector('.address-edit')?.classList.remove('active');
        }
    </script>

</body>
</html>
