<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member — Smart-Hub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #0f3460 0%, #16213e 50%, #1a1a2e 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border-radius: 12px; padding: 40px 36px; width: 100%; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,.4); }
        .logo { text-align: center; margin-bottom: 28px; }
        .logo-icon { font-size: 2.5rem; }
        .logo h1 { font-size: 1.3rem; color: #1a1a2e; margin-top: 8px; font-weight: 700; }
        .logo p { color: #888; font-size: .82rem; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: .82rem; font-weight: 600; color: #444; margin-bottom: 6px; }
        input { width: 100%; padding: 11px 14px; border: 1.5px solid #e0e0e0; border-radius: 8px; font-size: .95rem; outline: none; transition: border-color .2s; }
        input:focus { border-color: #27ae60; }
        .btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #27ae60, #1e8449); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 4px; }
        .btn:hover { opacity: .88; }
        .admin-link { text-align: center; margin-top: 16px; font-size: .82rem; color: #888; }
        .admin-link a { color: #0f3460; text-decoration: none; font-weight: 600; }
        .toast { position: fixed; top: 24px; right: 24px; background: #e74c3c; color: #fff; padding: 14px 20px; border-radius: 8px; font-size: .9rem; font-weight: 500; box-shadow: 0 4px 16px rgba(0,0,0,.25); display: flex; align-items: center; gap: 10px; animation: slideIn .3s ease, fadeOut .4s ease 3.6s forwards; z-index: 9999; }
        @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; transform: translateX(120%); } }
    </style>
</head>
<body>
@if($errors->any())
<div class="toast" id="toast">⚠️ {{ $errors->first() }}</div>
<script>setTimeout(() => { const t = document.getElementById('toast'); if(t) t.remove(); }, 4000);</script>
@endif
<div class="card">
    <div class="logo">
        <div class="logo-icon">👤</div>
        <h1>Portal Anggota</h1>
        <p>Smart-Hub Management System</p>
    </div>
    <form method="POST" action="{{ route('member.login') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn">Masuk</button>
    </form>
    <div class="admin-link">Login sebagai Admin? <a href="{{ route('login') }}">Klik di sini</a></div>
</div>
</body>
</html>
