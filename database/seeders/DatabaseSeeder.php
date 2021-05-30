<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;



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

        /* Seed test user */
        $user = new \App\Models\User;
        $user->name = 'Tony Stark';
        $user->email = 'ironman@avengers.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('PepperPotts<3');
        $user->remember_token = Str::random(10);
        $user->birthdate = Carbon::today()->subYears(rand(0, 30));
        $user->genre = 'Hombre';
        $user->description = 'HOMBRE DE ACERO. Genio. Multimillonario. Filántropo. La confianza de Tony Stark solo se compara con sus habilidades de alto vuelo como el héroe llamado Iron Man.';
        $user->save();
        /* Seed the users and routines via factories */
        \App\Models\User::factory(10)->create();
        \App\Models\Routine::factory(40)->create();
        \App\Models\Workout::factory(750)->create();

        $users = \App\Models\User::all();
        $routines = \App\Models\Routine::all();
        $categories = \App\Models\Category::all();
        $sets = \App\Models\Set::all();
        $workouts = \App\Models\Workout::all();
        $exercises = \App\Models\Exercise::all();

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

        \App\Models\Exercise::all()->each(function ($exercise) use ($exercises) { 
            $exercise->similar()->attach(
                $exercises->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        \App\Models\Routine::all()->each(function ($routine) use ($routines) { 
            $routine->similar()->attach(
                $routines->random(rand(1, 3))->pluck('id')->toArray()
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

        \App\Models\Workout::all()->each(function ($workout) use ($sets) {
            $workout->sets()->attach(
                $sets->random(rand(1, 5))->pluck('id')->toArray(),
                ['weight' => rand(0, 100)]
            );
        });

        /* Seed the comments */
        \App\Models\Comment::factory(40)->create();
        \App\Models\Rating::factory(40)->create();



    }
}
