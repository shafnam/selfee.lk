<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    protected $table = 'all_slug';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    public static function checkSlug($name,$slug){
        if(!$slug){
            $slug_check_status = Slug::where('slug',$name)->count();
        }else{
            $slug_check_status = Slug::where('slug',$slug)->count();
        }
        if($slug_check_status != 0){
            return $slug;
        }else{
            if($slug){
               return Slug::createSlug($slug);
            }else{
               return Slug::createSlug($name);
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
            $slug_check_status = Slug::where('slug',$slug)->count();
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
