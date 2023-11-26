<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Allergy;
use App\Models\Patient;

class AllergyFactory extends Factory
{
    protected $model = Allergy::class;

    public function definition()
    {
        return [
            'patient_id' => function () {
                return Patient::factory()->create()->id;
            },
            'Name' => $this->faker->word,
            'Notes' => $this->faker->sentence,
        ];
    }
}
