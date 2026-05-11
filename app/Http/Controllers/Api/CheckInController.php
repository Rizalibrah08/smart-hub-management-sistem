<?php

namespace App\Http\Controllers\Api;

use App\Events\CheckInApproved;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\BorrowingSchedule;
use App\Models\CheckIn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckInController extends Controller
{
    use ApiResponse;

    /** Member: submit check-in for borrowing */
    public function borrowCheckIn(Request $request): JsonResponse
    {
        $data = $request->validate([
            'borrowing_schedule_id' => 'required|exists:borrowing_schedules,id',
            'equipment_id'          => 'required|exists:equipments,id',
            'condition_notes'       => 'nullable|string',
        ]);

        $schedule = BorrowingSchedule::findOrFail($data['borrowing_schedule_id']);

        if ($schedule->member_id !== $request->user()->id) {
            return $this->error('Anda tidak memiliki akses ke jadwal peminjaman ini.', 403);
        }
        if ($schedule->status !== 'approved') {
            return $this->error('Peminjaman belum disetujui oleh admin.', 422);
        }
        if (CheckIn::where('borrowing_schedule_id', $schedule->id)->where('check_in_type', 'borrow')->exists()) {
            return $this->error('Check-in peminjaman sudah pernah dilakukan.', 422);
        }

        $checkIn = CheckIn::create([
            'borrowing_schedule_id' => $schedule->id,
            'equipment_id'          => $data['equipment_id'],
            'member_id'             => $request->user()->id,
            'check_in_type'         => 'borrow',
            'status'                => 'pending_approval',
            'condition_notes'       => $data['condition_notes'] ?? null,
            'checked_in_at'         => now(),
        ]);

        return $this->success($checkIn, 'Check-in peminjaman berhasil, menunggu approval admin.', 201);
    }

    /** Member: submit check-in for return */
    public function returnCheckIn(Request $request): JsonResponse
    {
        $data = $request->validate([
            'borrowing_schedule_id' => 'required|exists:borrowing_schedules,id',
            'equipment_id'          => 'required|exists:equipments,id',
            'condition_notes'       => 'nullable|string',
        ]);

        $schedule = BorrowingSchedule::findOrFail($data['borrowing_schedule_id']);

        if ($schedule->member_id !== $request->user()->id) {
            return $this->error('Anda tidak memiliki akses ke jadwal peminjaman ini.', 403);
        }

        $borrowCheckIn = CheckIn::where('borrowing_schedule_id', $schedule->id)
            ->where('check_in_type', 'borrow')
            ->where('status', 'approved')
            ->first();

        if (!$borrowCheckIn) {
            return $this->error('Check-in peminjaman belum disetujui admin.', 422);
        }
        if (CheckIn::where('borrowing_schedule_id', $schedule->id)->where('check_in_type', 'return')->exists()) {
            return $this->error('Check-in pengembalian sudah pernah dilakukan.', 422);
        }

        $checkIn = CheckIn::create([
            'borrowing_schedule_id' => $schedule->id,
            'equipment_id'          => $data['equipment_id'],
            'member_id'             => $request->user()->id,
            'check_in_type'         => 'return',
            'status'                => 'pending_approval',
            'condition_notes'       => $data['condition_notes'] ?? null,
            'checked_in_at'         => now(),
        ]);

        return $this->success($checkIn, 'Check-in pengembalian berhasil, menunggu approval admin.', 201);
    }

    /** Admin: list all check-ins */
    public function index(Request $request): JsonResponse
    {
        $query = CheckIn::with(['equipment:id,code,name', 'member:id,name,email', 'borrowingSchedule:id,borrow_date,return_date']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('check_in_type')) {
            $query->where('check_in_type', $request->check_in_type);
        }

        return $this->paginated($query->latest('checked_in_at')->paginate(15));
    }

    /** Admin: approve a check-in */
    public function approve(Request $request, CheckIn $checkIn): JsonResponse
    {
        if ($checkIn->status !== 'pending_approval') {
            return $this->error('Check-in ini sudah diproses.', 422);
        }

        DB::transaction(function () use ($checkIn, $request) {
            $checkIn->update([
                'status'      => 'approved',
                'approved_by' => $request->user()->id,
                'approved_at' => now(),
            ]);

            if ($checkIn->check_in_type === 'return') {
                $schedule = $checkIn->borrowingSchedule;
                $schedule->update([
                    'status'             => 'returned',
                    'actual_return_date' => now()->toDateString(),
                ]);

                $equipment = $checkIn->equipment;
                $equipment->increment('available_quantity', $schedule->quantity_borrowed);
                if ($equipment->status === 'in_use' && $equipment->available_quantity > 0) {
                    $equipment->update(['status' => 'available']);
                }
            }
        });

        CheckInApproved::dispatch($checkIn->fresh());

        return $this->success($checkIn->fresh(), 'Check-in berhasil disetujui.');
    }

    /** Admin: reject a check-in */
    public function reject(Request $request, CheckIn $checkIn): JsonResponse
    {
        if ($checkIn->status !== 'pending_approval') {
            return $this->error('Check-in ini sudah diproses.', 422);
        }

        $data = $request->validate(['rejection_reason' => 'required|string']);

        $checkIn->update([
            'status'           => 'rejected',
            'approved_by'      => $request->user()->id,
            'approved_at'      => now(),
            'rejection_reason' => $data['rejection_reason'],
        ]);

        return $this->success($checkIn->fresh(), 'Check-in ditolak.');
    }
}
