<?php

namespace Database\Seeders;

use App\Models\Mumbai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MumbaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=11;$i++){
            Mumbai::create([
                'playername'=>fake()->unique()->name(),
                'jersey'=>fake()->unique()->numberBetween(1,11)
            ]);
         }
    }
}
