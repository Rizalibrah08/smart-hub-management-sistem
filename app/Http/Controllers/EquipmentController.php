<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        $equipments = $query->latest()->paginate(15)->withQueryString();
        $categories = Equipment::distinct()->pluck('category');

        return view('equipments.index', compact('equipments', 'categories'));
    }

    public function create()
    {
        return view('equipments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'                  => 'required|string|max:50|unique:equipments',
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'category'              => 'required|string|max:100',
            'quantity'              => 'required|integer|min:1',
            'status'                => 'required|in:available,in_use,maintenance,damaged',
            'location'              => 'nullable|string|max:255',
            'purchase_date'         => 'nullable|date',
            'purchase_price'        => 'nullable|numeric|min:0',
            'last_maintenance_date' => 'nullable|date',
            'notes'                 => 'nullable|string',
        ]);

        $data['available_quantity'] = $data['quantity'];

        Equipment::create($data);

        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load(['borrowingSchedules.member' => fn($q) => $q->select('id', 'name', 'email')]);
        return view('equipments.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $data = $request->validate([
            'code'                  => 'required|string|max:50|unique:equipments,code,' . $equipment->id,
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'category'              => 'required|string|max:100',
            'quantity'              => 'required|integer|min:1',
            'status'                => 'required|in:available,in_use,maintenance,damaged',
            'location'              => 'nullable|string|max:255',
            'purchase_date'         => 'nullable|date',
            'purchase_price'        => 'nullable|numeric|min:0',
            'last_maintenance_date' => 'nullable|date',
            'notes'                 => 'nullable|string',
        ]);

        $equipment->update($data);

        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil dihapus.');
    }
}
