<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Muscle;

class MuscleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bodypart: Brazo

        $armMuscles = [
            'Bíceps',
            'Tríceps',
            'Hombros',
            'Antebrazos'
        ];

        foreach ($armMuscles as $muscle) {
            Muscle::create(['name' => $muscle, 'bodypart' => 'Brazo']);
        }

        // BodyPart: Pierna
        $legMuscles = [
            'Cuádriceps',
            'Isquiotibiales',
            'Glúteos',
            'Gemelos'
        ];

        foreach ($legMuscles as $muscle) {
            Muscle::create(['name' => $muscle, 'bodypart' => 'Pierna']);
        }

        // Bodypart: Core
        $frontMuscles = [
            'Abdominales Superiores',
            'Abdominales Inferiores',
            'Pecho'
        ];

        foreach ($frontMuscles as $muscle) {
            Muscle::create(['name' => $muscle, 'bodypart' => 'Torso']);
        }

        $backMuscles = [
            'Dorsales',
            'Oblicuos',
            'Trapecios'
        ];

        foreach ($backMuscles as $muscle) {
            Muscle::create(['name' => $muscle, 'bodypart' => 'Espalda']);
        }


    }
}
