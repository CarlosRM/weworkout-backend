<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /* Seed the most basic tables */
        $this->call([
            MuscleSeeder::class,
            CategorySeeder::class,
            ExerciseSeeder::class,
        ]);

        /* Seed the users and routines via factories */
        \App\Models\User::factory(10)->create();
        \App\Models\Routine::factory(40)->create();

        $users = \App\Models\User::all();
        $routines = \App\Models\Routine::all();
        $categories = \App\Models\Category::all();
        $sets = \App\Models\Set::all();

        /* Seed the many to many relationships */
        \App\Models\User::all()->each(function ($user) use ($routines) { 
            $user->favouriteRoutines()->attach(
                $routines->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        \App\Models\User::all()->each(function ($user) use ($users) { 
            $user->followers()->attach(
                $users->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        \App\Models\Routine::all()->each(function ($routine) use ($categories) { 
            $routine->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        \App\Models\Routine::all()->each(function ($routine) use ($sets) { 
            $routine->sets()->attach(
                $sets->random(rand(1, 5))->pluck('id')->toArray()
            ); 
        });

        /* Seed the comments */
        \App\Models\Comment::factory(40)->create();



    }
}
