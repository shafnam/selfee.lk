<?php

namespace App\Http\Controllers;
use App\Ad;
use App\Customer;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = auth()->user()->id;
        $published_ads = Ad::where('customer_id', $customer_id)->where('status', 1)->orderBy('created_at', 'desc')->get();
        $rejected_ads = Ad::where('customer_id', $customer_id)->where('status', 2)->orderBy('created_at', 'desc')->get();
        /*$customer = Customer::find($customer_id);
        return view('dashboard')->with('ads', $customer->ads);*/
        return view('dashboard', compact('published_ads','rejected_ads'));
    }

    public function mySettings()
    {   
        $customer_id = auth()->user()->id;
        $customer = Customer::find($customer_id);
        return view('users.settings', compact('customer'));
    }

}


/*namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use DataTables;
use App\Ad;

class DashboardController extends Controller
{    
    /**
     * Create a new controller instance.
     *
     * @return void
     *
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     *
    public function index()
    {
        return view('dashboard');
    }

    public function getAds()
    {
        //return \DataTables::of(Ad::query())->make(true);
        //$ads = Ad::select(['id', 'title', 'price','created_at', 'updated_at']);
        $customer_id = auth()->user()->id;
        $ads = Ad::where('customer_id',$customer_id)->where('status',0)->select(['id', 'title', 'price','created_at', 'updated_at']);
        
        return Datatables::of($ads)
        ->addColumn('action', function ($ad) {
            return '<a href="#edit-'.$ad->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        })
        ->editColumn('id', 'ID: {{$id}}')
        ->make(true);
    }
}*/
