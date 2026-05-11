@extends('member.layouts.app')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="page-header">
    <h1>Detail Peminjaman #{{ $borrowing->id }}</h1>
    <a href="{{ route('member.borrowings.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
<div class="card">
    <table>
        <tr><th style="width:180px">Peralatan</th><td>{{ $borrowing->equipment->name }} ({{ $borrowing->equipment->code }})</td></tr>
        <tr><th>Tanggal Pinjam</th><td>{{ $borrowing->borrow_date->format('d M Y') }}</td></tr>
        <tr><th>Tanggal Kembali</th><td>{{ $borrowing->return_date->format('d M Y') }}</td></tr>
        <tr><th>Jumlah</th><td>{{ $borrowing->quantity_borrowed }}</td></tr>
        <tr><th>Status</th><td><span class="badge badge-{{ $borrowing->status }}">{{ ucfirst($borrowing->status) }}</span></td></tr>
        <tr><th>Tujuan</th><td>{{ $borrowing->purpose ?? '-' }}</td></tr>
    </table>
</div>
@if($borrowing->checkIns->count())
<div class="card">
    <h2 style="font-size:1rem;font-weight:700;margin-bottom:12px">Riwayat Check-in</h2>
    <table>
        <thead><tr><th>Tipe</th><th>Status</th><th>Waktu</th><th>Catatan Kondisi</th></tr></thead>
        <tbody>
            @foreach($borrowing->checkIns as $ci)
            <tr>
                <td>{{ ucfirst($ci->check_in_type) }}</td>
                <td><span class="badge badge-{{ $ci->status === 'approved' ? 'approved' : ($ci->status === 'rejected' ? 'overdue' : 'pending') }}">
                    {{ ucfirst(str_replace('_', ' ', $ci->status)) }}
                </span></td>
                <td>{{ $ci->checked_in_at->format('d M Y H:i') }}</td>
                <td>{{ $ci->condition_notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
