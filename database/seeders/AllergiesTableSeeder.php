<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Allergy;

class AllergiesTableSeeder extends Seeder
{
    public function run()
    {
        Allergy::factory()->count(10)->create();
    }
}
