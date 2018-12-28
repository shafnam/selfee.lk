<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    //Table Name
    protected $table = 'user_phones';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /**
     * Get the User that owns this Phone.
    */
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function getPhones($customer_id){
        
        $phones = \App\UserPhone::where('customer_id',$customer_id)->pluck('mobile_number');
        return $phones;

    }

    /* many to many relationship between userphones and ads */
    public function ads()
    {
        return $this->belongsToMany('App\Ad')->withTimestamps();
    }

    public function checkPhoneAvailability( $customer_id , $phone_number){
        
        $phonenum =  \App\UserPhone::where('mobile_number', '=', $phone_number)->where('customer_id', '=', $customer_id)->first();
        if ($phonenum !== null)
        {
                return false; //false there is a record
        }
        else {
            return true; //true there is no record
        } 
        

    }

    public function getIdByPhoneNumber($phone_number){

        $phone_id = \App\UserPhone::where('mobile_number',$phone_number)->pluck('id');
        return $phone_id;
    }
}
