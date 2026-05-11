@extends('member.layouts.app')
@section('title', 'Ajukan Peminjaman')
@section('content')
<div class="page-header">
    <h1>Ajukan Peminjaman</h1>
    <a href="{{ route('member.borrowings.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
<div class="card">
    <form method="POST" action="{{ route('member.borrowings.store') }}">
        @csrf
        <div class="form-group">
            <label>Pilih Peralatan *</label>
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
            <textarea name="purpose" rows="3" placeholder="Jelaskan keperluan peminjaman...">{{ old('purpose') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection
