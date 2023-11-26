<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\MedicalCondition;

class MedicalConditionsTableSeeder extends Seeder
{
    public function run()
    {
        MedicalCondition::factory()->count(10)->create();
    }
}
