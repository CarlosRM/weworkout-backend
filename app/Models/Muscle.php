<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muscle extends Model
{
    use HasFactory;

    /**
     * The exercise that belong to the role.
     */
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
