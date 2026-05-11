@extends('layouts.admin')
@section('title', 'Peralatan')
@section('content')
<div class="flex mb-16">
    <h1 style="flex:1">Inventaris Peralatan</h1>
    <a href="{{ route('equipments.create') }}" class="btn btn-primary">+ Tambah Peralatan</a>
</div>

<div class="card mb-16">
    <form method="GET" class="flex" style="flex-wrap:wrap;gap:8px">
        <input type="text" name="search" placeholder="Cari nama / kode..." value="{{ request('search') }}" style="width:200px">
        <select name="status" style="width:160px">
            <option value="">Semua Status</option>
            @foreach(['available','in_use','maintenance','damaged'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <select name="category" style="width:160px">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Kode</th><th>Nama</th><th>Kategori</th><th>Tersedia / Total</th><th>Status</th><th>Lokasi</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipments as $eq)
            <tr>
                <td>{{ $eq->code }}</td>
                <td>{{ $eq->name }}</td>
                <td>{{ ucfirst($eq->category) }}</td>
                <td>{{ $eq->available_quantity }} / {{ $eq->quantity }}</td>
                <td><span class="badge badge-{{ $eq->status }}">{{ ucfirst(str_replace('_',' ',$eq->status)) }}</span></td>
                <td>{{ $eq->location ?? '-' }}</td>
                <td class="flex">
                    <a href="{{ route('equipments.show', $eq) }}" class="btn btn-secondary">Detail</a>
                    <a href="{{ route('equipments.edit', $eq) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('equipments.destroy', $eq) }}" onsubmit="return confirm('Hapus peralatan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#999">Tidak ada data peralatan.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $equipments->links() }}</div>
</div>
@endsection
