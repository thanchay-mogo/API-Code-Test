<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\coupon;
use App\couponshop;
use App\shop;
use Auth;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class CouponShopController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCouponByID($couponId){

    }

    public function index()
    {
      
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
            'coupon_id' => 'required|integer',
            'shop_id' => 'required|integer'
        ]);
           
        if($validator->fails()){
            $error = json_decode('{
            "message": "The request parameters are incorrect, please make sure to follow the documentation about request parameters of the resource.",
            "code": 400002
            }');

            return $this->sendError($error, $validator->errors(), 1,$duration);       
        }
        $coupon = Couponshop::create($input);
   
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $coupon , $shop)
    {
        var_dump($coupon);die;
        $coupon = Couponshop::find($id);
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
}
