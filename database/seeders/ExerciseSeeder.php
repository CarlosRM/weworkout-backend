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
                'muscles' => ['Pecho', 'Tríceps', 'Abdominales Superiores'],
                'videoURL' => 'https://www.youtube.com/embed/Olkjnp6-2Rs'
            ],
            [
                'name' => 'Flexión Diamante',
                'muscles' => ['Pecho', 'Tríceps', 'Abdominales Superiores', 'Hombros'],
                'videoURL' => 'https://www.youtube.com/embed/d-HOjHGRq-o&ab_channel=OPEXFitness'
            ],
            [
                'name' => 'Flexión Arquero',
                'muscles' => ['Pecho', 'Tríceps', 'Abdominales Superiores'],
                'videoURL' => 'https://www.youtube.com/embed/jiA3RnMxFU0&ab_channel=MichaelVazquez'
            ],
            [
                'name' => 'Dominada Prona',
                'muscles' => ['Dorsales', 'Bíceps', 'Trapecios', 'Hombros', 'Pecho'],
                'videoURL' => 'https://www.youtube.com/embed/jgFel4wZl3I'
            ],
            [
                'name' => 'Dominada Supina',
                'muscles' => ['Dorsales', 'Bíceps', 'Trapecios', 'Hombros', 'Pecho'],
                'videoURL' => 'https://www.youtube.com/embed/uv6mAYXe9Jg&ab_channel=MyPTHub'
            ],
            [
                'name' => 'Sentadilla',
                'muscles' => ['Glúteos', 'Cuádriceps', 'Isquiotibiales', 'Gemelos', 'Abdominales Superiores', 'Abdominales Inferiores'],
                'videoURL' => 'https://www.youtube.com/embed/Zqc_lc93hak'
            ],
            [
                'name' => 'Press de Banca',
                'muscles' => ['Pecho', 'Tríceps', 'Hombros'],
                'videoURL' => 'https://www.youtube.com/embed/ejI1Nlsul9k'
            ],
            [
                'name' => 'Press Militar',
                'muscles' => ['Trapecios', 'Pecho', 'Hombros', 'Tríceps'],
                'videoURL' => 'https://www.youtube.com/embed/MfJz1ArLcG4'
            ],
            [
                'name' => 'Remo',
                'muscles' => ['Dorsales', 'Trapecios', 'Hombros', 'Tríceps', 'Bíceps'],
                'videoURL' => 'https://www.youtube.com/embed/xQNrFHEMhI4'
            ],
            [
                'name' => 'Peso Muerto',
                'muscles' => ['Isquiotibiales', 'Glúteos', 'Gemelos', 'Abdominales Superiores', 'Abdominales Inferiores', 'Oblicuos'],
                'videoURL' => 'https://www.youtube.com/embed/TN3DHmd1Fe8'
            ],
            [
                'name' => 'Curl de Bíceps',
                'muscles' => ['Bíceps'],
                'videoURL' => 'https://www.youtube.com/embed/tMEGqKuOa-M'
            ],
            [
                'name' => 'Curl de Isquiotibial',
                'muscles' => ['Isquiotibiales'],
                'videoURL' => 'https://www.youtube.com/embed/I_76ClIR8z8'
            ],
            [
                'name' => 'Puente de Glúteos',
                'muscles' => ['Glúteos', 'Isquiotibiales'],
                'videoURL' => 'https://www.youtube.com/embed/szgXdRA2R6Y'
            ]
        ];
        //
        foreach ($exercises as $exercise) {
            $ex = Exercise::create([
                'name' => $exercise['name'],
                'description' => $faker->text,
                'videoURL' => $exercise['videoURL']]);
            foreach($exercise['muscles'] as $muscle) {
                $ex->muscles()->attach(Muscle::where('name', $muscle)->first()->id);
            }
            for($i = 1; $i <= 30; ++$i) {
                Set::create(['exercise_id' => $ex->id, 'repetitions' => $i]);
            }
        }
    }
}
