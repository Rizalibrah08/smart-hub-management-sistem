@extends('member.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-icon" style="background:#d4edda">📋</div>
        <div>
            <div class="stat-value" style="color:#27ae60">{{ $totalBorrowings }}</div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3cd">⏳</div>
        <div>
            <div class="stat-value" style="color:#f39c12">{{ $pendingCount }}</div>
            <div class="stat-label">Menunggu Approval</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#cce5ff">✅</div>
        <div>
            <div class="stat-value" style="color:#004085">{{ $approvedCount }}</div>
            <div class="stat-label">Sedang Dipinjam</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f8d7da">🔔</div>
        <div>
            <div class="stat-value" style="color:#e74c3c">{{ $unreadNotifications }}</div>
            <div class="stat-label">Notifikasi Belum Dibaca</div>
        </div>
    </div>
</div>
<div class="card">
    <div class="page-header" style="margin-bottom:16px">
        <h2 style="font-size:1rem;font-weight:700">Peminjaman Terbaru</h2>
        <a href="{{ route('member.borrowings.create') }}" class="btn btn-primary btn-sm">+ Ajukan Peminjaman</a>
    </div>
    <table>
        <thead>
            <tr><th>Peralatan</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($recentBorrowings as $b)
            <tr>
                <td>{{ $b->equipment->name }}</td>
                <td>{{ $b->borrow_date->format('d M Y') }}</td>
                <td>{{ $b->return_date->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td><a href="{{ route('member.borrowings.show', $b) }}" class="btn btn-secondary btn-sm">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#999;padding:24px">
                Belum ada peminjaman. <a href="{{ route('member.borrowings.create') }}" style="color:#27ae60">Ajukan sekarang</a>.
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
