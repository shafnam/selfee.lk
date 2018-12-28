<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Ad;
use App\AdType;
use App\Category;
use App\Location;
use App\Brand;
use App\ElectronicsAd;
use App\AdPhoto;
use App\Feature;
use App\AdFeature;
use Auth;
use App\UserPhone;
use App\Type;
use App\VehiclesAd;
use App\PropertiesAd;
use App\HomeGardenAd;
use App\HealthBeautyAd;
use App\SportKidsAd;
use App\BusinessIndustryAd;
use App\ServicesAd;
use App\EducationAd;
use App\AnimalsAd;
use App\FoodAd;
use App\OtherAd;
use DB;

class AdsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'showAdBySlug', 'showAdsByCategorySlug',
        'showAdsBySubCategorySlug','showAdsByLocationSlug','showAdsBySubLocationSlug','orderData','showAdsByLocationSlugAndCategorySlug']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {   
        $location_slug = $request->location_slug;
        $category_slug = $request->category_slug;
        $searchTerm = $request->get('searchTerm');
        $orderAds = $request->get('orderAds');
        //$ad_type = $request->get('ad_type');
        $category_id = null;
        $subCategorySet = null;
        $ad_type_id = null;
        $ad_type_id = $request->get('ad_type');
        $max_price = $request->get('price_max');
        $min_price = $request->get('price_min');
        
        
        $ads = Ad::where('status',1);

        //categories and sub categories where ad status is published
        $categories = Category::with(['childrenads' => function($q) {
            $q->where('ads.status', '=', 1);
        } ,'children.ads' => function($q){
            $q->where('ads.status', '=', 1);
        }])->where('parent_id',0);

        //locations and sub locations where ad status is published
        $locations = Location::with(['childrenads' => function($q) {
            $q->where('ads.status', '=', 1);
        } ,'children.ads' => function($q){
            $q->where('ads.status', '=', 1);
        }])->where('parent_id',0);

        // $ad_types = AdType::with([ 'ads' => function($query)  {
        //     $query->where('status', '=', 1);
        // }]);
    
        if($searchTerm){
            $ads->where('title', 'like', '%' . $searchTerm . '%');
        }

        if($orderAds) {
            //there is a sort term
            if($orderAds =='date_desc'){
                $orderByColomnName = "created_at";
                $orderByColomnValue = "desc";
            }
            else if($orderAds =='date_asc'){
                $orderByColomnName = "created_at";
                $orderByColomnValue = "asc";
            }
            else if($orderAds =='price_desc'){
                $orderByColomnName = "price";
                $orderByColomnValue = "desc";
            }
            else if($orderAds =='price_asc'){
                $orderByColomnName = "price";
                $orderByColomnValue = "asc";
            }
            $ads->orderBy($orderByColomnName, $orderByColomnValue);
        }else{
            $ads->orderBy('created_at', 'desc');
        } 
        
        if($category_slug || $location_slug){
            
            if($category_slug) {

                $category = Category::where('slug', $category_slug)->first(); //get category details
                $category_id = $category->id;          
                
                if($category->parent_id == 0){
                        //parent category
                        $sub_categories_ids = Category::where('parent_id', $category_id)->pluck('id');

                        $locations->with(['childrenads' => function($query) use ($sub_categories_ids) {
                            $query->wherein('category_id',$sub_categories_ids)
                            ->where('ads.status', '=', 1);
                        } ,'children.ads' => function ($query) use($sub_categories_ids){
                            $query->wherein('category_id',$sub_categories_ids)
                            ->where('ads.status', '=', 1);
                        }]);

                        $ads->wherein('category_id',$sub_categories_ids);
                }else{
                        //sub category
                        $subCategorySet = true;
                        $category_parent = Category::where('id',$category->parent_id)->first();
                        $category_parent_slug = $category_parent->slug;
                        $categoryParentName = $category_parent->name;

                        if($ad_type_id){
                            $ads->where('ad_type_id', '=', $ad_type_id );
                        }
                
                        if($min_price){
                            $ads->where('price','>=',$min_price);
                        }
                        if($max_price){
                            $ads->where('price','<=',$max_price);
                        }

                        $categories->with(['childrenads' => function($query) use ($ad_type_id,$min_price,$max_price){
                            $query->where('ads.status', '=', 1);
                            if($ad_type_id){
                                $query->where('ad_type_id',$ad_type_id);
                            }
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }
                        } ,'children.ads' => function($query) use ($ad_type_id,$min_price, $max_price){
                            $query->where('ads.status', '=', 1);
                            if($ad_type_id){
                                $query->where('ad_type_id',$ad_type_id);
                            }
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }
                        }])->where('parent_id',0);
                        
                        $locations->with(['childrenads' => function($query) use ($category_id,$ad_type_id,$min_price,$max_price) {
                            $query->where('category_id',$category_id)
                            ->where('ads.status', '=', 1);
                            if($ad_type_id){
                                $query->where('ad_type_id',$ad_type_id);
                            }
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }
                        } ,'children.ads' => function ($query) use($category_id,$ad_type_id,$min_price,$max_price){
                            $query->where('category_id',$category_id)
                            ->where('ads.status', '=', 1);
                            if($ad_type_id){
                                $query->where('ad_type_id',$ad_type_id);
                            }
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }
                        }]);

                        $ad_types = AdType::with(['ads' => function($query) use ($category_id,$min_price,$max_price) {
                            $query->where('category_id',$category_id)
                            ->where('ads.status', '=', 1);  
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }                                           
                        }]);

                        /*$ad_brands = Brand::whereHas('electronics_ads', function($query){
                            return $query->whereHas('ads', function($q2) {
                                $q2->where('status', 1);
                            });
                        });*/

                        $ads->where('category_id',$category_id);
                }            
            }

            if($location_slug){

                $location = Location::where('slug', $location_slug)->first(); //get location details
                $location_id = $location->id;

                if($location->parent_id == 0){
                    //location
                    $sub_locations_ids = Location::where('parent_id', $location_id)->pluck('id');                  

                    $categories->with(['childrenads' => function($query) use ($sub_locations_ids,$ad_type_id,$min_price,$max_price) {
                        $query->wherein('location_id',$sub_locations_ids)
                        ->where('ads.status', '=', 1);
                        if($ad_type_id){
                            $query->where('ad_type_id',$ad_type_id);
                        }
                        if($min_price){
                            $query->where('price','>=',$min_price);
                        }
                        if($max_price){
                            $query->where('price','<=',$max_price);
                        }
                    } ,'children.ads' => function ($query) use($sub_locations_ids,$ad_type_id,$min_price,$max_price){
                        $query->wherein('location_id',$sub_locations_ids)
                        ->where('ads.status', '=', 1);
                        if($ad_type_id){
                            $query->where('ad_type_id',$ad_type_id);
                        }
                        if($min_price){
                            $query->where('price','>=',$min_price);
                        }
                        if($max_price){
                            $query->where('price','<=',$max_price);
                        }
                    }]);
                    
                    /*-- AD TYPE --*/
                    if($subCategorySet){
                        $ad_types->with(['ads' => function($query) use ($sub_locations_ids,$category_id,$min_price,$max_price) {
                            $query->wherein('location_id',$sub_locations_ids);
                            if($category_id){
                                $query->where('category_id', '=', $category_id);
                            }
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }
                            $query->where('ads.status', '=', 1);
                        }]); 
                    }                   

                    $ads->wherein('location_id',$sub_locations_ids);
                }else{
                    //sub location
                    $location_parent = Location::where('id',$location->parent_id)->first();
                    $location_parent_slug = $location_parent->slug;
                    $locationParentName = $location_parent->name;

                    $categories->with(['childrenads' => function($query) use ($location_id,$ad_type_id,$min_price,$max_price) {
                        $query->where('location_id',$location_id)
                        ->where('ads.status', '=', 1);
                        if($ad_type_id){
                            $query->where('ad_type_id',$ad_type_id);
                        }
                        if($min_price){
                            $query->where('price','>=',$min_price);
                        }
                        if($max_price){
                            $query->where('price','<=',$max_price);
                        }
                    } ,'children.ads' => function ($query) use($location_id,$ad_type_id,$min_price,$max_price){
                        $query->where('location_id',$location_id)
                        ->where('ads.status', '=', 1);
                        if($ad_type_id){
                            $query->where('ad_type_id',$ad_type_id);
                        }
                        if($min_price){
                            $query->where('price','>=',$min_price);
                        }
                        if($max_price){
                            $query->where('price','<=',$max_price);
                        }
                    }]);

                    /*-- AD TYPE --*/
                    if($subCategorySet){
                        $ad_types->with(['ads' => function($query) use ($location_id,$category_id,$min_price,$max_price) {
                            $query->where('location_id',$location_id);
                            if($category_id){
                                $query->where('category_id', '=', $category_id);
                            }
                            if($min_price){
                                $query->where('price','>=',$min_price);
                            }
                            if($max_price){
                                $query->where('price','<=',$max_price);
                            }
                            $query->where('ads.status', '=', 1);
                        }]);
                    }
                    
                    $ads->where('location_id',$location_id);
                }            
            }   
            
            if($subCategorySet){
                $ad_types = $ad_types->get();
            }
        }
        
        $ads = $ads->paginate(20);
        $categories = $categories->get();
        $locations = $locations->get();
       
        
        return view('ads.index', compact('ads','locations','categories','orderAds','category_slug','category_parent_slug','location_slug','location_parent_slug','ad_types','ad_type_id'));
    
    }

    /**
     *
     * Display the data ordered by a given value.
     * 
    **/
    public function orderData($orderByValue){
        
        $locations = Location::where('parent_id',0)->get();
        $categories = Category::where('parent_id',0)->get();

        if($orderByValue =='date_desc'){
            $ads = Ad::where('status',1)->orderBy('created_at', 'desc')->paginate(20);
            return view('ads.index', compact('ads','locations','categories','orderByValue'));
        }
        else if($orderByValue =='date_asc'){
            $ads = Ad::where('status',1)->orderBy('created_at', 'asc')->paginate(20);
            return view('ads.index', compact('ads','locations','categories','orderByValue'));
        }
        else if($orderByValue =='price_desc'){
            $ads = Ad::where('status',1)->orderBy('price', 'desc')->paginate(20);
            return view('ads.index', compact('ads','locations','categories','orderByValue'));
        }
        else if($orderByValue =='price_asc'){
            $ads = Ad::where('status',1)->orderBy('price', 'asc')->paginate(20);
            return view('ads.index', compact('ads','locations','categories','orderByValue'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        return view('ads.create');
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileNamesToStore = array();

        //validation
        $validate_these = [
            'title' => 'required',
            'description' => 'required',
            'brand' => 'sometimes|required',
            'model' => 'sometimes|required',
            'type' => 'sometimes|required',
            'modelYear' => 'sometimes|required|digits:4',
            'mileage' => 'sometimes|required',
            'transmission' => 'sometimes|required',
            'engineCapacity' => 'sometimes|required',
            'landSize' => 'sometimes|required',
            'bedrooms' => 'sometimes|required',
            'bathrooms' => 'sometimes|required',
            //'size' => 'sometimes|required'
        ];
    
        if($request->input('ad_type') != 'to-buy' && $request->input('ad_type') != 'to-rent'){
            $validate_these['file_upload'] = 'required|array|min:1';
            $validate_these['file_upload.*'] = 'required|min:1';
        }

        if($request->input('parent_category') == 'services'){
            $validate_these['price'] = 'nullable';
        }else{
            $validate_these['price'] = 'sometimes|required';
        }

        if($request->input('category') == 'shoes-footwear'){
            $validate_these['size'] = 'nullable';
        }else{
            $validate_these['size'] = 'sometimes|required';
        }
    
        $this->validate($request, $validate_these);

        //Handle file uploads (five uploads)
        if($request->hasFile('file_upload'))
        {
            foreach($request->file('file_upload') as $file_upload){

                // Get File name with the extension
                $filenameWithExt = $file_upload->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file_upload->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'-'.time().'.'.$extension;
                $path =  public_path().'/ad-photos/';
                // Upload Image
                $file_upload->move($path, $fileNameToStore);
                //Store the names of the files in an array
                $fileNamesToStore[] = $fileNameToStore;
            }
        }

        //Check whether ad price is negoatiable
        if(isset($request->negotiable)){ $nego = "1"; }
        else { $nego = "0"; }

        // Create Ad
        $ad = new Ad();
        $ad->title = $request->input('title');
        $ad->category_id = $request->input('category_id');
        $ad->location_id = $request->input('location_id');
        $ad->description = $request->input('description');
        $ad->price = $request->input('price');
        $ad->ad_type_id = $request->input('ad_type_id');
        $ad->negotiable = $nego;
        $ad->customer_id = auth()->user()->id;
        $ad->save();

        //Create Ad Photos
        if($request->hasFile('file_upload')){
            foreach($fileNamesToStore as $fileNameToStoreinDb){
                $adPhoto = new AdPhoto();
                $adPhoto->title = $fileNameToStoreinDb;
                //Save one to many relationship
                $ad->ad_photos()->save($adPhoto); 
            }
        }
        else{
            $fileNameToStoreinDb = 'default-placeholder-300x300.png';
            $adPhoto = new AdPhoto();
            $adPhoto->title = $fileNameToStoreinDb;
            //Save one to many relationship
            $ad->ad_photos()->save($adPhoto); 
        }

        /*Get the phone numbers entered. If they already exist in the user_phones table get the ids and insert them to 
        ad_user_phone table. If not first insert them to the user_phones table and then get their id's and insert them to 
        ad_user_phone table*/

        foreach($request->input('phone_number') as $phone_number){
            
            $userPhone = new UserPhone();
            
            //if number doesn't exist in user_phones
            if($userPhone->checkPhoneAvailability( (Auth::user()->id) , $phone_number)){
                //insert record to user_phones
                $userPhone->customer_id = auth()->user()->id;
                $userPhone->mobile_number = $phone_number;
                $userPhone->save();
            }

            //get the id of the corresponding phone number from user_phones
            $phone_id = $userPhone->getIdByPhoneNumber($phone_number);
            //insert it into the many to many table
            $ad->user_phones()->attach($phone_id);
        }

        if( ($request->input('parent_category')) == 'electronics'){

            // Create Electronics Ad
            $electronicsAd = new ElectronicsAd();
            $electronicsAd->condition = $request->input('condition');
            $electronicsAd->brand = $request->input('brand');
            $electronicsAd->model = $request->input('model');
            $electronicsAd->authenticity = $request->input('authenticity');
            $electronicsAd->type = $request->input('type');
            //Save one to one relationship
            $ad->electronics_ads()->save($electronicsAd); 

            //Create Ad Features
            if(isset($request->features)){
                $ad_features = $request->input('features');
                foreach($ad_features as $ad_feature){
                    $adFeature = new AdFeature();
                    $adFeature->title = $ad_feature;
                    //Save one to many relationship
                    $ad->ad_features()->save($adFeature); 
                }
            }
        }

        elseif( ($request->input('parent_category')) == 'cars-vehicles'){

            // Create Vehicles Ad
            $vehiclesAd = new VehiclesAd();
            $vehiclesAd->condition = $request->input('condition');
            $vehiclesAd->brand = $request->input('brand');
            $vehiclesAd->model = $request->input('model');
            $vehiclesAd->model_year = $request->input('modelYear');
            $vehiclesAd->mileage = $request->input('mileage');
            $vehiclesAd->type = $request->input('type');
            $vehiclesAd->transmission = $request->input('transmission');
            $vehiclesAd->fuel_type = $request->input('fuelType');
            $vehiclesAd->engine_capacity = $request->input('engineCapacity');
            
            //Save one to one relationship
            $ad->vehicles_ads()->save($vehiclesAd);
        
        }

        elseif( ($request->input('parent_category')) == 'property'){

            // Create Properties Ad
            $propertiesAd = new PropertiesAd();
            $propertiesAd->type = $request->input('type');
            $propertiesAd->land_size = $request->input('landSize');
            $propertiesAd->land_unit = $request->input('landUnit');
            $propertiesAd->address = $request->input('address');
            $propertiesAd->price_unit = $request->input('priceUnit');
            $propertiesAd->bedrooms = $request->input('bedrooms');
            $propertiesAd->bathrooms = $request->input('bathrooms');
            $propertiesAd->size = $request->input('size');
            
            //Save one to one relationship
            $ad->properties_ads()->save($propertiesAd);

        }
        
        elseif( ($request->input('parent_category')) == 'home-garden'){
            
            // Create Home & Garden Ad
            $homeGardenAd = new HomeGardenAd();
            $homeGardenAd->type = $request->input('type');
            $homeGardenAd->condition = $request->input('condition');
            
            //Save one to one relationship
            $ad->home_garden_ads()->save($homeGardenAd);

        }

        elseif( ($request->input('parent_category')) == 'fashion-health-beauty'){
            
            // Create Fashion, Health & Beauty Ad
            $healthbeautyAd = new HealthBeautyAd();
            $healthbeautyAd->type = $request->input('type');
            $healthbeautyAd->condition = $request->input('condition');
            $healthbeautyAd->gender = $request->input('gender');
            $healthbeautyAd->size = $request->input('size');
            $healthbeautyAd->authenticity = $request->input('authenticity');
            
            //Save one to one relationship
            $ad->health_beauty_ads()->save($healthbeautyAd);

        }    

        elseif( ($request->input('parent_category')) == 'hobby-sport-kids'){
            
            // Create Music, Kids & Sports
            $sportKidsAd = new SportKidsAd();
            $sportKidsAd->type = $request->input('type');
            $sportKidsAd->condition = $request->input('condition');
            $sportKidsAd->gender = $request->input('gender');
            
            //Save one to one relationship
            $ad->sport_kids_ads()->save($sportKidsAd);

        }
        
        elseif( ($request->input('parent_category')) == 'business-industry'){
            
            // Create Business Industry Ad
            $businessIndustryAd = new BusinessIndustryAd();
            $businessIndustryAd->type = $request->input('type');
            $businessIndustryAd->condition = $request->input('condition');
            
            //Save one to one relationship
            $ad->sport_kids_ads()->save($businessIndustryAd);

        }

        elseif( ($request->input('parent_category')) == 'services'){
            
            // Create Services Ad
            $servicesAd = new ServicesAd();
            $servicesAd->type = $request->input('type');
            
            //Save one to one relationship
            $ad->services_ads()->save($servicesAd);

        }

        elseif( ($request->input('parent_category')) == 'education'){
            
            // Create Education Ad
            $educationAd = new EducationAd();
            $educationAd->condition = $request->input('condition');
            $educationAd->type = $request->input('type');
            
            //Save one to one relationship
            $ad->education_ads()->save($educationAd);

        }

        elseif( ($request->input('parent_category')) == 'animals'){
            
            // Create Animals Ad
            $animalsAd = new AnimalsAd();
            $animalsAd->condition = $request->input('condition');
            $animalsAd->type = $request->input('type');
            
            //Save one to one relationship
            $ad->animals_ads()->save($animalsAd);

        }

        elseif( ($request->input('parent_category')) == 'food-agriculture'){
            
            // Create Animals Ad
            $foodAd = new FoodAd();
            //$foodAd->condition = $request->input('condition');
            $foodAd->type = $request->input('type');
            
            //Save one to one relationship
            $ad->food_ads()->save($foodAd);

        }

        elseif( ($request->input('parent_category')) == 'other'){
            
            // Create Other Ad
            $otherAd = new OtherAd();
            $otherAd->condition = $request->input('condition');
            
            //Save one to one relationship
            $ad->other_ads()->save($otherAd);

        }

        return redirect('/dashboard')->with('success', 'Your Ad was created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ad::find($id);
        return view('ads.show')->with('ad', $ad);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Ad::find($id);
        $adCategory = Category::where('id',$ad->category_id)->first();
        $adCategoryParent = Category::where('id',$adCategory->parent_id)->first();
        $adLocation = Location::where('id',$ad->location_id)->first();
        $adLocationParent = Location::where('id',$adLocation->parent_id)->first();

        return view('ads.edit', compact('ad','adCategory','adCategoryParent','adLocation','adLocationParent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileNamesToStore = array();
        
        //validation
        $validate_these = [
            'title' => 'required',
            'description' => 'required',
            'brand' => 'sometimes|required',
            'model' => 'sometimes|required',
            'type' => 'sometimes|required',
            'modelYear' => 'sometimes|required|digits:4',
            'mileage' => 'sometimes|required',
            'transmission' => 'sometimes|required',
            'engineCapacity' => 'sometimes|required',
            'landSize' => 'sometimes|required',
            'bedrooms' => 'sometimes|required',
            'bathrooms' => 'sometimes|required',
            //'size' => 'sometimes|required'
        ];    

        if($request->input('ad_type') != 'to-buy' && $request->input('ad_type') != 'to-rent'){
            if(count($request->input('file_upload')) <= 0){
                $validate_these['file_upload'] = 'required|array|min:1';
                $validate_these['file_upload.*'] = 'required|min:1';
            }
        }

        if($request->input('parent_category') == 'services'){
            $validate_these['price'] = 'nullable';
        }else{
            $validate_these['price'] = 'sometimes|required';
        }

        if($request->input('category') == 'shoes-footwear'){
            $validate_these['size'] = 'nullable';
        }else{
            $validate_these['size'] = 'sometimes|required';
        }
    
        $this->validate($request, $validate_these);

        //Handle file uploads
        if($request->hasFile('file_upload'))
        {
            foreach($request->file('file_upload') as $file_upload){
                
                // Get File name with the extension
                $filenameWithExt = $file_upload->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file_upload->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'-'.time().'.'.$extension;
                $path =  public_path().'/ad-photos/';
                // Upload Image
                $file_upload->move($path, $fileNameToStore);
                //Store the names of the files in an array
                $fileNamesToStore[] = $fileNameToStore;
            }
        }

        //Check whether ad price is negotiable
        if(isset($request->negotiable)){ $nego = "1"; }
        else { $nego = "0"; }

        // Update Ad
        $ad = Ad::find($id);
        $ad->title = $request->input('title');
        $ad->description = $request->input('description');
        $ad->price = $request->input('price');
        $ad->negotiable = $nego;
        $ad->save();

        /* 
            Update ad image details in table 
        */

        if($request->input('ad_type') != 'to-buy' && $request->input('ad_type') != 'to-rent'){
            
            //check whether any image has been deleted when editing the ad
            $ad_image_ids = AdPhoto::where('ad_id', $id)->pluck('id');
            $edit_ad_image_ids = $request->input('file_upload');

            foreach ($ad_image_ids as $ad_image_id) {
                if (!in_array($ad_image_id , $edit_ad_image_ids)) {
                    $imageName = AdPhoto::where('id', $ad_image_id)->pluck('title');
                    // Delete phot from folder
                    Storage::delete('ad-photos/'.$imageName);
                    // Delete record from db
                    AdPhoto::where('id', $ad_image_id)->delete();
                }
            }    

            //If new photos are uploaded 
            if($request->hasFile('file_upload')){
                foreach($fileNamesToStore as $fileNameToStoreinDb){                
                    $ad = Ad::find($id);
                    $adPhoto = new AdPhoto;
                    $adPhoto->title = $fileNameToStoreinDb;
                    $ad->ad_photos()->save($adPhoto);
                }
            }
        }

        /*Get the phone numbers entered. If they already exist in the user_phones table get the ids and insert them to 
        ad_user_phone table. If not first insert them to the user_phones table and then get their id's and insert them to 
        ad_user_phone table*/

        if(count($request->input('e_phone_number')) > 0){
            
            //delete the current ad_user_phone values related to this ad
            $ad->find($id)->user_phones()->detach();

            foreach($request->input('e_phone_number') as $phone_number){

                $userPhone = new UserPhone();            
                //if number doesn't exist in user_phones
                if($userPhone->checkPhoneAvailability( (Auth::user()->id) , $phone_number)){
                    //insert record to user_phones
                    $userPhone->customer_id = auth()->user()->id;
                    $userPhone->mobile_number = $phone_number;
                    $userPhone->save();
                }
                //get the id of the corresponding phone number from user_phones
                $phone_id = $userPhone->getIdByPhoneNumber($phone_number);
                //insert it into the many to many table again
                $ad->user_phones()->attach($phone_id);

            }
        }

        if( ($request->input('parent_category')) == 'electronics'){
            
            $ad = Ad::find($id);
            $ad->electronics_ads->condition = $request->input('condition');            
            $ad->electronics_ads->brand = $request->input('brand');
            $ad->electronics_ads->model = $request->input('model');
            $ad->electronics_ads->authenticity = $request->input('authenticity');
            $ad->electronics_ads->type = $request->input('type');
            $ad->electronics_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'cars-vehicles'){

            $ad = Ad::find($id);
            $ad->vehicles_ads->condition = $request->input('condition');
            $ad->vehicles_ads->brand = $request->input('brand');
            $ad->vehicles_ads->model = $request->input('model');
            $ad->vehicles_ads->model_year = $request->input('modelYear');
            $ad->vehicles_ads->mileage = $request->input('mileage');
            $ad->vehicles_ads->type = $request->input('type');
            $ad->vehicles_ads->transmission = $request->input('transmission');
            $ad->vehicles_ads->fuel_type = $request->input('fuelType');
            $ad->vehicles_ads->engine_capacity = $request->input('engineCapacity');
            $ad->vehicles_ads->save();        
        }

        elseif( ($request->input('parent_category')) == 'property'){

            $ad = Ad::find($id);
            $ad->properties_ads->type = $request->input('type');
            $ad->properties_ads->land_size = $request->input('landSize');
            $ad->properties_ads->land_unit = $request->input('landUnit');
            $ad->properties_ads->address = $request->input('address');
            $ad->properties_ads->price_unit = $request->input('priceUnit');
            $ad->properties_ads->bedrooms = $request->input('bedrooms');
            $ad->properties_ads->bathrooms = $request->input('bathrooms');
            $ad->properties_ads->size = $request->input('size');
            $ad->properties_ads->save(); 

        }
        
        elseif( ($request->input('parent_category')) == 'home-garden'){
            
            $ad = Ad::find($id);
            $ad->home_garden_ads->type = $request->input('type');
            $ad->home_garden_ads->condition = $request->input('condition');
            $ad->home_garden_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'fashion-health-beauty'){
            
            $ad = Ad::find($id);
            $ad->health_beauty_ads->type = $request->input('type');
            $ad->health_beauty_ads->condition = $request->input('condition');
            $ad->health_beauty_ads->gender = $request->input('gender');
            $ad->health_beauty_ads->size = $request->input('size');
            $ad->health_beauty_ads->authenticity = $request->input('authenticity');
            $ad->health_beauty_ads->save();

        }    

        elseif( ($request->input('parent_category')) == 'hobby-sport-kids'){
            
            $ad = Ad::find($id);
            $ad->sport_kids_ads->type = $request->input('type');
            $ad->sport_kids_ads->condition = $request->input('condition');
            $ad->sport_kids_ads->gender = $request->input('gender');
            $ad->sport_kids_ads->save();
        }
        
        elseif( ($request->input('parent_category')) == 'business-industry'){
            
            $ad = Ad::find($id);
            $ad->business_industry_ads->type = $request->input('type');
            $ad->business_industry_ads->condition = $request->input('condition');
            $ad->business_industry_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'services'){
            
            $ad = Ad::find($id);
            $ad->services_ads->type = $request->input('type');
            $ad->services_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'education'){
            
            $ad = Ad::find($id);
            $ad->education_ads->condition = $request->input('condition');
            $ad->education_ads->type = $request->input('type');
            $ad->education_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'animals'){
            
            $ad = Ad::find($id);
            $ad->animals_ads->condition = $request->input('condition');
            $ad->animals_ads->type = $request->input('type');
            $ad->animals_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'food-agriculture'){
            
            $ad = Ad::find($id);
            $ad->food_ads->type = $request->input('type');
            $ad->food_ads->save();
        }

        elseif( ($request->input('parent_category')) == 'other'){
            
            $ad = Ad::find($id);
            $ad->other_ads->condition = $request->input('condition');
            $ad->other_ads->save();
        }

        return redirect('/dashboard')->with('success', 'Your Ad was Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Ad::find($id);
        $ad->delete();

        return redirect('/dashboard')->with('success', 'Your Ad was Deleted');

    }

    /**
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
    *
    *  * * * * * * * * * * * From Post ad button to Post ad form steps * * * * * * * * 
    *
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
    **/
    public function postAd(){
        return view('ads/post-ad');
    }

    public function type($ad_type, $type)
    {
        $categories = new Category;
        
        try {

            $allSubCategories = $categories->selectChildCatgoryByType($type); //the method definition is in the Category Model
            
        } catch (Exception $e) {
            
            //no parent category found
        }
        
        return view('ads/category', compact('ad_type','type','allSubCategories'));
    }

    public function cat($ad_type,$type, $cat_parent_id, $cat_slug)
    {
        $locations = new Location;
        $categories = new Category;
        
        try {

            $allSubLocations = $locations->getLocations();
            $getCatDetails = $categories->getSingleCategoryBySlug($cat_slug);
            $getCatParentDetails = $categories->getSingleCategoryParent($cat_parent_id);
            
        } catch (Exception $e) {
            
            //no parent category found
        }

        return view('ads/location', compact('ad_type','type', 'getCatDetails', 'getCatParentDetails', 'allSubLocations'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($ad_type, $type, $cat_parent_id, $cat_slug, $loc_parent_id, $loc_slug)
    {
        $ad_types = new AdType;
        $categories = new Category;
        $locations = new Location;
        $brands = new Brand;
        $features = new Feature;
        $phones = new UserPhone;
        $types = new Type;

        try {
            
            $getAdTypeDetails = $ad_types->getSingleAdTypeBySlug($ad_type);
            $getCatDetails = $categories->getSingleCategoryBySlug($cat_slug);
            $getCatParentDetails = $categories->getSingleCategoryParent($cat_parent_id);
            $getLocDetails = $locations->getSingleLocationBySlug($loc_slug);
            $getLocParentDetails = $locations->getSingleLocationParent($loc_parent_id);
            $getBrands = $brands->getBrands($cat_slug);
            $getTypes = $types->getTypes($cat_slug);
            $getBodyTypes = $types->getBodyTypes($cat_slug);
            $getTranmissions = $types->getTransmissions($cat_slug);
            
            $cat_id = $getCatDetails->id; //get cat id
            $getFeatures  = $features->getFeatures($cat_id);  //select features where cat_id is the given cat_id  

            $customer_id = Auth::user()->id; //get user id
            $getPhones  = $phones->getPhones(Auth::user()->id);  //select phone numbers where customer_id is the given customer_id
            
        } catch (Exception $e) {
            
            //no parent category found
        }

        return view('ads.create', compact('getAdTypeDetails','type', 'getCatDetails', 'getCatParentDetails', 'getLocDetails', 'getLocParentDetails', 'getBrands', 'getFeatures','getPhones', 'getTypes', 'getBodyTypes','getTranmissions'));
        //return view('ads.create');
    }

    /**
    * Check whether a phone number already exist in the DB via ajax form.
    * If there is a result echo 'ok' else echo 'no'
    *
    *
    */
    public function checkPhoneAvailabilityAjax(Request $request){
        if ($request->ajax()) {
            
            $phonenum =  UserPhone::where('mobile_number', '=', $request->get('phonenum'))->where('customer_id', '=', auth()->user()->id)->first();
            if ($phonenum !== null)
            {
                 echo 'OK';
            }
            else {
                echo 'NO';
            } 
        }

    }

    /**
     * Display the specified resource when slug is passed as parameter.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function showAdBySlug($slug){
        
        $ad = Ad::where('slug', $slug)->first(); //select ad where slug is = given slug
        //$adPhotos = AdPhoto::find($id); 
        //return view('ads.show')->with('ad', $ad);
        return view('ads.show', compact('ad','adPhotos'));
    }

    public function showAdsByCategorySlug($slug, Request $request){

        //common for all ads;
        $categories = Category::where('parent_id',0)->get();
        $locations = Location::where('parent_id',0)->get();
        $category = Category::where('slug', $slug)->first(); //get category details
        $ad_types = AdType::all();     
        
        $ads = null;
        $categoryName = null;
        $category_slug = null;
        $category_parent_slug = null;
        $category_id = null;
        $categoryParentName = null;
        $searchTerms = array();
        $orderAds = null;
        $orderByColomnName = "created_at";
        $orderByColomnValue = "desc";
        $conditions = array();
        $ad_conditions = null;
        $min_price = null; 
        $max_price = null;
        $ad_brands = null;
        $ad_condition = null;
        $sub_ad_table_name = null;
        $ad_brand_name = null;
        
        $conditions[] = ['status' , '=',  1];
        $conditions[] = ['category_id' , '=',  $category->id];

        if($category){
            if($category->parent_id == 0){
                // category
                $sub_categories_ids = Category::where('parent_id', $category->id)->pluck('id');
                $ads = Ad::where('status', 1)->whereIn('category_id',$sub_categories_ids)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                
                if ($request->get('searchTerm') != null) {
                    //there is a search term
                    $searchTerm = $request->get('searchTerm');
                    $ads = Ad::where('status', 1)->whereIn('category_id',$sub_categories_ids)->where('title','LIKE','%'.$searchTerm.'%')->paginate(20);
                }
                else{

                    if ($request->get('orderAds') != null) {
                        //there is a sort term
                        $orderAds = $request->get('orderAds');
                        if($orderAds =='date_desc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='date_asc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "asc";
                        }
                        else if($orderAds =='price_desc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='price_asc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "asc";
                        }
                    }
                    $ads = Ad::where('status', 1)->whereIn('category_id',$sub_categories_ids)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                }
                   
            }else{
                //sub category
                $category_parent = Category::where('id',$category->parent_id)->first();
                $category_parent_slug = $category_parent->slug;
                $categoryParentName = $category_parent->name;

                $ad_brands = Brand::where('category_id',$category->id)->get();
                
                //get the related table details
                if($category_parent_slug == 'electronics')
                {
                    $ad_conditions = ElectronicsAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'electronics_ads';
                }
                else if($category_parent_slug == 'cars-vehicles')
                {
                    $ad_conditions = VehiclesAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'vehicles_ads';
                }
                else if($category_parent_slug == 'property')
                {
                    $ad_conditions = null;
                    $sub_ad_table_name = 'property_ads';
                }
                else if($category_parent_slug == 'home-garden')
                {
                    $ad_conditions = HomeGardenAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'home_garden_ads';
                }
                else if($category_parent_slug == 'fashion-health-beauty')
                {   
                    $ad_conditions = HealthBeautyAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'health_beauty_ads'; 
                }
                else if($category_parent_slug == 'hobby-sport-kids')
                {   
                    $ad_conditions = SportKidsAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'sport_kids_ads'; 
                }
                else if($category_parent_slug == 'business-industry')
                {   
                    $ad_conditions = BusinessIndustryAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'business_industry_ads'; 
                }
                else if($category_parent_slug == 'services')
                {   
                    $ad_conditions = null;
                    $sub_ad_table_name = 'services_ads'; 
                }
                else if($category_parent_slug == 'education')
                {   
                    $ad_conditions = EducationAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'education_ads'; 
                }
                else if($category_parent_slug == 'animals')
                {   
                    $ad_conditions = AnimalsAd::select('condition')->distinct()->get();
                    $sub_ad_table_name = 'animals_ads'; 
                }
                
                $ads = Ad::where($conditions)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);                
                
                if (($request->get('searchTerm') != null) || ($request->get('searchCat') != null) || ($request->get('searchLoc') != null)) {
                    //there is a search term, search cat or search location
                    $searchTerm = $request->get('searchTerm');
                    $searchTerms[] = ['title','LIKE','%'.$searchTerm.'%'];

                    $ads = Ad::where($conditions)->where($searchTerms)->orderBy('created_at', 'desc')->paginate(20);
                }
                else{

                    if($request->get('orderAds') != null) {
                        //there is a sort term
                        $orderAds = $request->get('orderAds');
                        if($orderAds =='date_desc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='date_asc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "asc";
                        }
                        else if($orderAds =='price_desc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='price_asc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "asc";
                        }
                    }

                    if($request->get('ad_type') != null) {
                        //ad type selected
                        $ad_type_id = $request->get('ad_type');
                        $conditions[] = ['type_id', '=', $ad_type_id];
                    }

                    if(Schema::hasColumn($sub_ad_table_name, 'condition')) //check whether related table has condition column
                    {
                        if($request->get('ad_condition') != null){
                            //ad condition selected
                            $ad_condition = $request->get('ad_condition');
                            $ad_cond = $ad_condition;
                        }
                    }

                    if($request->get('price_min') || $request->get('price_max')){
                        if($request->get('price_min') != null) {
                            //there is a min price
                            $min_price = $request->get('price_min');
                        }else{
                            $min_price = '0';
                        } 
                        if($request->get('price_max') != null) {
                            //there is a max price
                            $max_price = $request->get('price_max');
                        }
                        else{
                            $max_price = '999999999999999999';
                        }
                    }

                    if(Schema::hasColumn($sub_ad_table_name, 'brand')){
                        if($request->get('ad_brand') != null){
                            $ad_brand_id = $request->get('ad_brand');
                            $ad_brand = Brand::where('id', $ad_brand_id)->first();
                            $ad_brand_name = $ad_brand->name;    
                        }
                    }

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
                    $ads = $query->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                    
                }
                
            }
            $categoryName = $category->name;
            $category_slug = $slug;
            $category_id =  $category->id;

            return view('ads.index', compact('ads','locations','categories','categoryName','categoryParentName','category_slug','category_parent_slug','category_id','orderAds','ad_types','ad_type_id','min_price','max_price','ad_conditions','ad_cond','ad_brands','ad_brand_id'));
        }else{
            return redirect(url('ads'));
        }
                    
    }

    public function showAdsByLocationSlug($slug, Request $request){
        $locations = Location::where('parent_id',0)->get();
        $categories = Category::where('parent_id',0)->get();

        $location = Location::where('slug', $slug)->first();
        $ads = null;
        $locationName = null;
        $locationParentName = null;
        $location_id = null;
        $location_slug = null;
        $location_parent_slug = null;
        $orderAds = null;
        $orderByColomnName = "created_at";
        $orderByColomnValue = "desc";

        if($location){
            if($location->parent_id == 0){
                //location
                $sub_locations_id = Location::where('parent_id',$location->id)->pluck('id');
                if($request->get('searchTerm') != null) {
                    //there is a search term
                    $searchTerm = $request->get('searchTerm');
                    $ads = Ad::where('status', 1)->whereIn('location_id', $sub_locations_id)->where('title','LIKE','%'.$searchTerm.'%')->paginate(20);
                }
                else{
                    if ($request->get('orderAds') != null) {
                        //there is a sort term
                        $orderAds = $request->get('orderAds');
                        if($orderAds =='date_desc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='date_asc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "asc";
                        }
                        else if($orderAds =='price_desc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='price_asc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "asc";
                        }
                    }

                    $ads = Ad::where('status', 1)->whereIn('location_id', $sub_locations_id)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                
                }
                
            }else{
                //sub location
                $location_parent = Location::where('id',$location->parent_id)->first();
                $location_parent_slug = $location_parent->slug;
                $locationParentName = $location_parent->name;

                if($request->get('searchTerm') != null){
                    //there is a search term
                    $searchTerm = $request->get('searchTerm');
                    $ads = Ad::where('status', 1)->where('location_id',$location->id)->where('title','LIKE','%'.$searchTerm.'%')->orderBy('created_at', 'desc')->paginate(20);
                }
                else{
                    if ($request->get('orderAds') != null) {
                        //there is a sort term
                        $orderAds = $request->get('orderAds');
                        if($orderAds =='date_desc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='date_asc'){
                            $orderByColomnName = "created_at";
                            $orderByColomnValue = "asc";
                        }
                        else if($orderAds =='price_desc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "desc";
                        }
                        else if($orderAds =='price_asc'){
                            $orderByColomnName = "price";
                            $orderByColomnValue = "asc";
                        }
                    }
    
                    $ads = Ad::where('status', 1)->where('location_id',$location->id)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);

                }
            }
            $locationName = $location->name;
            $location_slug = $slug;
            $location_id =  $location->id;
            return view('ads.index', compact('ads','locations','categories', 'locationName','locationParentName','location_slug','location_parent_slug','location_id','orderAds','ad_types','ad_type_id'));
        }else{
            return redirect(url('ads'));
        }
    }

    public function showAdsByLocationSlugAndCategorySlug($location_slug,$category_slug, Request $request){
        
        //common for all ads;
        $categories = Category::where('parent_id',0)->get();
        $locations = Location::where('parent_id',0)->get();
        $location = Location::where('slug', $location_slug)->first();
        $category = Category::where('slug',$category_slug)->first();
        $ad_brands = Brand::where('category_id',$category->id)->get();
        $ad_types = AdType::all();

        $category_parent_slug = null;
        $location_parent_slug = null;
        $categoryParentName = null;
        $locationParentName = null;
        $orderAds = null;
        $orderByColomnName = "created_at";
        $orderByColomnValue = "desc";
        $conditions = array();
        $ad_condition = null;
        $ad_conditions = null;
        $sub_ad_table_name = null;
        $ad_brand_name = null;

        $conditions[] = ['status' , '=',  1];
        $conditions[] = ['category_id' , '=',  $category->id];

        if($location && $category){
            if($location->parent_id == 0){
                //location
                $sub_location_ids = Location::where('parent_id', $location->id)->pluck('id');
                if($category->parent_id == 0){
                    //$category
                    $sub_categories_ids = Category::where('parent_id', $category->id)->pluck('id');
                    if($request->get('searchTerm') != null) {
                        //there is a search term
                        $searchTerm = $request->get('searchTerm');
                        $ads = Ad::where('status', 1)->whereIn('location_id', $sub_location_ids)->whereIn('category_id',$sub_categories_ids)->where('title','LIKE','%'.$searchTerm.'%')->orderBy('created_at', 'desc')->paginate(20);
                    }
                    else{
                        if($request->get('orderAds') != null) {
                            //there is a sort term
                            $orderAds = $request->get('orderAds');
                            if($orderAds =='date_desc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='date_asc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "asc";
                            }
                            else if($orderAds =='price_desc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='price_asc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "asc";
                            }
                        }
        
                        $ads = Ad::where('status', 1)->whereIn('location_id',$sub_location_ids)->whereIn('category_id',$sub_categories_ids)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                        //$ads = Ad::whereIn('location_id',$sub_location_ids)->whereIn('category_id',$sub_categories_ids)->orderBy('created_at', 'desc')->paginate(20);
                    }
                    
                }else{
                    //sub category
                    $category_parent = Category::where('id',$category->parent_id)->first();
                    $category_parent_slug = $category_parent->slug;
                    $categoryParentName = $category_parent->name;

                    //get the related table details
                    if($category_parent_slug == 'electronics')
                    {
                        $ad_conditions = ElectronicsAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'electronics_ads';
                    }
                    else if($category_parent_slug == 'cars-vehicles')
                    {
                        $ad_conditions = VehiclesAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'vehicles_ads';
                    }
                    else if($category_parent_slug == 'property')
                    {
                        $ad_conditions = null;
                        $sub_ad_table_name = 'property_ads';
                    }
                    else if($category_parent_slug == 'home-garden')
                    {
                        $ad_conditions = HomeGardenAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'home_garden_ads';
                    }
                    else if($category_parent_slug == 'fashion-health-beauty')
                    {   
                        $ad_conditions = HealthBeautyAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'health_beauty_ads'; 
                    }
                    else if($category_parent_slug == 'hobby-sport-kids')
                    {   
                        $ad_conditions = SportKidsAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'sport_kids_ads'; 
                    }
                    else if($category_parent_slug == 'business-industry')
                    {   
                        $ad_conditions = BusinessIndustryAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'business_industry_ads'; 
                    }
                    else if($category_parent_slug == 'services')
                    {   
                        $ad_conditions = BusinessIndustryAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'services_ads'; 
                    }
                    
                    $ads = Ad::whereIn('location_id',$sub_location_ids)->where($conditions)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);

                    if($request->get('searchTerm') != null) {
                        //there is a search term
                        $searchTerm = $request->get('searchTerm');
                        $ads = Ad::whereIn('location_id', $sub_location_ids)->where($conditions)->where('title','LIKE','%'.$searchTerm.'%')->orderBy('created_at', 'desc')->paginate(20);
                    }
                    else{
                        
                        if($request->get('orderAds') != null) {
                            //there is a sort term
                            $orderAds = $request->get('orderAds');
                            if($orderAds =='date_desc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='date_asc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "asc";
                            }
                            else if($orderAds =='price_desc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='price_asc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "asc";
                            }
                        }

                        if($request->get('ad_type') != null) {
                            //ad type selected
                            $ad_type_id = $request->get('ad_type');
                            $conditions[] = ['type_id', '=', $ad_type_id];
                        }

                        if(Schema::hasColumn($sub_ad_table_name, 'condition')) //check whether related table has condition column
                        {
                            if($request->get('ad_condition') != null){
                                //ad condition selected
                                $ad_condition = $request->get('ad_condition');
                                $ad_cond = $ad_condition;
                            }
                        }

                        if($request->get('price_min') || $request->get('price_max')){
                            if($request->get('price_min') != null) {
                                //there is a min price
                                $min_price = $request->get('price_min');
                            }else{
                                $min_price = '0';
                            } 
                            if($request->get('price_max') != null) {
                                //there is a max price
                                $max_price = $request->get('price_max');
                            }
                            else{
                                $max_price = '999999999999999999';
                            }
                        }
                        else{
                            $min_price = '0'; 
                            $max_price = '999999999999999999';
                        }
                        
                        if(Schema::hasColumn($sub_ad_table_name, 'brand')){
                            if($request->get('ad_brand') != null){
                                $ad_brand_id = $request->get('ad_brand');
                                $ad_brand = Brand::where('id', $ad_brand_id)->first();
                                $ad_brand_name = $ad_brand->name;    
                            }
                        }

                        $query = Ad::whereIn('location_id',$sub_location_ids)
                        ->where($conditions)
                        ->whereBetween('price', [$min_price, $max_price]);
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
                        $ads = $query->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                    }
                }
            }else{
                //sub location
                $location_parent = Location::where('id',$location->parent_id)->first();
                $location_parent_slug = $location_parent->slug;
                $locationParentName = $location_parent->name;
                
                if($category->parent_id == 0){
                    //$category
                    $sub_categories_ids = Category::where('parent_id', $category->id)->pluck('id');
                    if($request->get('searchTerm') != null) {
                        //there is a search term
                        $searchTerm = $request->get('searchTerm');
                        $ads = Ad::where('status', 1)->where('location_id',$location->id)->whereIn('category_id',$sub_categories_ids)->where('title','LIKE','%'.$searchTerm.'%')->orderBy('created_at', 'desc')->paginate(20);
                    }
                    else{
                        
                        if($request->get('orderAds') != null) {
                            //there is a sort term
                            $orderAds = $request->get('orderAds');
                            if($orderAds =='date_desc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='date_asc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "asc";
                            }
                            else if($orderAds =='price_desc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='price_asc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "asc";
                            }
                        }

                        $ads = Ad::where('status', 1)->where('location_id',$location->id)->whereIn('category_id',$sub_categories_ids)->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                    }
                    
                }else{
                    //sub category
                    $category_parent = Category::where('id',$category->parent_id)->first();
                    $category_parent_slug = $category_parent->slug;
                    $categoryParentName = $category_parent->name;

                    //get the related table details
                    if($category_parent_slug == 'electronics')
                    {
                        $ad_conditions = ElectronicsAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'electronics_ads';
                    }
                    else if($category_parent_slug == 'cars-vehicles')
                    {
                        $ad_conditions = VehiclesAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'vehicles_ads';
                    }
                    else if($category_parent_slug == 'property')
                    {
                        $ad_conditions = null;
                        $sub_ad_table_name = 'property_ads';
                    }
                    else if($category_parent_slug == 'home-garden')
                    {
                        $ad_conditions = HomeGardenAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'home_garden_ads';
                    }
                    else if($category_parent_slug == 'fashion-health-beauty')
                    {   
                        $ad_conditions = HealthBeautyAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'health_beauty_ads'; 
                    }
                    else if($category_parent_slug == 'hobby-sport-kids')
                    {   
                        $ad_conditions = SportKidsAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'sport_kids_ads'; 
                    }
                    else if($category_parent_slug == 'business-industry')
                    {   
                        $ad_conditions = BusinessIndustryAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'business_industry_ads'; 
                    }
                    else if($category_parent_slug == 'services')
                    {   
                        $ad_conditions = null;
                        $sub_ad_table_name = 'services_ads'; 
                    }
                    else if($category_parent_slug == 'education')
                    {   
                        $ad_conditions = EducationAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'education_ads'; 
                    }
                    else if($category_parent_slug == 'animals')
                    {   
                        $ad_conditions = AnimalsAd::select('condition')->distinct()->get();
                        $sub_ad_table_name = 'animals_ads'; 
                    }
                    else if($category_parent_slug == 'food-agriculture')
                    {   
                        $ad_conditions = null;
                        $sub_ad_table_name = 'food_ads'; 
                    }
                    else if($category_parent_slug == 'other')
                    {   
                        $ad_conditions = OtherAd::select('condition')->distinct()->get();;
                        $sub_ad_table_name = 'other_ads'; 
                    }
                    

                    if($request->get('searchTerm') != null) {
                        //there is a search term
                        $searchTerm = $request->get('searchTerm');
                        $ads = Ad::where('location_id',$location->id)->where($conditions)->where('title','LIKE','%'.$searchTerm.'%')->orderBy('created_at', 'desc')->paginate(20);
                    }
                    else{
                        
                        if($request->get('orderAds') != null) {
                            //there is a sort term
                            $orderAds = $request->get('orderAds');
                            if($orderAds =='date_desc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='date_asc'){
                                $orderByColomnName = "created_at";
                                $orderByColomnValue = "asc";
                            }
                            else if($orderAds =='price_desc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "desc";
                            }
                            else if($orderAds =='price_asc'){
                                $orderByColomnName = "price";
                                $orderByColomnValue = "asc";
                            }
                        }

                        if($request->get('ad_type') != null) {
                            $ad_type_id = $request->get('ad_type');
                            $conditions[] = ['type_id', '=', $ad_type_id];
                        }

                        if(Schema::hasColumn($sub_ad_table_name, 'condition')) //check whether related table has condition column
                        {
                            if($request->get('ad_condition') != null){
                                //ad condition selected
                                $ad_condition = $request->get('ad_condition');
                                $ad_cond = $ad_condition;
                            }
                        }

                        if($request->get('price_min') || $request->get('price_max')){
                            if($request->get('price_min') != null) {
                                //there is a min price
                                $min_price = $request->get('price_min');
                            }else{
                                $min_price = '0';
                            } 
                            if($request->get('price_max') != null) {
                                //there is a max price
                                $max_price = $request->get('price_max');
                            }
                            else{
                                $max_price = '999999999999999999';
                            }
                        }
                        else{
                            $min_price = '0'; 
                            $max_price = '999999999999999999';
                        }

                        if(Schema::hasColumn($sub_ad_table_name, 'brand')){
                            if($request->get('ad_brand') != null){
                                $ad_brand_id = $request->get('ad_brand');
                                $ad_brand = Brand::where('id', $ad_brand_id)->first();
                                $ad_brand_name = $ad_brand->name;    
                            }
                        }
                        
                        $query = Ad::where('location_id',$location->id)
                        ->where($conditions)
                        ->whereBetween('price', [$min_price, $max_price]);
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
                        $ads = $query->orderBy($orderByColomnName, $orderByColomnValue)->paginate(20);
                    }                 
                }
            }

            $category_id = $category->id;
            $location_id = $location->id;
            $categoryName = $category->name;
            $locationName = $location->name;
            return view('ads.index', compact('ads','locations','categories','categoryName','locationName','categoryParentName','locationParentName','category_slug','location_slug','category_parent_slug','location_parent_slug','category_id','location_id','orderAds','ad_types','ad_type_id','min_price','max_price','ad_conditions','ad_cond','ad_brands','ad_brand_id'));
        }else{
            return redirect(url('ads'));
        }

    }
}
