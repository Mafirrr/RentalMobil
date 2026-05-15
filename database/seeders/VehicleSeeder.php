<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Category;
use App\Models\Motorcycle;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $categories = [
            Category::firstOrCreate(['name' => 'Premium']),
            Category::firstOrCreate(['name' => 'Ekonomi']),
            Category::firstOrCreate(['name' => 'Sport']),
        ];

        $carModels = ['Toyota Avanza', 'Honda Civic', 'Mitsubishi Xpander', 'Suzuki Ertiga', 'Toyota Fortuner', 'Hyundai Ionic 5'];
        $motorModels = ['Honda Vario 160', 'Kawasaki Ninja ZX-25R', 'Yamaha NMAX', 'Honda Beat', 'Vespa Sprint', 'Yamaha R15'];

        for ($i = 1; $i <= 15; $i++) {
            $type = $faker->randomElement(['car', 'motorcycle']);
            $selectedCategory = $faker->randomElement($categories);

            $vehicle = Vehicle::create([
                'category_id' => $selectedCategory->id,
                'vehicle_type' => $type,
                'model' => ($type === 'car') ? $faker->randomElement($carModels) : $faker->randomElement($motorModels),
                'plate_number' => strtoupper($faker->bothify('? #### ??')), // Contoh: B 1234 XY
                'year' => $faker->numberBetween(2018, 2024),
                'color' => $faker->randomElement(['Hitam', 'Putih', 'Silver', 'Merah', 'Biru']),
                'daily_rate' => ($type === 'car') ? $faker->numberBetween(300000, 1000000) : $faker->numberBetween(50000, 500000),
                'status' => 'available',
            ]);

            if ($type === 'car') {
                Car::create([
                    'vehicle_id' => $vehicle->id,
                    'capacity' => $faker->randomElement([4, 5, 7]),
                    'transmission' => $faker->randomElement(['Manual', 'Automatic']),
                    'fuel_type' => $faker->randomElement(['Bensin', 'Diesel', 'Electric']),
                ]);
            } else {
                Motorcycle::create([
                    'vehicle_id' => $vehicle->id,
                    'engine_capacity' => $faker->randomElement([110, 125, 150, 160, 250]),
                    'includes_helmet' => $faker->boolean(),
                    'transmission' => $faker->randomElement(['Matic', 'Manual']),
                ]);
            }
        }
    }
}
