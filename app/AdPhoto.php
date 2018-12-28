<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPhoto extends Model
{   
    //Table Name
    protected $table = 'ad_photos';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /**
     * Get the Ad that owns this Photo.
    */
    public function ads()
    {
        return $this->belongsTo('App\Ad','ad_id' ,'Owner');
    }
}
