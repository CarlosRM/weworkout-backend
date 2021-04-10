<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Routine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $users = \App\Models\User::pluck('id')->toArray();
        $routines = \App\Models\Routine::pluck('id')->toArray();


        return [
            'content' => $this->faker->text,
            'routine_id' => $this->faker->randomElement($routines),
            'user_id' => $this->faker->randomElement($users),
        ];
    }
}
