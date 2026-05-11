@extends('layouts.admin')
@section('title', 'Tambah Peralatan')
@section('content')
<div class="flex mb-16">
    <h1 style="flex:1">Tambah Peralatan</h1>
    <a href="{{ route('equipments.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
<div class="card">
    <form method="POST" action="{{ route('equipments.store') }}">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label>Kode Peralatan *</label>
                <input type="text" name="code" value="{{ old('code') }}" required>
                @error('code') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Nama Peralatan *</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Kategori *</label>
                <input type="text" name="category" value="{{ old('category') }}" placeholder="elektronik, furniture, tools..." required>
                @error('category') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah *</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                @error('quantity') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    @foreach(['available','in_use','maintenance','damaged'] as $s)
                        <option value="{{ $s }}" @selected(old('status') === $s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}">
            </div>
            <div class="form-group">
                <label>Tanggal Pembelian</label>
                <input type="date" name="purchase_date" value="{{ old('purchase_date') }}">
            </div>
            <div class="form-group">
                <label>Harga Pembelian (Rp)</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0" step="0.01">
            </div>
            <div class="form-group">
                <label>Tanggal Maintenance Terakhir</label>
                <input type="date" name="last_maintenance_date" value="{{ old('last_maintenance_date') }}">
            </div>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label>Catatan</label>
            <textarea name="notes" rows="2">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
