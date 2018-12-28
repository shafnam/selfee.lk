<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* one to many relationship between user and phones */
    public function user_phones()
    {
        return $this->hasMany('App\UserPhone');
    }

    /* one to many relationship between user and ads */
    public function ads()
    {
        return $this->hasMany('App\Ad');
    }
}
