<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;
use App\Models\Muscle;
use App\Models\Set;
use Faker\Factory as Faker;


class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        $exercises_test = [
            'Flexión',
            'Flexión Diamante',
            'Flexión Arquero',
            'Dominada Prona',
            'Dominada Supina',
            'Sentadilla',
            'Press de Banca',
            'Press Militar',
            'Remo',
            'Peso Muerto',
            'Curl de Bíceps',
            'Curl de Isquiotibial',
            'Puente de Glúteos'
        ];

        $exercises = [
            [
                'name' => 'Flexión',
                'muscles' => ['Pecho', 'Tríceps', 'Abdominales Superiores']
            ],
            [
                'name' => 'Flexión Diamante',
                'muscles' => ['Pecho', 'Tríceps', 'Abdominales Superiores', 'Hombros']
            ],
            [
                'name' => 'Flexión Arquero',
                'muscles' => ['Pecho', 'Tríceps', 'Abdominales Superiores']
            ],
            [
                'name' => 'Dominada Prona',
                'muscles' => ['Dorsales', 'Bíceps', 'Trapecios', 'Hombros', 'Pecho']
            ],
            [
                'name' => 'Dominada Supina',
                'muscles' => ['Dorsales', 'Bíceps', 'Trapecios', 'Hombros', 'Pecho']
            ],
            [
                'name' => 'Sentadilla',
                'muscles' => ['Glúteos', 'Cuádriceps', 'Isquiotibiales', 'Gemelos', 'Abdominales Superiores', 'Abdominales Inferiores']
            ],
            [
                'name' => 'Press de Banca',
                'muscles' => ['Pecho', 'Tríceps', 'Hombros']
            ],
            [
                'name' => 'Press Militar',
                'muscles' => ['Trapecios', 'Pecho', 'Hombros', 'Tríceps']
            ],
            [
                'name' => 'Remo',
                'muscles' => ['Dorsales', 'Trapecios', 'Hombros', 'Tríceps', 'Bíceps']
            ],
            [
                'name' => 'Peso Muerto',
                'muscles' => ['Isquiotibiales', 'Glúteos', 'Gemelos', 'Abdominales Superiores', 'Abdominales Inferiores', 'Oblicuos']
            ],
            [
                'name' => 'Curl de Bíceps',
                'muscles' => ['Bíceps']
            ],
            [
                'name' => 'Curl de Isquiotibial',
                'muscles' => ['Isquiotibiales']
            ],
            [
                'name' => 'Puente de Glúteos',
                'muscles' => ['Glúteos', 'Isquiotibiales']
            ]
        ];
        //
        foreach ($exercises as $exercise) {
            $ex = Exercise::create([
                'name' => $exercise['name'],
                'description' => $faker->text]);
            foreach($exercise['muscles'] as $muscle) {
                $ex->muscles()->attach(Muscle::where('name', $muscle)->first()->id);
            }
            for($i = 1; $i <= 30; ++$i) {
                Set::create(['exercise_id' => $ex->id, 'repetitions' => $i]);
            }
        }
    }
}
