<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'genre',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'datetime'
    ];

    /**
     * Get the comments for the user.
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

    /**
     * Get the routines for the user.
     */
    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    /* Get the followers for the user */
    public function followers()
    {
        return $this->belongsToMany(
            self::class, 
            'followers',
            'followee',
            'follower'
        );
    }

    /* Get the followeed for the user */
    public function followees()
    {
        return $this->belongsToMany(
            self::class, 
            'followers',
            'follower',
            'followee'
        );
    }

    /* Get the followers for the user */
    public function favouriteRoutines()
    {
        return $this->belongsToMany(
            Routine::class, 
            'favourite_routines'
        );
    }
}
