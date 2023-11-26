<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Medication;
use App\Models\Patient;

class MedicationFactory extends Factory
{
    protected $model = Medication::class;

    public function definition()
    {
        return [
            'patient_id' => function () {
                return Patient::factory()->create()->id;
            },
            'Name' => $this->faker->word,
            'Notes' => $this->faker->sentence,
            'StartDate' => $this->faker->dateTimeThisDecade(),
            'EndDate' => $this->faker->optional()->dateTimeThisDecade(),
        ];
    }
}
