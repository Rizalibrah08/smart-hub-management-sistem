<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = [
            ['code' => 'EQ-001', 'name' => 'Laptop Dell XPS 13', 'category' => 'elektronik', 'quantity' => 5, 'available_quantity' => 5, 'status' => 'available', 'location' => 'Ruang IT', 'purchase_price' => 15000000, 'purchase_date' => '2024-01-15'],
            ['code' => 'EQ-002', 'name' => 'Projector Epson EB-2250U', 'category' => 'elektronik', 'quantity' => 3, 'available_quantity' => 2, 'status' => 'available', 'location' => 'Ruang Meeting', 'purchase_price' => 8500000, 'purchase_date' => '2024-03-10'],
            ['code' => 'EQ-003', 'name' => 'Kamera Canon EOS R50', 'category' => 'elektronik', 'quantity' => 2, 'available_quantity' => 2, 'status' => 'available', 'location' => 'Ruang Media', 'purchase_price' => 12000000, 'purchase_date' => '2024-06-20'],
            ['code' => 'EQ-004', 'name' => 'Tripod Manfrotto 190', 'category' => 'tools', 'quantity' => 4, 'available_quantity' => 4, 'status' => 'available', 'location' => 'Ruang Media', 'purchase_price' => 1500000, 'purchase_date' => '2024-06-20'],
            ['code' => 'EQ-005', 'name' => 'Meja Rapat Oval', 'category' => 'furniture', 'quantity' => 2, 'available_quantity' => 1, 'status' => 'available', 'location' => 'Gudang', 'purchase_price' => 5000000, 'purchase_date' => '2023-08-01'],
            ['code' => 'EQ-006', 'name' => 'Kursi Lipat', 'category' => 'furniture', 'quantity' => 20, 'available_quantity' => 15, 'status' => 'available', 'location' => 'Gudang', 'purchase_price' => 250000, 'purchase_date' => '2023-08-01'],
            ['code' => 'EQ-007', 'name' => 'Mikrofon Rode NT-USB', 'category' => 'elektronik', 'quantity' => 3, 'available_quantity' => 3, 'status' => 'available', 'location' => 'Ruang Media', 'purchase_price' => 2500000, 'purchase_date' => '2024-09-05'],
            ['code' => 'EQ-008', 'name' => 'Whiteboard 120x240', 'category' => 'furniture', 'quantity' => 3, 'available_quantity' => 3, 'status' => 'available', 'location' => 'Ruang Kelas', 'purchase_price' => 800000, 'purchase_date' => '2023-01-10'],
            ['code' => 'EQ-009', 'name' => 'Toolkit Elektronik', 'category' => 'tools', 'quantity' => 5, 'available_quantity' => 4, 'status' => 'available', 'location' => 'Ruang IT', 'purchase_price' => 350000, 'purchase_date' => '2024-02-14'],
            ['code' => 'EQ-010', 'name' => 'Printer HP LaserJet', 'category' => 'elektronik', 'quantity' => 2, 'available_quantity' => 0, 'status' => 'maintenance', 'location' => 'Ruang Admin', 'purchase_price' => 4500000, 'purchase_date' => '2023-11-20', 'last_maintenance_date' => '2026-05-01', 'notes' => 'Sedang dalam perbaikan'],
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }
    }
}
