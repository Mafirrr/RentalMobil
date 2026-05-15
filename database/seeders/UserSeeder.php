<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'username' => 'admin_rental',
            'email' => 'admin@capstone.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        UserDetail::create([
            'user_id' => $admin->id,
            'full_name' => 'Administrator InovasiKita',
            'phone' => '081234567890',
            'address' => 'Bondowoso, Jawa Timur',
            'identity_number' => '3511000000000001',
        ]);

        $customers = [
            ['username' => 'budi_santoso', 'email' => 'budi@gmail.com'],
            ['username' => 'siti_aminah', 'email' => 'siti@gmail.com'],
            ['username' => 'agus_pratama', 'email' => 'agus@gmail.com'],
            ['username' => 'dewi_lestari', 'email' => 'dewi@gmail.com'],
            ['username' => 'eko_susanto', 'email' => 'eko@gmail.com'],
            ['username' => 'ani_wijaya', 'email' => 'ani@gmail.com'],
            ['username' => 'rizky_fauzi', 'email' => 'rizky@gmail.com'],
            ['username' => 'maya_putri', 'email' => 'maya@gmail.com'],
            ['username' => 'fajar_hidayat', 'email' => 'fajar@gmail.com'],
            ['username' => 'lina_marlina', 'email' => 'lina@gmail.com'],
        ];

        foreach ($customers as $data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'role' => 'penyewa',
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'full_name' => ucwords(str_replace('_', ' ', $data['username'])),
                'phone' => '08' . rand(111111111, 999999999),
                'address' => 'Alamat Customer ' . $data['username'],
                'identity_number' => '3511' . rand(100000000000, 999999999999),
            ]);
        }
    }
}
