<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Smart-Hub Member</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 240px; min-height: 100vh; background: linear-gradient(180deg, #1e8449 0%, #145a32 100%); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
        .sidebar-brand { padding: 24px 20px 20px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-brand .icon { font-size: 1.6rem; }
        .sidebar-brand h2 { font-size: 1rem; font-weight: 700; color: #fff; margin-top: 6px; }
        .sidebar-brand p { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 16px 0; }
        .nav-section { padding: 8px 20px 4px; font-size: .68rem; font-weight: 700; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .08em; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: rgba(255,255,255,.75); text-decoration: none; font-size: .88rem; transition: background .15s; border-left: 3px solid transparent; }
        .nav-item:hover { background: rgba(255,255,255,.1); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,.15); color: #fff; border-left-color: #a9dfbf; }
        .nav-item .icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.1); }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: #a9dfbf; color: #145a32; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .9rem; flex-shrink: 0; }
        .user-name { font-size: .82rem; color: #fff; font-weight: 600; }
        .user-role { font-size: .72rem; color: rgba(255,255,255,.5); }
        .btn-logout { width: 100%; padding: 8px; background: rgba(231,76,60,.15); color: #f1948a; border: 1px solid rgba(231,76,60,.3); border-radius: 6px; font-size: .82rem; cursor: pointer; }
        .btn-logout:hover { background: rgba(231,76,60,.3); }
        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 14px 28px; border-bottom: 1px solid #e8ecf0; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; }
        .topbar-breadcrumb { font-size: .8rem; color: #888; margin-top: 2px; }
        .content { padding: 24px 28px; flex: 1; }
        .card { background: #fff; border-radius: 10px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); margin-bottom: 20px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-header h1 { font-size: 1.3rem; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 11px 14px; text-align: left; border-bottom: 1px solid #f0f0f0; font-size: .88rem; }
        th { background: #fafafa; font-weight: 600; color: #555; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; }
        tr:hover td { background: #f9fff9; }
        .btn { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: 6px; text-decoration: none; font-size: .83rem; font-weight: 500; border: none; cursor: pointer; transition: opacity .15s; }
        .btn:hover { opacity: .85; }
        .btn-primary { background: #27ae60; color: #fff; }
        .btn-secondary { background: #ecf0f1; color: #555; }
        .btn-sm { padding: 5px 10px; font-size: .78rem; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: .83rem; font-weight: 600; color: #444; margin-bottom: 5px; }
        input[type=text], input[type=number], input[type=date], input[type=email], select, textarea { width: 100%; padding: 9px 12px; border: 1.5px solid #e0e0e0; border-radius: 7px; font-size: .9rem; outline: none; transition: border-color .2s; }
        input:focus, select:focus, textarea:focus { border-color: #27ae60; }
        .error-text { color: #e74c3c; font-size: .78rem; margin-top: 3px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .75rem; font-weight: 600; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-returned { background: #cce5ff; color: #004085; }
        .badge-overdue { background: #f8d7da; color: #721c24; }
        .stat-card { background: #fff; border-radius: 10px; padding: 20px 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
        .stat-label { font-size: .82rem; color: #888; margin-top: 4px; }
        .toast { position: fixed; top: 20px; right: 20px; padding: 14px 20px; border-radius: 8px; font-size: .88rem; font-weight: 500; box-shadow: 0 4px 20px rgba(0,0,0,.2); display: flex; align-items: center; gap: 10px; animation: toastIn .3s ease, toastOut .4s ease 3.6s forwards; z-index: 9999; }
        .toast-success { background: #27ae60; color: #fff; }
        .toast-error { background: #e74c3c; color: #fff; }
        @keyframes toastIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes toastOut { from { opacity: 1; } to { opacity: 0; transform: translateX(120%); } }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="icon">🌿</div>
        <h2>Smart-Hub</h2>
        <p>Portal Anggota</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Menu</div>
        <a href="{{ route('member.dashboard') }}" class="nav-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>
        <div class="nav-section" style="margin-top:8px">Peminjaman</div>
        <a href="{{ route('member.borrowings.index') }}" class="nav-item {{ request()->routeIs('member.borrowings.index') ? 'active' : '' }}">
            <span class="icon">📋</span> Peminjaman Saya
        </a>
        <a href="{{ route('member.borrowings.create') }}" class="nav-item {{ request()->routeIs('member.borrowings.create') ? 'active' : '' }}">
            <span class="icon">➕</span> Ajukan Peminjaman
        </a>
        <div class="nav-section" style="margin-top:8px">Lainnya</div>
        <a href="{{ route('member.notifications.index') }}" class="nav-item {{ request()->routeIs('member.notifications.*') ? 'active' : '' }}">
            <span class="icon">🔔</span> Notifikasi
            @php $unread = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count(); @endphp
            @if($unread > 0)
                <span style="background:#e74c3c;color:#fff;border-radius:10px;padding:1px 7px;font-size:.7rem;margin-left:auto">{{ $unread }}</span>
            @endif
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Anggota</div>
            </div>
        </div>
        <form method="POST" action="{{ route('member.logout') }}">
            @csrf
            <button type="submit" class="btn-logout">🚪 Keluar</button>
        </form>
    </div>
</aside>
<div class="main-wrapper">
    <div class="topbar">
        <div class="topbar-title">@yield('title', 'Dashboard')</div>
        <div class="topbar-breadcrumb">Smart-Hub › @yield('title', 'Dashboard')</div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="toast toast-success" id="toast">✅ {{ session('success') }}</div>
            <script>setTimeout(() => { const t = document.getElementById('toast'); if(t) t.remove(); }, 4000);</script>
        @endif
        @if(session('error'))
            <div class="toast toast-error" id="toast">❌ {{ session('error') }}</div>
            <script>setTimeout(() => { const t = document.getElementById('toast'); if(t) t.remove(); }, 4000);</script>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>
