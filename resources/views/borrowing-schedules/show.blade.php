@extends('layouts.admin')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="flex mb-16">
    <h1 style="flex:1">Detail Peminjaman #{{ $borrowingSchedule->id }}</h1>
    <a href="{{ route('borrowing-schedules.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card mb-16">
    <table>
        <tr><th style="width:200px">Peminjam</th><td>{{ $borrowingSchedule->member->name }} ({{ $borrowingSchedule->member->email }})</td></tr>
        <tr><th>Peralatan</th><td>{{ $borrowingSchedule->equipment->code }} — {{ $borrowingSchedule->equipment->name }}</td></tr>
        <tr><th>Tanggal Pinjam</th><td>{{ $borrowingSchedule->borrow_date->format('d M Y') }}</td></tr>
        <tr><th>Tanggal Kembali</th><td>{{ $borrowingSchedule->return_date->format('d M Y') }}</td></tr>
        <tr><th>Tanggal Kembali Aktual</th><td>{{ $borrowingSchedule->actual_return_date?->format('d M Y') ?? '-' }}</td></tr>
        <tr><th>Jumlah Dipinjam</th><td>{{ $borrowingSchedule->quantity_borrowed }}</td></tr>
        <tr><th>Status</th><td><span class="badge badge-{{ $borrowingSchedule->status }}">{{ ucfirst($borrowingSchedule->status) }}</span></td></tr>
        <tr><th>Tujuan</th><td>{{ $borrowingSchedule->purpose ?? '-' }}</td></tr>
        <tr><th>Catatan</th><td>{{ $borrowingSchedule->notes ?? '-' }}</td></tr>
    </table>

    @if($borrowingSchedule->status === 'pending')
    <div class="flex" style="margin-top:16px">
        <form method="POST" action="{{ route('borrowing-schedules.approve', $borrowingSchedule) }}">
            @csrf @method('PUT')
            <button type="submit" class="btn btn-success">Setujui Peminjaman</button>
        </form>
        <form method="POST" action="{{ route('borrowing-schedules.reject', $borrowingSchedule) }}" onsubmit="return confirm('Tolak peminjaman ini?')">
            @csrf @method('PUT')
            <button type="submit" class="btn btn-danger">Tolak Peminjaman</button>
        </form>
    </div>
    @endif
</div>

@if($borrowingSchedule->checkIns->count())
<div class="card">
    <h2 style="font-size:1.1rem;margin-bottom:12px">Riwayat Check-in</h2>
    <table>
        <thead>
            <tr><th>Tipe</th><th>Status</th><th>Waktu</th><th>Disetujui Oleh</th><th>Catatan Kondisi</th></tr>
        </thead>
        <tbody>
            @foreach($borrowingSchedule->checkIns as $ci)
            <tr>
                <td>{{ ucfirst($ci->check_in_type) }}</td>
                <td><span class="badge badge-{{ $ci->status === 'approved' ? 'approved' : ($ci->status === 'rejected' ? 'overdue' : 'pending') }}">{{ ucfirst(str_replace('_',' ',$ci->status)) }}</span></td>
                <td>{{ $ci->checked_in_at->format('d M Y H:i') }}</td>
                <td>{{ $ci->approver?->name ?? '-' }}</td>
                <td>{{ $ci->condition_notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
