<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Location extends Model
{
    //Table Name
    protected $table = 'locations';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;
    
    /* one to many relationship between ads, categories parent categoies */
    public function ads(){
        return $this->hasMany('App\Ad');
    }

    public function children()
    {
        return $this->hasMany('App\Location', 'parent_id');
    }

    public function childrenAds()
    {
        return $this->hasManyThrough('App\Ad', 'App\Location', 'parent_id');
    }

    public function getAdCountAttribute()
    {
        return $this->ads()->count() + $this->childrenAds()->count();
    }

    public function getLocations(){
        
        $locations = \App\Location::where('parent_id',0)->orderBy('name', 'asc')->get();//united

        $locations = $this->addRelation($locations);

        return $locations;

    }

    protected function selectChild($id){
        $locations= \App\Location::where('parent_id',$id)->orderBy('name', 'asc')->get(); //rooney

        $locations = $this->addRelation($locations);

        return $locations;

    }

    protected function addRelation($locations){

        $locations->map(function ($item, $key) {
            
            $sub = $this->selectChild($item->id); 
            
            return $item = array_add($item,'subLocation',$sub);

        });

        return $locations;
    }

    public function getSingleLocationBySlug($slug){
        
        $locationDetails = \App\Location::where('slug', $slug)->first();
        
        return $locationDetails;
    }

    public static function getSingleLocationParent($loc_parent_id){
        
        $locationParentDetails = \App\Location::where('id', $loc_parent_id)->first();
        
        return $locationParentDetails;
    }

    public static function getLocationAdsCount($id,$category_id = null,$ad_type_id = null,$min_price = null, $max_price = null, $ad_cond = null, $ad_brand_id = null){
        
        $filterConditions = array();
        $sub_ad_table_name  = null;
        $min_price = null; 
        $max_price = null;
        $ad_condition = null;
        $ad_brand_name = null;
        
        //common for all ads;
        $location = Location::where('id',$id)->first();

        $filterConditions[] = ['status' , '=',  1];
        $filterConditions[] = ['category_id' , '=',  $category_id];

        if($ad_type_id){
            $filterConditions[] = ['type_id' , '=',  $ad_type_id];
        }

        if( ($min_price) || ($max_price) ){
            if(!isset($min_price)){
                $min_price = '0';
            }
            if(!isset($max_price)){
                $max_price = '999999999999999999';
            }
        }

        if($category_id){
            $category = Category::where('id',$category_id)->first();
                        
            if($category->parent_id == 0){
                //category
                $sub_categories_ids = Category::where('parent_id', $category->id)->pluck('id');
                if($location->parent_id == 0){
                    //location
                    $sub_location_ids = Location::where('parent_id', $id)->pluck('id');
                    $locationAdCount = Ad::where('status', 1)->whereIn('category_id',$sub_categories_ids)->whereIn('location_id',$sub_location_ids)->count();
                }else{
                    //sub location
                    $locationAdCount = Ad::where('status', 1)->whereIn('category_id',$sub_categories_ids)->where('location_id',$id)->count();
                }
            }else{
                //sub category
                
                //get the related table details
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

                //other filters only on specific categories
                if(Schema::hasColumn($sub_ad_table_name, 'condition')){
                    if($ad_cond){
                        //ad condition selected
                        $ad_condition = $ad_cond;
                    }
                }

                if(Schema::hasColumn($sub_ad_table_name, 'brand')){
                    if($ad_brand_id){
                        $ad_brand = Brand::where('id', $ad_brand_id)->first();
                        $ad_brand_name = $ad_brand->name;
                    }
                }

                if($location->parent_id == 0){
                    //location
                    $sub_location_ids = Location::where('parent_id', $id)->pluck('id');
                    
                    $query = Ad::whereIn('location_id',$sub_location_ids)
                    ->where($filterConditions);
                    if($min_price != null || $max_price != null){
                        $query = $query->whereBetween('price', [$min_price, $max_price]);
                    }
                    if(Schema::hasColumn($sub_ad_table_name, 'condition') && $ad_condition != null){
                        $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                            $q->where('condition',$ad_condition);  
                        });
                    }
                    if(Schema::hasColumn($sub_ad_table_name, 'brand') && $ad_brand_name != null){
                        $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                            $q->where('brand',$ad_brand_name);
                        });
                    }
                    $locationAdCount = $query->count();
                }else{
                    //sub location                    
                    $query = Ad::where('location_id',$id)
                    ->where($filterConditions);
                    if($min_price != null || $max_price != null){
                        $query = $query->whereBetween('price', [$min_price, $max_price]);
                    }
                    if(Schema::hasColumn($sub_ad_table_name, 'condition') && $ad_condition != null){
                        $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                            $q->where('condition',$ad_condition);  
                        });
                    }
                    if(Schema::hasColumn($sub_ad_table_name, 'brand') && $ad_brand_name != null){
                        $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                            $q->where('brand',$ad_brand_name);
                        });
                    }                    
                    $locationAdCount = $query->count();
                }
            }

        }else{
            if($location->parent_id == 0){
                //location
                $sub_location_ids = Location::where('parent_id', $id)->pluck('id');
                $locationAdCount = Ad::where('status', 1)->whereIn('location_id',$sub_location_ids)->count();
            }else{
                //sub location
                $locationAdCount = Ad::where('status', 1)->where('location_id',$id)->count();
            }
        }

        return $locationAdCount;
    }

    public static function getSubLocationByLocationId($parent_id){
        $sublocation = Location::where('parent_id',$parent_id)->get();
        return $sublocation;
    }

    public static function getSubLocations($parent_id){
        $sub_locations = Location::select('name')->where('parent_id',$parent_id)->get();
        return $sub_locations;
    }

    public static function getParentLocation($parent_id){
        $parent_location = Location::where('id',$parent_id)->first();
        return $parent_location;
    }

    public static function getAllLocations(){
        $locations = \App\Location::where('parent_id',0)->get();
        return $locations;
    }

    public static function getSubLocationByParentLocation($parent_location){
        $parent_id = Location::where('name',$parent_location)->pluck('id');
        $sublocation = Location::where('parent_id',$parent_id)->get();
        return $sublocation;
    }

    public static function checkLocationSlug($name,$slug){
        if(!$slug){
            $slug_check_status = Location::where('slug',$name)->count();
        }else{
            $slug_check_status = Location::where('slug',$slug)->count();
        }
        if($slug_check_status != 0){
            return $slug;
        }else{
            if($slug){
               return Location::createSlug($slug);
            }else{
               return Location::createSlug($name);
            }
        }
    }

    public static function createSlug($string){
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        $slug= strtolower($slug);
        $old_slug = $slug;
        $status = true;
        $count = 1;
        do{
            $slug_check_status = Location::where('slug',$slug)->count();
            if($slug_check_status == 0){
                $status = false;
            }else{
                $slug = $old_slug."-".$count;
            }
            $count++;
        }while($status);

        return $slug;
    }
}
