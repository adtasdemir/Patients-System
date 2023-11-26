<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PatientsTableSeeder::class);
        $this->call(NextOfKinTableSeeder::class);
        $this->call(MedicalConditionsTableSeeder::class);
        $this->call(AllergiesTableSeeder::class);
        $this->call(MedicationsTableSeeder::class);
    }
}
