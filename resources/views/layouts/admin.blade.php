<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Smart-Hub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #333; display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px; min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: #cdd6f4; display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-icon { font-size: 1.6rem; }
        .sidebar-brand h2 { font-size: 1rem; font-weight: 700; color: #fff; margin-top: 6px; line-height: 1.3; }
        .sidebar-brand p { font-size: .72rem; color: #7f8fa6; margin-top: 2px; }

        .sidebar-nav { flex: 1; padding: 16px 0; }
        .nav-section { padding: 8px 20px 4px; font-size: .68rem; font-weight: 700; color: #7f8fa6; text-transform: uppercase; letter-spacing: .08em; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px; color: #b0bec5; text-decoration: none;
            font-size: .88rem; transition: background .15s, color .15s;
            border-left: 3px solid transparent;
        }
        .nav-item:hover { background: rgba(255,255,255,.06); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,.1); color: #fff; border-left-color: #4fc3f7; }
        .nav-item .icon { font-size: 1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: #4fc3f7; color: #1a1a2e;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .9rem; flex-shrink: 0;
        }
        .user-name { font-size: .82rem; color: #fff; font-weight: 600; }
        .user-role { font-size: .72rem; color: #7f8fa6; }
        .btn-logout {
            width: 100%; padding: 8px; background: rgba(231,76,60,.15);
            color: #e74c3c; border: 1px solid rgba(231,76,60,.3);
            border-radius: 6px; font-size: .82rem; cursor: pointer;
            transition: background .15s;
        }
        .btn-logout:hover { background: rgba(231,76,60,.3); }

        /* ── Main content ── */
        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: #fff; padding: 14px 28px;
            border-bottom: 1px solid #e8ecf0;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; }
        .topbar-breadcrumb { font-size: .8rem; color: #888; margin-top: 2px; }

        .content { padding: 24px 28px; flex: 1; }

        /* ── Components ── */
        .card { background: #fff; border-radius: 10px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); margin-bottom: 20px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-header h1 { font-size: 1.3rem; font-weight: 700; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 11px 14px; text-align: left; border-bottom: 1px solid #f0f0f0; font-size: .88rem; }
        th { background: #fafafa; font-weight: 600; color: #555; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; }
        tr:hover td { background: #fafcff; }

        .btn { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: 6px; text-decoration: none; font-size: .83rem; font-weight: 500; border: none; cursor: pointer; transition: opacity .15s; }
        .btn:hover { opacity: .85; }
        .btn-primary   { background: #0f3460; color: #fff; }
        .btn-success   { background: #27ae60; color: #fff; }
        .btn-warning   { background: #f39c12; color: #fff; }
        .btn-danger    { background: #e74c3c; color: #fff; }
        .btn-secondary { background: #ecf0f1; color: #555; }
        .btn-sm { padding: 5px 10px; font-size: .78rem; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: .88rem; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #27ae60; }
        .alert-error   { background: #f8d7da; color: #721c24; border-left: 4px solid #e74c3c; }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: .83rem; font-weight: 600; color: #444; margin-bottom: 5px; }
        input[type=text], input[type=number], input[type=date], input[type=email],
        select, textarea {
            width: 100%; padding: 9px 12px;
            border: 1.5px solid #e0e0e0; border-radius: 7px;
            font-size: .9rem; outline: none; transition: border-color .2s;
            background: #fff;
        }
        input:focus, select:focus, textarea:focus { border-color: #0f3460; }
        .error-text { color: #e74c3c; font-size: .78rem; margin-top: 3px; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .75rem; font-weight: 600; }
        .badge-available   { background: #d4edda; color: #155724; }
        .badge-in_use      { background: #cce5ff; color: #004085; }
        .badge-maintenance { background: #fff3cd; color: #856404; }
        .badge-damaged     { background: #f8d7da; color: #721c24; }
        .badge-pending     { background: #fff3cd; color: #856404; }
        .badge-approved    { background: #d4edda; color: #155724; }
        .badge-returned    { background: #cce5ff; color: #004085; }
        .badge-overdue     { background: #f8d7da; color: #721c24; }

        .flex { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

        .stat-card { background: #fff; border-radius: 10px; padding: 20px 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
        .stat-label { font-size: .82rem; color: #888; margin-top: 4px; }

        .pagination { margin-top: 16px; }
        .pagination nav { display: flex; gap: 4px; }

        /* Toast */
        .toast {
            position: fixed; top: 20px; right: 20px;
            padding: 14px 20px; border-radius: 8px;
            font-size: .88rem; font-weight: 500;
            box-shadow: 0 4px 20px rgba(0,0,0,.2);
            display: flex; align-items: center; gap: 10px;
            animation: toastIn .3s ease, toastOut .4s ease 3.6s forwards;
            z-index: 9999; max-width: 340px;
        }
        .toast-success { background: #27ae60; color: #fff; }
        .toast-error   { background: #e74c3c; color: #fff; }
        @keyframes toastIn  { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes toastOut { from { opacity: 1; } to { opacity: 0; transform: translateX(120%); } }
    </style>
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🏢</div>
        <h2>Smart-Hub</h2>
        <p>Management System</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>

        <div class="nav-section" style="margin-top:8px">Inventaris</div>
        <a href="{{ route('equipments.index') }}" class="nav-item {{ request()->routeIs('equipments.*') ? 'active' : '' }}">
            <span class="icon">🔧</span> Peralatan
        </a>

        <div class="nav-section" style="margin-top:8px">Peminjaman</div>
        <a href="{{ route('borrowing-schedules.index') }}" class="nav-item {{ request()->routeIs('borrowing-schedules.*') ? 'active' : '' }}">
            <span class="icon">📋</span> Jadwal Peminjaman
        </a>
        <a href="{{ route('borrowing-schedules.index', ['status'=>'pending']) }}" class="nav-item">
            <span class="icon">⏳</span> Menunggu Approval
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">🚪 Keluar</button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="main-wrapper">
    <div class="topbar">
        <div>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-breadcrumb">Smart-Hub Admin › @yield('title', 'Dashboard')</div>
        </div>
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
