<?php

namespace Database\Seeders;

use App\Models\Chennai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChennaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for($i=1;$i<=11;$i++){
            Chennai::create([
                'playername'=>fake()->unique()->name(),
                'jersey'=>fake()->unique()->numberBetween(1,11)
            ]);
         }
    }
}
