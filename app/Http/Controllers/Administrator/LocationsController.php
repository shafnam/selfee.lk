<?php

namespace App\Http\Controllers\Administrator;

use App\Location;
use App\Slug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function locationList($id =null){
        if($id){
            $all_locations =  Location::where('parent_id',$id)->get();
            $location = Location::where('id',$id)->first();
            return view('administrator.locations.locations-list',compact('all_locations','location'));
        }
        $all_locations = Location::where('parent_id',0)->get();
        return view('administrator.locations.locations-list',compact('all_locations','location'));
    }

    public function locationAdd(){
        return view('administrator.locations.locations-add');
    }

    public function locationSave(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|regex:/^[a-zA-Z0-9 _-]+$/',
            'slug' => 'string|required|unique:locations|regex:/[a-z0-9-]+/'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.location.add.get'))
                ->withErrors($validator)
                ->withInput();
        }

        $location = new Location();
        $location->name = $request->get('name');
        $location->slug = $request->get('slug');
        $location->parent_id = 0;
        $location->save();
        /*$slug = new Slug();
        $slug->slug = $request->get('slug');
        $slug->save();*/
        return redirect(route('administrator.location.add.get'))->with('success_messge',"Location Added successfully...");
    }

    public function locationEdit($id,Request $request){
        $location = Location::where('id',$id)->where('parent_id',0)->first();
        if(!$location){
            return redirect(route('administrator.location.list'));
        }
        return view('administrator.locations.locations-edit',compact('location'));
    }

    public function locationUpdate($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|regex:/^[a-zA-Z0-9]+$/',
            'slug' => 'string|required|regex:/[a-z0-9-]+/'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.location.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }
        $location = Location::find($id);
        $location->name = $request->get('name');
        $location->slug = $request->get('slug');

        /*if($location->slug == $request->get('slug')){
            $slugCheck = Slug::where('slug',$request->get('slug'))->count();
            if($slugCheck == 0){
                $slug = new Slug();
                $slug->slug = $location->slug;
                $slug->save();
            }
        }else{
            $slug = Slug::checkSlug( $request->get('name'), $request->get('slug'));
            $location->slug = $slug;
            $slug = new Slug();
            $slug->slug = $slug;
            $slug->save();
        }*/

        $location->save();

        return redirect(route('administrator.location.edit.get',[$id]))->with('success_messge',"Location updated successfully...");
    }
    /**
     * sub locations
     */

    public function subLocationList(){
        $all_sub_locations = Location::where('parent_id','!=',0)->orderBy('parent_id','DESC')->get();
        return view('administrator.locations.sub-locations-list',compact('all_sub_locations'));
    }

    public function subLocationAdd($id = null){
        $all_locations = Location::where('parent_id',0)->get();
        if($id){
            $location = Location::where('id',$id)->first();
            return view('administrator.locations.sub-locations-add',compact('all_locations','location'));
        }
        return view('administrator.locations.sub-locations-add',compact('all_locations'));
    }

    public function subLocationSave(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|regex:/^[a-zA-Z0-9 _-]+$/',
            'slug' => 'string|required|unique:locations|regex:/[a-z0-9-]+/',
            'parent_location' => 'numeric|required|min:1'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.sub-location.add.get'))
                ->withErrors($validator)
                ->withInput();
        }

        $sub_location = new Location();
        $sub_location->name = $request->get('name');
        $sub_location->slug = $request->get('slug');
        $sub_location->parent_id = $request->get('parent_location');
        $sub_location->save();
        /*$slug = new Slug();
        $slug->slug = $request->get('slug');
        $slug->save();*/
        return redirect(route('administrator.sub-location.add.get'))->with('success_messge',"Sub Location Added successfully...");
    }

    public function subLocationEdit($id,Request $request){
        $sub_location = Location::where('id',$id)->where('parent_id', '!=',0)->first();
        if(!$sub_location){
            return redirect(route('administrator.sub-location.list'));
        }
        $all_locations = Location::where('parent_id',0)->get();
        return view('administrator.locations.sub-locations-edit',compact('sub_location',"all_locations"));
    }

    public function subLocationUpdate($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|regex:/^[a-zA-Z0-9]+$/',
            'slug' => 'string|required|regex:/[a-z0-9-]+/',
            'parent_location' => 'numeric|required|min:1'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.sub-location.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }
        $sub_location = Location::find($id);
        $sub_location->name = $request->get('name');
        $sub_location->slug = $request->get('slug');
        /*if($sub_location->slug == $request->get('slug')){
            $slugCheck = Slug::where('slug',$request->get('slug'))->count();
            if($slugCheck == 0){
                $slug = new Slug();
                $slug->slug = $sub_location->slug;
                $slug->save();
            }
        }else{
            $slug = Slug::checkSlug( $request->get('name'), $request->get('slug'));
            $sub_location->slug = $slug;
            $sub_location->parent_id = $request->get('parent_location');
            $slug = new Slug();
            $slug->slug = $slug;
            $slug->save();
        }*/
        $sub_location->save();
        return redirect(route('administrator.sub-location.edit.get',[$id]))->with('success_messge',"Location updated successfully...");
    }
}
