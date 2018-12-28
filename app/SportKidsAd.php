<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SportKidsAd extends Model
{
    //Table Name
    protected $table = 'sport_kids_ads';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* One to many */
    public function ads()
    {
        return $this->belongsTo('App\Ad');
    }
}
