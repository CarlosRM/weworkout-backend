<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    /**
     * The muscles that belong to the user.
     */
    public function muscles()
    {
        return $this->belongsToMany(Set::class);
    }
}
