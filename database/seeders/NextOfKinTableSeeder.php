<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NextOfKin;

class NextOfKinTableSeeder extends Seeder
{
    public function run()
    {
        NextOfKin::factory()->count(10)->create();
    }
}
