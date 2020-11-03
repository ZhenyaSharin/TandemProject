<?php

namespace Database\Factories;

use App\Models\Persons;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Persons::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'last_name' => $this->faker->lastName($gender = 'male'),
            'first_name' => $this->faker->firstName($gender = 'male'),
            'middle_name' => $this->faker->middleName($gender = 'male'),
            'birth_date' => $date = $this->faker->unique()->dateTimeBetween($startDate = '-20 years', $endDate = '-15 years', $timezone = null),
            'group_id' => $this->faker->numberBetween($min = 1, $max = 5),
        ];
    }
}
