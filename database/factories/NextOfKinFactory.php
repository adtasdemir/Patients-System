<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NextOfKin;
use App\Models\Patient;

class NextOfKinFactory extends Factory
{
    protected $model = NextOfKin::class;

    public function definition(): array
    {
        return [
            'patient_id' => function () {
                return Patient::factory()->create()->id;
            },
            'IdCard' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'Name' => $this->faker->firstName,
            'Surname' => $this->faker->lastName,
            'ContactNumber1' => $this->faker->numerify('+905#########'), // Adjust the format
            'ContactNumber2' => $this->faker->optional()->numerify('+905#########'),
        ];
    }
}
