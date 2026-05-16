<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff Inventaris',
                'password' => Hash::make('password'),
                'role' => User::ROLE_STAFF,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Anggota Peminjam',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'phone' => '081200000001',
                'email_verified_at' => now(),
            ]
        );

        $items = [
            ['name' => 'Proyektor Epson', 'quantity_total' => 2, 'quantity_available' => 2, 'description' => 'Proyektor untuk rapat, seminar, dan kegiatan kelas.'],
            ['name' => 'Kabel HDMI 5 Meter', 'quantity_total' => 5, 'quantity_available' => 5, 'description' => 'Kabel HDMI cadangan untuk presentasi.'],
            ['name' => 'Mic Wireless', 'quantity_total' => 4, 'quantity_available' => 4, 'description' => 'Microphone wireless untuk acara indoor.'],
            ['name' => 'Speaker Portable', 'quantity_total' => 2, 'quantity_available' => 2, 'description' => 'Speaker portable dengan koneksi bluetooth.'],
            ['name' => 'Tripod Kamera', 'quantity_total' => 3, 'quantity_available' => 3, 'description' => 'Tripod ringan untuk dokumentasi kegiatan.'],
            ['name' => 'Kabel Roll', 'quantity_total' => 6, 'quantity_available' => 6, 'description' => 'Kabel roll untuk kebutuhan listrik acara.'],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                $item + [
                    'condition' => Item::CONDITION_GOOD,
                    'is_active' => true,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
