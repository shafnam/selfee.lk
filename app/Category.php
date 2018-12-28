<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;


class Category extends Model
{
    //Table Name
    protected $table = 'categories';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;
    
    /* sub category has many ads */
    public function ads(){
        return $this->hasMany('App\Ad');
    }

    /* category belong to parent */
    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    /* category has many children */
    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    /* category has many subcategory ads */
    public function childrenads()
    {
        return $this->hasManyThrough('App\Ad', 'App\Category', 'parent_id');
    }

    /* count of all ads from categories and subcategories*/
    public function getAdCountAttribute()
    {  
        return $this->ads()->count() + $this->childrenads()->count();
    }

    /* one to many relationship between categories and features */
    public function features(){
        return $this->hasMany('App\Feature');
    }

    /* category has many brands */
    public function brands(){
        return $this->hasMany('App\Brand');
    }

    /* Select all the categories where parent_id =0 */
    public function getCategories(){
        
        $categories = \App\Category::where('parent_id',0)->get();//united

        $categories = $this->addRelation($categories);

        return $categories;

    }

    protected function selectChild($id){
        
        $categories= \App\Category::where('parent_id',$id)->get(); //rooney

        $categories = $this->addRelation($categories);

        return $categories;

    }

    protected function addRelation($categories){

        $categories->map(function ($item, $key) {
            
            $sub = $this->selectChild($item->id); 
            
            return $item=array_add($item,'subCategory',$sub);

        });

        return $categories;
    }

    public function getSingleCategoryBySlug($slug){
        
        $categoryDetails = \App\Category::where('slug', $slug)->first();
        
        return $categoryDetails;
    }

    public static function getSingleCategoryParent($cat_parent_id){
        
        $categoryParentDetails = \App\Category::where('id', $cat_parent_id)->first();
        
        return $categoryParentDetails;
    }

    public function getTopFourCategories(){
        
        $topCategories = \App\Category::where('parent_id',0)->limit(4)->get();
        
        return $topCategories;

    }

    public function selectChildCatgoryByType($type){

        $categories = \App\Category::where('type', $type)->get();
        
        $categories = $this->addRelation($categories);
        
        return $categories;        

    }

    public function getItemServiceCategories(){ 
        
        $itemServiceCategories = \App\Category::where('type','item-or-service')->withCount('ads')->get();
        
        return $itemServiceCategories;

    }

    public static function getCategoryAdsCount($id,$location_id = null,$ad_type_id = null,$min_price = null, $max_price = null,$ad_cond = null,$ad_brand_id = null){

        $filterConditions = array();
        $sub_ad_table_name  = null;
        $min_price = null; 
        $max_price = null;
        $ad_condition = null;
        $ad_brand_name = null;
        $categoryAdCount = 0;

        $category = Category::where('id',$id)->first();
        
        $filterConditions[] = ['category_id' , '=',  $id];
        $filterConditions[] = ['status' , '=',  1];
        
        if($ad_type_id){ $filterConditions[] = ['type_id' , '=',  $ad_type_id]; }

        if(($min_price) || ($max_price)){
            if(!isset($min_price)){
                $min_price = '0';
            }
            if(!isset($max_price)){
                $max_price = '999999999999999999';
            }
        }
        
        if($location_id){
            $location = Location::where('id',$location_id)->first();

            if($location->parent_id == 0){
                //location
                $sub_location_ids = Location::where('parent_id',$location_id)->pluck('id');
                if($category->parent_id == 0){
                    //category
                    $sub_category_ids = Category::where('parent_id',$id)->pluck('id');
                    $categoryAdCount = Ad::where('status', 1)->whereIn('location_id',$sub_location_ids)->whereIn('category_id',$sub_category_ids)->count();
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

                    if($sub_ad_table_name){
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
                        $categoryAdCount  = $query->count();
                    }
                }
            }else{
                //sub location
                if($category->parent_id == 0){
                    //category
                    $sub_category_ids = Category::where('parent_id',$id)->pluck('id');
                    $categoryAdCount = Ad::where('status', 1)->whereIn('category_id',$sub_category_ids)->where('location_id',$location->id)->count();
                }else{
                    //sub category
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

                    if($sub_ad_table_name){
                        $query = Ad::where('location_id',$location->id)
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
                        $categoryAdCount = $query->count();
                    }
                }
            }
        }else{
            if($category->parent_id == 0){
                //category
                $sub_category_ids = Category::where('parent_id',$id)->pluck('id');
                $categoryAdCount = Ad::where('status', 1)->whereIn('category_id',$sub_category_ids)->count();
            }else{
                //subcategory
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
            
                if($sub_ad_table_name){
                    $query = Ad::where($filterConditions);
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
                    $categoryAdCount = $query->count();
                }
            }
        }

        return $categoryAdCount;
    }

    /**
     * get sub categories using category id;
    */

    public static function getSubCategoryByCategoryId($id){
        $subcategory  = Category::where('parent_id',$id)->get();
        return $subcategory;
    }

    /**
     * get parent category details using category_id;
    */

    public static function getParentCategoryByCategoryId($id){
        $parent_id  = Category::where('id',$id)->pluck('parent_id')->first();
        $parent_category_details = Category::where('id',$parent_id)->first();
        return $parent_category_details;
        //return $parent_id;
    }

    public static function getSubCategories($parent_id){
        $sub_categories = Category::select('name','id')->where('parent_id',$parent_id)->get();
        return $sub_categories;
    }

    public static function getParentCategory($parent_id){
        $parent_category = Category::where('id',$parent_id)->first();
        return $parent_category;
    }

    public static function setBreadcrumbs($id){
        $breadcrumbs = array();
        $status =true;
        do{
            $set = Category::getBreadcrumbs($id);
            if($set){
                array_push($breadcrumbs,$set);
                if($set[2] == 0){

                }
                $id = $set[2];
            }else{
                $status =false;
            }
        }while($status);
        return  $breadcrumbs;
    }

    public static function getBreadcrumbs($id){
        $sub_categories = Category::select('name','id','parent_id')->where('id',$id)->first();
        if($sub_categories){
            $breadcrumbs = array($sub_categories->id,$sub_categories->name,$sub_categories->parent_id);
            return $breadcrumbs;
        }
        return null;
    }

    public static function hasChildCategory($id){
        
        $has_child_categories = Category::select('id')->where('parent_id',$id)->first();
        
        if($has_child_categories){
            return true;
        }
        return false;
    }

    public static function checkCategorySlug($name,$slug){
        if(!$slug){
            $slug_check_status = Category::where('slug',$name)->count();
        }else{
            $slug_check_status = Category::where('slug',$slug)->count();
        }
        if($slug_check_status != 0){
            return $slug;
        }else{
            if($slug){
               return Category::createSlug($slug);
            }else{
               return Category::createSlug($name);
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
            $slug_check_status = Category::where('slug',$slug)->count();
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
