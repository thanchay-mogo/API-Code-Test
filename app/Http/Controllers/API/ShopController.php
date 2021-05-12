<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\shop;
use Auth;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
//use App\Http\Resources\Product as ProductResource;

class ShopController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();
        $meta = "hi";
        $duration = microtime(true);
        return $this->sendResponse($shops, $meta, $duration);
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
        $validator = Validator::make($input, [
            'name' => 'required|max:64',
            'query' => 'required|max:64',
            'latitude' => 'required|integer',
            'longitude' => 'required|integer',
            'zoom' => 'required|integer'
        ]);
        $duration = microtime(true);    
        if($validator->fails()){
            $error = json_decode('{
            "message": "The request parameters are incorrect, please make sure to follow the documentation about request parameters of the resource.",
            "code": 400002
            }');

            return $this->sendError($error, $validator->errors(), 1,$duration);       
        }
        $input['admin_id'] = Auth::id();
        $shop = Shop::create($input);
   
        return $this->sendResponse($shop, 1, $duration);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shops = Shop::find($id);
        $meta = "";
        $duration = microtime(true);
        if (is_null($shops)) {
            $error = json_decode('{
                "message": "The updating resource that corresponds to the ID wasnt found.",
            "code": 404003
            }');
            return $this->sendError($error, $meta, $duration);
        }
        $meta = "";
        $duration = microtime(true);
        return $this->sendResponse($shops, $meta, $duration);

        return $this->sendResponse($shops, 'Product Retrieved Successfully.');
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

        $shops = Shop::find($id);
        $duration = microtime(true);
        if (is_null($shops)) {
            $error = json_decode('{
                "message": "The updating resource that corresponds to the ID wasnt found.",
                "code": 404003
            }');
            return $this->sendError($error, [], 1, $duration);
        }
        $validator = Validator::make($input, [
            'name' => 'required|max:64',
            'query' => 'required|max:64',
            'latitude' => 'required|integer',
            'longitude' => 'required|integer',
            'zoom' => 'required|integer'
        ]);
   
        if($validator->fails()){
            $error = json_decode('{
                "message": "The updating resource that corresponds to the ID wasnt found.",
                "code": 400002
            }');
            return $this->sendError('Validation Error.', $validator->errors());       
        }

         $shops->name = $input['name'];
         $shops->query = $input['query'];
         $shops->latitude = $input['latitude'];
         $shops->longitude = $input['longitude'];
         $shops->zoom = $input['zoom'];
        $shops->save();
   
        return $this->sendResponse($shops, 1, $duration);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);
        $duration = microtime(true);
        if (is_null($shop)) {
            $error = json_decode('{
                "message": "The deleting resource that corresponds to the ID wasnt found.",
                "code": 404004
            }');
            return $this->sendError($error, [], 1, $duration);
        }
        $shop->delete();
   
        return $this->sendResponse($shop, 1, $duration);
    }
}
