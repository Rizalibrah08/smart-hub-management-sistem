@extends('member.layouts.app')
@section('title', 'Peminjaman Saya')
@section('content')
<div class="page-header">
    <h1>Peminjaman Saya</h1>
    <a href="{{ route('member.borrowings.create') }}" class="btn btn-primary">+ Ajukan Peminjaman</a>
</div>
<div class="card">
    <table>
        <thead>
            <tr><th>Peralatan</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($borrowings as $b)
            <tr>
                <td>
                    <div style="font-weight:600">{{ $b->equipment->name }}</div>
                    <div style="font-size:.78rem;color:#888">{{ $b->equipment->code }}</div>
                </td>
                <td>{{ $b->borrow_date->format('d M Y') }}</td>
                <td>{{ $b->return_date->format('d M Y') }}</td>
                <td>{{ $b->quantity_borrowed }}</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td><a href="{{ route('member.borrowings.show', $b) }}" class="btn btn-secondary btn-sm">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#999;padding:24px">Belum ada peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px">{{ $borrowings->links() }}</div>
</div>
@endsection
