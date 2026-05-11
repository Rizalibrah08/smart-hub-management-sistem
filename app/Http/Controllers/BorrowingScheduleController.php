<?php

namespace App\Http\Controllers;

use App\Models\BorrowingSchedule;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BorrowingScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = BorrowingSchedule::with(['equipment', 'member']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->latest()->paginate(15)->withQueryString();

        return view('borrowing-schedules.index', compact('schedules'));
    }

    public function create()
    {
        $equipments = Equipment::where('available_quantity', '>', 0)
            ->where('status', 'available')
            ->get(['id', 'code', 'name', 'available_quantity']);

        return view('borrowing-schedules.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id'      => 'required|exists:equipments,id',
            'borrow_date'       => 'required|date|after_or_equal:today',
            'return_date'       => 'required|date|after:borrow_date',
            'quantity_borrowed' => 'required|integer|min:1',
            'purpose'           => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $equipment = Equipment::findOrFail($data['equipment_id']);

        if ($data['quantity_borrowed'] > $equipment->available_quantity) {
            return back()->withErrors(['quantity_borrowed' => 'Jumlah melebihi ketersediaan (' . $equipment->available_quantity . ' unit).'])->withInput();
        }

        $data['member_id'] = auth()->id();
        $data['status'] = 'pending';

        BorrowingSchedule::create($data);

        $equipment->decrement('available_quantity', $data['quantity_borrowed']);
        if ($equipment->available_quantity <= 0) {
            $equipment->update(['status' => 'in_use']);
        }

        return redirect()->route('borrowing-schedules.index')->with('success', 'Jadwal peminjaman berhasil dibuat.');
    }

    public function show(BorrowingSchedule $borrowingSchedule)
    {
        $borrowingSchedule->load(['equipment', 'member', 'checkIns.approver']);
        return view('borrowing-schedules.show', compact('borrowingSchedule'));
    }

    public function edit(BorrowingSchedule $borrowingSchedule)
    {
        if (!in_array($borrowingSchedule->status, ['pending'])) {
            return redirect()->route('borrowing-schedules.show', $borrowingSchedule)
                ->with('error', 'Hanya jadwal berstatus pending yang dapat diedit.');
        }

        $equipments = Equipment::where('status', 'available')->orWhere('id', $borrowingSchedule->equipment_id)
            ->get(['id', 'code', 'name', 'available_quantity']);

        return view('borrowing-schedules.edit', compact('borrowingSchedule', 'equipments'));
    }

    public function update(Request $request, BorrowingSchedule $borrowingSchedule)
    {
        $data = $request->validate([
            'borrow_date'       => 'required|date',
            'return_date'       => 'required|date|after:borrow_date',
            'quantity_borrowed' => 'required|integer|min:1',
            'purpose'           => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $borrowingSchedule->update($data);

        return redirect()->route('borrowing-schedules.index')->with('success', 'Jadwal peminjaman berhasil diperbarui.');
    }

    public function destroy(BorrowingSchedule $borrowingSchedule)
    {
        if ($borrowingSchedule->status === 'pending') {
            $borrowingSchedule->equipment->increment('available_quantity', $borrowingSchedule->quantity_borrowed);
        }

        $borrowingSchedule->delete();

        return redirect()->route('borrowing-schedules.index')->with('success', 'Jadwal peminjaman berhasil dihapus.');
    }

    public function approve(BorrowingSchedule $borrowingSchedule)
    {
        if ($borrowingSchedule->status !== 'pending') {
            return back()->with('error', 'Hanya jadwal berstatus pending yang dapat disetujui.');
        }

        $borrowingSchedule->update(['status' => 'approved']);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Request $request, BorrowingSchedule $borrowingSchedule)
    {
        if ($borrowingSchedule->status !== 'pending') {
            return back()->with('error', 'Hanya jadwal berstatus pending yang dapat ditolak.');
        }

        $borrowingSchedule->update(['status' => 'returned']);

        $borrowingSchedule->equipment->increment('available_quantity', $borrowingSchedule->quantity_borrowed);
        if ($borrowingSchedule->equipment->status === 'in_use') {
            $borrowingSchedule->equipment->update(['status' => 'available']);
        }

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}
