<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable; //url slugs
use Illuminate\Support\Facades\Schema;

class Ad extends Model
{
    use Sluggable;
    
    /**
        * Return the sluggable configuration array for this model.
        *
        * @return array
        */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    //Table Name
    protected $table = 'ads';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* one to one relationship between ads and electronicsAd */
    public function electronics_ads()
    {
        return $this->hasOne('App\ElectronicsAd');
    }

    /* one to many relationship between ads and ad photos */
    public function ad_photos()
    {
        return $this->hasMany('App\AdPhoto','ad_id');
    }

    /* one to many relationship between ads and ad features */
    public function ad_features()
    {
        return $this->hasMany('App\AdFeature');
    }

    /* one to many relationship between ads and user-ids */
    public function customers()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    /* many to many relationship between ads and userphones */
    public function user_phones()
    {
        return $this->belongsToMany('App\UserPhone')->withTimestamps();
    }

    /* one to many relationship between ads and locations */
    public function locations()
    {
        return $this->belongsTo('App\Location','location_id');
    }

    /* one to many relationship between ads and categories */
    public function categories()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    /* one to one relationship between ads and vehiclesAd */
    public function vehicles_ads()
    {
        return $this->hasOne('App\VehiclesAd');
    }

    /* one to one relationship between ads and propertiesAd */
    public function properties_ads()
    {
        return $this->hasOne('App\PropertiesAd');
    }

    /* one to one relationship between ads and HomeGardenAd */
    public function home_garden_ads()
    {
        return $this->hasOne('App\HomeGardenAd');
    }

    /* one to one relationship between ads and HealthBeautyAd */
    public function health_beauty_ads()
    {
        return $this->hasOne('App\HealthBeautyAd');
    }
    
    /* one to one relationship between ads and SportsKidsAd */
    public function sport_kids_ads()
    {
        return $this->hasOne('App\SportKidsAd');
    }

    /* one to one relationship between ads and SportsKidsAd */
    public function business_industry_ads()
    {
        return $this->hasOne('App\BusinessIndustryAd');
    }

    /* one to one relationship between ads and ServicesAd */
    public function services_ads()
    {
        return $this->hasOne('App\ServicesAd');
    }

    /* one to one relationship between ads and EducationAd */
    public function education_ads()
    {
        return $this->hasOne('App\EducationAd');
    }

    /* one to one relationship between ads and AnimalsAd */
    public function animals_ads()
    {
        return $this->hasOne('App\AnimalsAd');
    }

    /* one to one relationship between ads and FoodAd */
    public function food_ads()
    {
        return $this->hasOne('App\FoodAd');
    }

    /* one to one relationship between ads and OtherAd */
    public function other_ads()
    {
        return $this->hasOne('App\OtherAd');
    }
    
    /* one to many relationship between ads and ad_types */
    public function ad_types()
    {
        return $this->belongsTo('App\AdType','ad_type_id');
    }

    /* one to one relationship between ads and ad_types */
    public function rejected_ads()
    {
        return $this->hasOne('App\RejectedAd');
    }

    public static function getConditionAdsCount($ad_condition,$category_slug,$location_slug = null,$ad_type_id = null,$min_price = null,$max_price= null,$ad_brand_id = null)
    {
        //ad_types filter is shown only on sub categories 
        $sub_ad_table_name  = null;
        $min_price = null; 
        $max_price = null;
        $ad_brand_name = null;
        $conditions = array();
        $category = Category::where('slug',$category_slug)->first();
        $conditions[] = ['status' , '=',  1];
        $conditions[] = ['category_id' , '=',  $category->id];
        if($ad_type_id){
            $conditions[] = ['type_id' , '=',  $ad_type_id];
        }
        if($min_price || $max_price) {
            if($min_price == null) {
                $min_price = 0;
            }
            if($max_price == null) {
                $max_price = '999999999999999999';
            }
        }
        
        //get the related table name
        $category_parent = Category::where('id',$category->parent_id)->first();
        $category_parent_slug = $category_parent->slug;
        
        if($category_parent_slug == 'electronics'){ $sub_ad_table_name = 'electronics_ads'; }
        else if($category_parent_slug == 'cars-vehicles'){ $sub_ad_table_name = 'vehicles_ads'; }
        else if($category_parent_slug == 'property'){ $sub_ad_table_name = 'properties_ads'; }
        else if($category_parent_slug == 'home-garden'){ $sub_ad_table_name = 'home_garden_ads'; }
        else if($category_parent_slug == 'fashion-health-beauty'){ $sub_ad_table_name = 'health_beauty_ads'; }
        else if($category_parent_slug == 'hobby-sport-kids'){ $sub_ad_table_name = 'sport_kids_ads'; }
        else if($category_parent_slug == 'business-industry'){ $sub_ad_table_name = 'business_industry_ads'; }
        else if($category_parent_slug == 'services'){ $sub_ad_table_name = 'services_ads'; }
        else if($category_parent_slug == 'education'){ $sub_ad_table_name = 'education_ads'; }
        else if($category_parent_slug == 'animals'){ $sub_ad_table_name = 'animals_ads'; }
        else if($category_parent_slug == 'food-agriculture'){ $sub_ad_table_name = 'food_ads'; }
        else if($category_parent_slug == 'other'){ $sub_ad_table_name = 'other_ads'; }

        if(Schema::hasColumn($sub_ad_table_name, 'brand')){
            if($ad_brand_id){
                $ad_brand = Brand::where('id', $ad_brand_id)->first();
                $ad_brand_name = $ad_brand->name;
            }
        }

        if($location_slug){
            $location = Location::where('slug',$location_slug)->first();
            if($location->parent_id == 0){
                //location
                $sub_location_ids = Location::where('parent_id',$location->id)->pluck('id');
                
                $query = Ad::whereIn('location_id',$sub_location_ids)
                ->where($conditions)
                ->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                    $q->where('condition', '=', $ad_condition);
                });
                if($min_price != null || $max_price != null){
                    $query = $query->whereBetween('price', [$min_price, $max_price]);
                }
                if(Schema::hasColumn($sub_ad_table_name, 'brand') && $ad_brand_name != null){
                    $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                        $q->where('brand',$ad_brand_name);
                    });
                }
                $adTypeAdCount = $query->count();
            }else{
                //sub location
                $query = Ad::where('location_id',$location->id)
                ->where($conditions)
                ->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                    $q->where('condition', '=', $ad_condition);
                });
                if($min_price != null || $max_price != null){
                    $query = $query->whereBetween('price', [$min_price, $max_price]);
                }
                if(Schema::hasColumn($sub_ad_table_name, 'brand') && $ad_brand_name != null){
                    $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                        $q->where('brand',$ad_brand_name);
                    });
                }
                $adTypeAdCount = $query->count();
            }
        }
        else{
            
            $query = Ad::where($conditions)
            ->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                $q->where('condition', '=', $ad_condition);
            });
            if($min_price != null || $max_price != null){
                $query = $query->whereBetween('price', [$min_price, $max_price]);
            }
            if(Schema::hasColumn($sub_ad_table_name, 'brand') && $ad_brand_name != null){
                $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                    $q->where('brand',$ad_brand_name);
                });
            }
            $adTypeAdCount = $query->count();
        }

        return $adTypeAdCount;
    }

    public static function getRelatedAdsByCatSlug($category_slug){
        //this is always a parent cat
        $category = Category::where('slug',$category_slug)->first();
        //dd($category->id);
        $child_cat_ids = Category::where('parent_id',$category->id)->get();
        //dd($child_cat_ids);
        $relatedFourAds = Ad::where('status', 1)->whereIn('category_id',$child_cat_ids)->inRandomOrder()->limit(4)->get();
        
        return $relatedFourAds;

    }

}
