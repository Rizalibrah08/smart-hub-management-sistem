@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e8f4fd">📦</div>
        <div>
            <div class="stat-value" style="color:#0f3460">{{ \App\Models\Equipment::count() }}</div>
            <div class="stat-label">Total Peralatan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#d4edda">✅</div>
        <div>
            <div class="stat-value" style="color:#27ae60">{{ \App\Models\Equipment::where('status','available')->count() }}</div>
            <div class="stat-label">Peralatan Tersedia</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3cd">⏳</div>
        <div>
            <div class="stat-value" style="color:#f39c12">{{ \App\Models\BorrowingSchedule::where('status','pending')->count() }}</div>
            <div class="stat-label">Menunggu Approval</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f8d7da">🚨</div>
        <div>
            <div class="stat-value" style="color:#e74c3c">{{ \App\Models\BorrowingSchedule::where('status','approved')->where('return_date','<',now()->toDateString())->count() }}</div>
            <div class="stat-label">Terlambat Kembali</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="page-header" style="margin-bottom:16px">
        <h2 style="font-size:1rem;font-weight:700">Peminjaman Terbaru</h2>
        <a href="{{ route('borrowing-schedules.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    <table>
        <thead>
            <tr><th>Peminjam</th><th>Peralatan</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse(\App\Models\BorrowingSchedule::with(['equipment','member'])->latest()->limit(5)->get() as $s)
            <tr>
                <td>{{ $s->member->name }}</td>
                <td>{{ $s->equipment->name }}</td>
                <td>{{ $s->borrow_date->format('d M Y') }}</td>
                <td>{{ $s->return_date->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                <td><a href="{{ route('borrowing-schedules.show', $s) }}" class="btn btn-secondary btn-sm">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#999;padding:24px">Belum ada data peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
