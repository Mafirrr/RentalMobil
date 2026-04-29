<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $catMpv = Category::create(['name' => 'MPV']);
        $catPremium = Category::create(['name' => 'MPV Premium']);
        $catLarge = Category::create(['name' => 'Kapasitas Besar']);

        $mpvCars = ['Toyota Avanza', 'Daihatsu Xenia', 'Mitsubishi Xpander', 'Suzuki Ertiga'];
        foreach ($mpvCars as $model) {
            Car::create([
                'category_id' => $catMpv->id,
                'model' => $model,
                'plate_number' => 'P ' . rand(1000, 9999) . ' ' . strtoupper(Str::random(2)),
                'capacity' => 4,
                'year' => 2023,
                'color' => 'Hitam',
                'daily_rate' => 350000,
                'status' => 'available',
                'transmission' => 'Manual'
            ]);
        }

        $premiumCars = [
            'Toyota Innova Reborn' => 600000,
            'Toyota Innova Zenix' => 850000,
            'Toyota Alphard' => 2500000
        ];
        foreach ($premiumCars as $model => $price) {
            Car::create([
                'category_id' => $catPremium->id,
                'model' => $model,
                'plate_number' => 'P ' . rand(1000, 9999) . ' ' . strtoupper(Str::random(2)),
                'capacity' => 4,
                'year' => 2024,
                'color' => 'Putih',
                'daily_rate' => $price,
                'status' => 'available',
                'transmission' => 'Automatic'
            ]);
        }

        $largeCars = ['Toyota HiAce', 'Isuzu Elf'];
        foreach ($largeCars as $model) {
            Car::create([
                'category_id' => $catLarge->id,
                'model' => $model,
                'capacity' => 4,
                'plate_number' => 'P ' . rand(1000, 9999) . ' ' . strtoupper(Str::random(2)),
                'year' => 2022,
                'color' => 'Silver',
                'daily_rate' => 1200000,
                'status' => 'available',
                'transmission' => 'Automatic'
            ]);
        }
    }
}
