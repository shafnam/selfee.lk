<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedAd extends Model
{
    //Table Name
    protected $table = 'rejected_ads';
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
