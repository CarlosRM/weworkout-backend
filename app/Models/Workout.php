<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    /**
     * The sets that belong to the user.
     */
    public function sets()
    {
        return $this->belongsToMany(Set::class);
    }
}
