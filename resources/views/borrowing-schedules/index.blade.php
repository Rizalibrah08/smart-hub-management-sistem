@extends('layouts.admin')
@section('title', 'Jadwal Peminjaman')
@section('content')
<div class="flex mb-16">
    <h1 style="flex:1">Jadwal Peminjaman</h1>
    <a href="{{ route('borrowing-schedules.create') }}" class="btn btn-primary">+ Buat Jadwal</a>
</div>

<div class="card mb-16">
    <form method="GET" class="flex">
        <select name="status" style="width:180px">
            <option value="">Semua Status</option>
            @foreach(['pending','approved','returned','overdue'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('borrowing-schedules.index') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr><th>Peminjam</th><th>Peralatan</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Jml</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($schedules as $s)
            <tr>
                <td>{{ $s->member->name }}</td>
                <td>{{ $s->equipment->code }} — {{ $s->equipment->name }}</td>
                <td>{{ $s->borrow_date->format('d M Y') }}</td>
                <td>{{ $s->return_date->format('d M Y') }}</td>
                <td>{{ $s->quantity_borrowed }}</td>
                <td><span class="badge badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                <td class="flex">
                    <a href="{{ route('borrowing-schedules.show', $s) }}" class="btn btn-secondary">Detail</a>
                    @if($s->status === 'pending')
                        <form method="POST" action="{{ route('borrowing-schedules.approve', $s) }}">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-success">Setujui</button>
                        </form>
                        <form method="POST" action="{{ route('borrowing-schedules.reject', $s) }}" onsubmit="return confirm('Tolak peminjaman ini?')">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#999">Tidak ada data peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $schedules->links() }}</div>
</div>
@endsection
