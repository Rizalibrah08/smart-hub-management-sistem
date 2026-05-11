<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Equipment::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where(fn($q) => $q
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%")
            );
        }

        $perPage = min((int) $request->get('per_page', 15), 100);
        return $this->paginated($query->latest()->paginate($perPage));
    }

    public function show(Equipment $equipment): JsonResponse
    {
        $equipment->load(['borrowingSchedules' => fn($q) => $q
            ->with('member:id,name,email')
            ->latest()
            ->limit(10)
        ]);

        return $this->success($equipment);
    }
}
