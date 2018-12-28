<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use App\Category;
use App\Location;

class PagesController extends Controller
{
    public function index(){
        
        $ad = new Ad;
        $categories = new Category;
        $locations = new Location;

        $topCategories = $categories->getTopFourCategories();    
        $parentLocations = $locations->getLocations();
        $itemServiceCategories = Category::with(['childrenads' => function($q) {
            $q->where('ads.status', '=', 1);
        } ,'children.ads' => function($q){
            $q->where('ads.status', '=', 1);
        }])->where('type','item-or-service')->get();

        return view('pages.index', compact('topCategories', 'itemServiceCategories', 'parentLocations'));
        
        //return view('pages.index');
    }

    public function about(){
        return view('pages.about');
    }

    public function services(){
        return view('pages.services');
    }

    public function contact(){
        return view('pages.contact');
    }

    /*public function showAdParentCategories()
    {
        $adParentCategories = Category::where('category_parent_id',0)->get();
        return $adParentCategories;
    }

    public function showAdParentLocations()
    {
        $adParentLocations = Location::where('location_parent_id',0)->get();
        return $adParentLocations;
    }*/
}
