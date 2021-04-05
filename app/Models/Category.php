<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The exercise that belong to the role.
     */
    public function routines()
    {
        return $this->belongsToMany(Routine::class);
    }
}
