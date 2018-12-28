<?php

namespace App\Http\Controllers\Administrator;

use App\Ad;
use App\Slug;
use App\Location;
use App\Category;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function checkLocationSlug(Request $request){

        $name = $request->get('name');
        $slug = $request->get('slug');
        return Location::checkLocationSlug($name,$slug);
        //return 123;
    }

    public function checkCategorySlug(Request $request){
        
        $name = $request->get('name');
        $slug = $request->get('slug');
        return Category::checkCategorySlug($name,$slug);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_ads = Ad::all();
        $published_ads = Ad::where('status', 0)->get();

        $customers = Customer::all();
        return view('administrator.index',compact('all_ads','published_ads','customers'));
        //return view('administrator.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
