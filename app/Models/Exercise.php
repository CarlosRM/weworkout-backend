<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    /**
     * The muscles that belong to the user.
     */
    public function muscles()
    {
        return $this->belongsToMany(Muscle::class);
    }

    /* This exercise can be in many sets */
    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    
    /* Get the similars for the exercise */
    public function similar()
    {
        return $this->belongsToMany(
            self::class, 
            'similar_exercises',
            'exercise',
            'similar'
        );
    }
}
