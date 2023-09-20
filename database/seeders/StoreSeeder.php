<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=StoreSeeder
     */
    public function run(Faker $faker): void
    {
        // Define the number of stores you want to create
        $numberOfStores = 10;

        // Loop to create stores with sample data
        for ($i = 1; $i <= $numberOfStores; $i++) {
            DB::table('stores')->insert([
                'user_id' => rand(3, 9),
                'title' => $faker->company,
                'description' => $faker->paragraph,
                'image' => 'store_image_' . $i . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
