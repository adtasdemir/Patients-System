<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationsTableSeeder extends Seeder
{
    public function run()
    {
        Medication::factory()->count(10)->create();
    }
}
