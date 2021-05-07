<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'visualizations'
    ];

    /**
     * The categories that the routine has.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The sets that the routine has.
     */
    public function sets()
    {
        return $this->belongsToMany(Set::class);
    }

    /**
     * Get the user that owns the routine.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Get the followers for the user */
    public function favouritedBy()
    {
        return $this->belongsToMany(
            User::class, 
            'favourite_routines'
        );
    }

    /**
     * Get the comments for the routine.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the comments for the user.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /* Get the similars for the routine */
    public function similar()
    {
        return $this->belongsToMany(
            self::class, 
            'similar_routines',
            'routine',
            'similar'
        );
    }
}
