<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AdType extends Model
{
    //Table Name
    protected $table = 'ad_types';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* one to many relationship between categories and ads */
    public function ads(){
        return $this->hasMany('App\Ad');
    }

    public function getSingleAdTypeBySlug($slug){
        
        $adTypeDetails = \App\Adtype::where('slug', $slug)->first();
        
        return $adTypeDetails;
    }
    
    public static function getAdTypeAdsCount($id,$category_slug,$location_slug = null,$min_price = null,$max_price = null,$ad_cond = null,$ad_brand_id = null){

        //ad_types filter is shown only on sub categories 
        $conditions = array();
        $sub_ad_table_name  = null;
        $min_price = null; 
        $max_price = null;
        $ad_condition = null;
        $ad_brand_name = null;

        $category = Category::where('slug',$category_slug)->first();//this is always a subcategory
        
        $conditions[] = ['status' , '=',  1];
        $conditions[] = ['type_id' , '=',  $id];
        $conditions[] = ['category_id' , '=',  $category->id];

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

        if($location_slug){
            
            $location = Location::where('slug',$location_slug)->first();

            if($location->parent_id == 0){
                //location
                $sub_location_ids = Location::where('parent_id',$location->id)->pluck('id');
                
                $query = Ad::whereIn('location_id',$sub_location_ids)
                ->where($conditions);
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
                $adTypeAdCount = $query->count();   
            }else{
                //sub location
                $conditions[] = ['location_id' , '=',  $location->id];
                
                $query = Ad::where($conditions);
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
                $adTypeAdCount = $query->count();
            }
        }
        else{
            
            $query = Ad::where($conditions);
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
            $adTypeAdCount = $query->count();           
        }

        return $adTypeAdCount;
    }
}
