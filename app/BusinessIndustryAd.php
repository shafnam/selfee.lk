<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessIndustryAd extends Model
{
    //Table Name
    protected $table = 'business_industry_ads';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;
    
    /**
     * Get the ParentCategory that owns this Subcategory.
    */
    public function ads()
    {
        return $this->belongsTo('App\Ad');
    }
}
