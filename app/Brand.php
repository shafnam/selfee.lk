<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Brand extends Model
{
    
    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function getBrands($category_slug){
        
        $category_id = \App\Category::where('slug',$category_slug)->pluck('id');
        $brands = \App\Brand::where('category_id',$category_id)->pluck('name', 'name');
        $brands->prepend('Select...', "");

        return $brands;

    }

    public static function getBrandsDetails($category_id){
        
        //$category_id = \App\Category::where('slug',$category_slug)->pluck('id');
        $brands = \App\Brand::where('category_id',$category_id)->get();

        return $brands;

    }

    public static function getBrandAdsCount($id,$category_slug,$location_slug = null,$ad_type_id =null, $min_price = null,$max_price = null,$ad_cond = null){
        
        //ad_types filter is shown only on sub categories 
        $conditions = array();
        $sub_ad_table_name  = null;
        $min_price = null; 
        $max_price = null;
        $ad_condition = null;

        $ad_brand = Brand::where('id', $id)->first();        
        $category = Category::where('slug',$category_slug)->first();//this is always a subcategory

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
        
        $ad_brand_name = $ad_brand->name;
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
            //$adTypeAdCount = Ad::whereIn('location_id',$sub_location_ids)->where($conditions)->whereBetween('price', [$min_price, $max_price])->count();
        }
        
        if(Schema::hasColumn($sub_ad_table_name, 'condition')){
            if($ad_cond){
                //ad condition selected
                $ad_condition = $ad_cond;
            }
        }

        if($location_slug){
            
            $location = Location::where('slug',$location_slug)->first();

            if($location->parent_id == 0){
                //location
                $sub_location_ids = Location::where('parent_id',$location->id)->pluck('id');              
                
                $query = Ad::whereIn('location_id',$sub_location_ids)
                ->where($conditions)
                ->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                    $q->where('brand', '=', $ad_brand_name);
                });
                if($min_price != null || $max_price != null){
                    $query = $query->whereBetween('price', [$min_price, $max_price]);
                }
                if(Schema::hasColumn($sub_ad_table_name, 'condition') && $ad_condition != null){
                    $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                        $q->where('condition',$ad_condition);  
                    });
                }
                $adBrandAdCount = $query->count();                
            }else{
                //sub location
                $conditions[] = ['location_id' , '=',  $location->id];
                
                $query = Ad::where($conditions)
                ->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                    $q->where('brand', '=', $ad_brand_name);
                });
                if($min_price != null || $max_price != null){
                    $query = $query->whereBetween('price', [$min_price, $max_price]);
                }
                if(Schema::hasColumn($sub_ad_table_name, 'condition') && $ad_condition != null){
                    $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                        $q->where('condition',$ad_condition);  
                    });
                }
                $adBrandAdCount = $query->count();               
            }
        }
        else{
            
            $query = Ad::where($conditions)
            ->whereHas($sub_ad_table_name, function($q) use ($ad_brand_name){
                $q->where('brand', '=', $ad_brand_name);
            });
            if($min_price != null || $max_price != null){
                $query = $query->whereBetween('price', [$min_price, $max_price]);
            }
            if(Schema::hasColumn($sub_ad_table_name, 'condition') && $ad_condition != null){
                $query = $query->whereHas($sub_ad_table_name, function($q) use ($ad_condition){
                    $q->where('condition',$ad_condition);  
                });
            }
            $adBrandAdCount = $query->count();        
        }

        return $adBrandAdCount;
    }
}
