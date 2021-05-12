<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\coupon;
use App\shop;
use Auth;
use DB;
use App\couponshop;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
//use App\Http\Resources\Product as ProductResource;

class CouponController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        $meta = "hi";
        $duration = microtime(true);
        return $this->sendResponse($coupons, $meta, $duration);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $duration = microtime(true); 
        $validator = Validator::make($input, [  
            'name' => 'required|max:128',
            'discount_type' => 'required|in:percentage,fix-amount' ,
            'amount' => 'required|integer',
            'code' => 'integer',
            'start_datetime' => 'date_format:Y-m-d H:i:s',
            'end_datetime' => 'date_format:Y-m-d H:i:s',
            'coupon_type' => 'required|in:private,public',
            'used_count' => 'integer'
        ]);
           
        if($validator->fails()){
            $error = json_decode('{
            "message": "queThe request parameters are incorrect, please make sure to follow the documentation about request parameters of the resource.",
            "code": 400002
            }');

            return $this->sendError($error, $validator->errors(), 1,$duration);       
        }
        $input['admin_id'] = Auth::id();
        $coupon = Coupon::create($input);
   
        return $this->sendResponse($coupon, 1, $duration);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = Coupon::find($id);
        $meta = "";
        $duration = microtime(true);
        if (is_null($coupon)) {
            $error = json_decode('{
                "message": "The resource that matches the request ID does not found.",
                "code": 404002
            }');
            return $this->sendError($error, [], $meta, $duration);
        }
        
        return $this->sendResponse($coupon, $meta, $duration);
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
        $input = $request->all();

        $coupon = Coupon::find($id);
        $duration = microtime(true);
        if (is_null($coupon)) {
            $error = json_decode('{
                "message": "The updating resource that corresponds to the ID wasnt found.",
                "code": 404003
            }');
            return $this->sendError($error, [], 1, $duration);
        }
        $validator = Validator::make($input, [  
            'name' => 'required|max:128',
            'discount_type' => 'required|in:percentage,fix-amount' ,
            'amount' => 'required|integer',
            'code' => 'integer',
            'start_datetime' => 'date_format:Y-m-d H:i:s',
            'end_datetime' => 'date_format:Y-m-d H:i:s',
            'coupon_type' => 'required|in:private,public',
            'used_count' => 'integer'
        ]);
   
        if($validator->fails()){
            $error = json_decode('{
                "message": "The updating resource that corresponds to the ID wasnt found.",
                "code": 400002
            }');
            return $this->sendError('Validation Error.', $validator->errors(), 1, $duration);       
        }

         $coupon->name = $input['name'];
         $coupon->discount_type = $input['discount_type'];
         $coupon->amount = $input['amount'];
         $coupon->start_datetime = $input['start_datetime'];
         $coupon->end_datetime = $input['end_datetime'];
         $coupon->coupon_type = $input['coupon_type'];
         $coupon->used_count = $input['used_count'];
         $coupon->save();
   
        return $this->sendResponse($coupon, 1, $duration);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $duration = microtime(true);
        if (is_null($coupon)) {
            $error = json_decode('{
                "message": "The deleting resource that corresponds to the ID wasnt found.",
                "code": 404004
            }');
            return $this->sendError($error, [], 1, $duration);
        }
        $coupon->delete();
   
        return $this->sendResponse($coupon, 1, $duration);
    }

    public function getCouponByID($couponId){
        $coupon = Coupon::find($couponId);
        $duration = microtime(true);
        if (is_null($coupon)) {
            $error = json_decode('{
                "message": "The deleting resource that corresponds to the ID wasnt found.",
                "code": 404004
            }');
            return $this->sendError($error, [], 1, $duration);
        }
        $shoplist = Couponshop::where("coupon_id", $couponId)->get()->pluck('shop_id')->toArray();
    
        $coupon['shop'] = Shop::whereIn('id', $shoplist)->get();

        return $this->sendResponse($coupon, 1, $duration);
        
    }

    public function getCouponByShop($couponId, $shopid){
       
        $duration = microtime(true);
        $couponlist = Couponshop::join("coupons","coupons.id","=","coupon_shops.coupon_id")
        ->join("shops","shops.id","=","coupon_shops.shop_id")
        ->where("coupon_shops.coupon_id", $couponId)->where("coupon_shops.shop_id", $shopid)->get()->count();
     
        if($couponlist >0) {
            $coupon = Coupon::find($couponId); 
            $coupon['shop'] = Shop::find($shopid);
            return $this->sendResponse($coupon, 1, $duration);
        }
        else{
            $error = json_decode('{
                "message": "The deleting resource that corresponds to the ID wasnt found.",
                "code": 404004
            }');
            return $this->sendError($error, [], 1, $duration);
        }

        
    }

    public function deleteCouponShop($couponid, $shopid){
        $duration = microtime(true);
        $couponlist = Couponshop::join("coupons","coupons.id","=","coupon_shops.coupon_id")
        ->join("shops","shops.id","=","coupon_shops.shop_id")
        ->where("coupon_shops.coupon_id", $couponid)->where("coupon_shops.shop_id", $shopid)->get()->count();
        
        if ($couponlist==0) {
            $error = json_decode('{
                "message": "The deleting resource that corresponds to the ID wasnt found.",
                "code": 404004
            }');
            return $this->sendError($error, [], 1, $duration);
        }
        $coupon = Coupon::find($couponid); 
        $shop= Shop::find($shopid);
        $shop->couponshop()->delete();
        $coupon->delete();
        $shop->delete();
        
        $su = json_decode('{
            "deleted" =>1
        }');
        return $this->sendResponse($su, 1, $duration);
    }
}
