<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smarthub.com',
            'password' => 'password',
            'role' => 'admin',
            'phone' => '08100000000',
            'is_active' => true,
        ]);

        $members = [
            ['name' => 'Budi Santoso', 'email' => 'budi@smarthub.com', 'phone' => '08111111111'],
            ['name' => 'Siti Rahayu', 'email' => 'siti@smarthub.com', 'phone' => '08122222222'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@smarthub.com', 'phone' => '08133333333'],
        ];

        foreach ($members as $member) {
            User::create([
                ...$member,
                'password' => 'password',
                'role' => 'member',
                'is_active' => true,
            ]);
        }
    }
}
