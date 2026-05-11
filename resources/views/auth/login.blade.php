<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Smart-Hub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }

        .login-card {
            background: #fff;
            border-radius: 12px;
            padding: 40px 36px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,.4);
        }
        .logo { text-align: center; margin-bottom: 28px; }
        .logo-icon { font-size: 2.5rem; }
        .logo h1 { font-size: 1.4rem; color: #1a1a2e; margin-top: 8px; font-weight: 700; }
        .logo p { color: #888; font-size: .85rem; margin-top: 4px; }

        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: .82rem; font-weight: 600; color: #444; margin-bottom: 6px; }
        input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid #e0e0e0; border-radius: 8px;
            font-size: .95rem; transition: border-color .2s;
            outline: none;
        }
        input:focus { border-color: #0f3460; }

        .btn-login {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, #0f3460, #1a1a2e);
            color: #fff; border: none; border-radius: 8px;
            font-size: 1rem; font-weight: 600; cursor: pointer;
            transition: opacity .2s; margin-top: 4px;
        }
        .btn-login:hover { opacity: .88; }

        /* Toast popup */
        .toast {
            position: fixed; top: 24px; right: 24px;
            background: #e74c3c; color: #fff;
            padding: 14px 20px; border-radius: 8px;
            font-size: .9rem; font-weight: 500;
            box-shadow: 0 4px 16px rgba(0,0,0,.25);
            display: flex; align-items: center; gap: 10px;
            animation: slideIn .3s ease, fadeOut .4s ease 3.6s forwards;
            z-index: 9999; max-width: 320px;
        }
        .toast-icon { font-size: 1.2rem; }
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to   { opacity: 0; transform: translateX(120%); }
        }
    </style>
</head>
<body>

@if($errors->any())
<div class="toast" id="toast">
    <span class="toast-icon">⚠️</span>
    <span>{{ $errors->first() }}</span>
</div>
<script>
    setTimeout(() => {
        const t = document.getElementById('toast');
        if (t) t.remove();
    }, 4000);
</script>
@endif

<div class="login-card">
    <div class="logo">
        <div class="logo-icon">🏢</div>
        <h1>Smart-Hub Management</h1>
        <p>Portal Admin</p>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@smarthub.com" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">Masuk ke Dashboard</button>
    </form>
</div>
</body>
</html>
