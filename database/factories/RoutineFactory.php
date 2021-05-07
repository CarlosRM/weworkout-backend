<?php

namespace Database\Factories;

use App\Models\Routine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoutineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Routine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = \App\Models\User::pluck('id')->toArray();
        return [
            'name' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'description' => $this->faker->text(1000),
            'visualizations' => $this->faker->numberBetween(0, 2000),
            'user_id' => $this->faker->randomElement($users),
        ];
    }
}
