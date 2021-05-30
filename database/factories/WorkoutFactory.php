<?php

namespace Database\Factories;

use App\Models\Workout;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $users = \App\Models\User::pluck('id')->toArray();

        return [
            'name' =>$this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'date' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
            'weight' => $this->faker->numberBetween($min = 40, $max = 150),
            'fat_percentage' => $this->faker->numberBetween($min = 5, $max = 100),
            'notes' => $this->faker->text,
            'user_id' => $this->faker->randomElement($users)
        ];
    }
}
