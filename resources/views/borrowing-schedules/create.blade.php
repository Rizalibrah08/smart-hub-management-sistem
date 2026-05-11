@extends('layouts.admin')
@section('title', 'Buat Jadwal Peminjaman')
@section('content')
<div class="flex mb-16">
    <h1 style="flex:1">Buat Jadwal Peminjaman</h1>
    <a href="{{ route('borrowing-schedules.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
<div class="card">
    <form method="POST" action="{{ route('borrowing-schedules.store') }}">
        @csrf
        <div class="form-group">
            <label>Peralatan *</label>
            <select name="equipment_id" required>
                <option value="">-- Pilih Peralatan --</option>
                @foreach($equipments as $eq)
                    <option value="{{ $eq->id }}" @selected(old('equipment_id') == $eq->id)>
                        {{ $eq->code }} — {{ $eq->name }} (Tersedia: {{ $eq->available_quantity }})
                    </option>
                @endforeach
            </select>
            @error('equipment_id') <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
            <div class="form-group">
                <label>Tanggal Pinjam *</label>
                <input type="date" name="borrow_date" value="{{ old('borrow_date') }}" min="{{ date('Y-m-d') }}" required>
                @error('borrow_date') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Tanggal Kembali *</label>
                <input type="date" name="return_date" value="{{ old('return_date') }}" required>
                @error('return_date') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah *</label>
                <input type="number" name="quantity_borrowed" value="{{ old('quantity_borrowed', 1) }}" min="1" required>
                @error('quantity_borrowed') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Tujuan Peminjaman</label>
            <textarea name="purpose" rows="2">{{ old('purpose') }}</textarea>
        </div>
        <div class="form-group">
            <label>Catatan</label>
            <textarea name="notes" rows="2">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
