<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'notes',
        'date',
        'weight',
        'fat_percentage'
    ];
    /**
     * The sets that belong to the user.
     */
    public function sets()
    {
        return $this->belongsToMany(Set::class)->withPivot('weight');
    }

    /**
     * Get the user that owns the workout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
