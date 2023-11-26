<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MedicalCondition;
use App\Models\Patient;

class MedicalConditionFactory extends Factory
{
    protected $model = MedicalCondition::class;

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
