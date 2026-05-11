@extends('layouts.admin')
@section('title', 'Detail Peralatan')
@section('content')
<div class="flex mb-16">
    <h1 style="flex:1">{{ $equipment->name }}</h1>
    <a href="{{ route('equipments.edit', $equipment) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('equipments.index') }}" class="btn btn-secondary" style="margin-left:8px">← Kembali</a>
</div>
<div class="card mb-16">
    <table>
        <tr><th style="width:200px">Kode</th><td>{{ $equipment->code }}</td></tr>
        <tr><th>Kategori</th><td>{{ ucfirst($equipment->category) }}</td></tr>
        <tr><th>Status</th><td><span class="badge badge-{{ $equipment->status }}">{{ ucfirst(str_replace('_',' ',$equipment->status)) }}</span></td></tr>
        <tr><th>Jumlah Total</th><td>{{ $equipment->quantity }}</td></tr>
        <tr><th>Tersedia</th><td>{{ $equipment->available_quantity }}</td></tr>
        <tr><th>Lokasi</th><td>{{ $equipment->location ?? '-' }}</td></tr>
        <tr><th>Tanggal Pembelian</th><td>{{ $equipment->purchase_date?->format('d M Y') ?? '-' }}</td></tr>
        <tr><th>Harga Pembelian</th><td>{{ $equipment->purchase_price ? 'Rp ' . number_format($equipment->purchase_price, 0, ',', '.') : '-' }}</td></tr>
        <tr><th>Maintenance Terakhir</th><td>{{ $equipment->last_maintenance_date?->format('d M Y') ?? '-' }}</td></tr>
        <tr><th>Deskripsi</th><td>{{ $equipment->description ?? '-' }}</td></tr>
        <tr><th>Catatan</th><td>{{ $equipment->notes ?? '-' }}</td></tr>
    </table>
</div>

<div class="card">
    <h2 style="font-size:1.1rem;margin-bottom:12px">Riwayat Peminjaman</h2>
    <table>
        <thead>
            <tr><th>Peminjam</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($equipment->borrowingSchedules as $bs)
            <tr>
                <td>{{ $bs->member->name }}</td>
                <td>{{ $bs->borrow_date->format('d M Y') }}</td>
                <td>{{ $bs->return_date->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $bs->status }}">{{ ucfirst($bs->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#999">Belum ada riwayat peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
