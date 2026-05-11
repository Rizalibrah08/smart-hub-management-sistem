<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\BorrowingSchedule;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = BorrowingSchedule::with('equipment')
            ->where('member_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('member.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $equipments = Equipment::where('status', 'available')
            ->where('available_quantity', '>', 0)
            ->get(['id', 'code', 'name', 'available_quantity', 'category', 'location']);

        return view('member.borrowings.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id'      => 'required|exists:equipments,id',
            'borrow_date'       => 'required|date|after_or_equal:today',
            'return_date'       => 'required|date|after:borrow_date',
            'quantity_borrowed' => 'required|integer|min:1',
            'purpose'           => 'nullable|string|max:500',
        ]);

        $equipment = Equipment::findOrFail($data['equipment_id']);

        if ($data['quantity_borrowed'] > $equipment->available_quantity) {
            return back()->withErrors(['quantity_borrowed' => 'Jumlah melebihi ketersediaan (' . $equipment->available_quantity . ' unit).'])->withInput();
        }

        $data['member_id'] = auth()->id();
        $data['status']    = 'pending';

        BorrowingSchedule::create($data);

        $equipment->decrement('available_quantity', $data['quantity_borrowed']);
        if ($equipment->available_quantity <= 0) {
            $equipment->update(['status' => 'in_use']);
        }

        return redirect()->route('member.borrowings.index')
            ->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(BorrowingSchedule $borrowing)
    {
        abort_if($borrowing->member_id !== auth()->id(), 403);
        $borrowing->load(['equipment', 'checkIns']);
        return view('member.borrowings.show', compact('borrowing'));
    }
}
