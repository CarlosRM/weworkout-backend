<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    /**
     * Get the Exercise that the set referes to.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * The routines that the set belongs to.
     */
    public function routines()
    {
        return $this->belongsToMany(Routine::class);
    }

    /**
     * The workout that belong to the user.
     */
    public function workouts()
    {
        return $this->belongsToMany(Workout::class)->withPivot('weight');
    }

}
