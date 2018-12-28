<?php

namespace App\Http\Controllers\Administrator;

use App\Ad;
use App\RejectedAd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function newAdsList(){
        $get_new_ads = Ad::where('status',0)->get();
        return view('administrator.ads.ads-new-list',compact('get_new_ads'));
    }

    public function publishedAdsList(){
        $get_published_ads = Ad::where('status',1)->get();
        return view('administrator.ads.ads-published-list',compact('get_published_ads'));
    }

    public function adView($id){
        $ad = Ad::find($id);
        return view('administrator.ads.ads-view')->with('ad', $ad);
    }

    public function adApprove($id){
        $ad = Ad::find($id);
        $ad->status = 1;
        $ad->save();
        return redirect(route('administrator.ads.view.get',[$id]))->with('success_messge',"Ad approved...");
        //return 123;
    }

    /*public function adReject($id){
        $ad = Ad::find($id);
        $ad->status = 2;
        $ad->save();
        return redirect(route('administrator.ads.view.get',[$id]))->with('success_messge',"Ad Rejected...");
    }*/

    public function adReject($id,Request $request){
        $ad = Ad::where('id',$id)->first();
        if(!$ad){
            return redirect(route('administrator.ads.new-list'));
        }
        //return 123;
        return view('administrator.ads.ad-reject',compact('ad'));
    }

    public function adRejectUpdate($id,Request $request){
        $reject_reason = $request->input('reject_reason');
        $validator = Validator::make($request->all(),[
            'name' => 'string|required',
            'reject_reason' => 'string|required'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.ads.reject.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }
        $ad = Ad::find($id);
        $ad->status = 2;
        $ad->save();
        
        // add details to reject table    
        $ad = Ad::find($id);
        $rejected_ads = new RejectedAd(); 
        $rejected_ads->reason = $reject_reason;
        $ad->rejected_ads()->save($rejected_ads);

        return redirect(route('administrator.ads.reject.get',[$id]))->with('success_messge',"Ad Rejected...");
    
    }
}
