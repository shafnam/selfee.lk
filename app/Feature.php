<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    //Table Name
    protected $table = 'features';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /**
     * Get the Ad that owns this Photo.
    */
    public function categories()
    {
        return $this->belongsTo('App\Category');
    }

    public function getFeatures($cat_id){
        
        $features = \App\Feature::where('category_id',$cat_id)->pluck('title');
        //$features->prepend('Select...', "");

        return $features;

    }

    public static function getFeaturesDetails($category_id){
        
        $features = \App\Feature::where('category_id',$category_id)->get();

        return $features;

    }

    public static function catFeaturesCount($category_id){

        $cat_features_count = \App\Feature::where('category_id',$category_id)->count();
        
        return $cat_features_count;

    }
}
