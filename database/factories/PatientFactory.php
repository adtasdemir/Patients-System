<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition()
    {
        return [
            'IdCard' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'Gender' => $this->faker->randomElement(['Male', 'Female']),
            'Name' => $this->faker->firstName,
            'Surname' => $this->faker->lastName,
            'DateOfBirth' => $this->faker->date(),
            'Address' => $this->faker->address,
            'Postcode' => $this->faker->postcode,
            'ContactNumber1' => $this->faker->numerify('+905#########'), // Adjust the format
            'ContactNumber2' => $this->faker->optional()->numerify('+905#########'),
        ];
    }
}
