<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdFeature extends Model
{
    //Table Name
    protected $table = 'ad_features';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /**
     * Get the Ad that owns this Photo.
    */
    public function ads()
    {
        return $this->belongsTo('App\Ad');
    }
}
