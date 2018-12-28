<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Category;

class Type extends Model
{
    public function getTypes($category_slug){
        
        $category_id = \App\Category::where('slug',$category_slug)->pluck('id');
        $types = \App\Type::where('category_id',$category_id)->pluck('name', 'name');
        $types->prepend('Select...', "");

        return $types;

    }

    public function getBodyTypes($category_slug){
        
        $category_id = \App\Category::where('slug',$category_slug)->pluck('id');
        $bodyTypes = \App\Type::where('category_id',$category_id)->where('division','body')->pluck('name', 'name');
        $bodyTypes->prepend('Select...', "");

        return $bodyTypes;

    }

    public function getTransmissions($category_slug){
        
        $category_id = \App\Category::where('slug',$category_slug)->pluck('id');
        $transmissions = \App\Type::where('category_id',$category_id)->where('division','transmission')->pluck('name', 'name');
        $transmissions->prepend('Select...', "");

        return $transmissions;

    }

    public static function getTypesDetails($category_id){
        
        $types = \App\Type::where('category_id',$category_id)->get();

        return $types;

    }

    public static function getCarTypesDetails($category_id){
        
        $types = \App\Type::where('category_id',$category_id)->where('division','body')->get();

        return $types;

    }

    public static function getTransmissionsDetails($category_id){

        $transmissions = \App\Type::where('category_id',$category_id)->where('division','transmission')->get();
        
        return $transmissions;

    }

    public static function catTypesCount($category_id){

        $cat_types_count = \App\Type::where('category_id',$category_id)->count();
        
        return $cat_types_count;

    }
}
