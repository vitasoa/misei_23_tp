<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use App\Models\Region;
use App\Http\Resources\RegionResource;
use Illuminate\Http\Request;
use Validator;

class RegionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        return $this->sendResponse(RegionResource::collection($regions), 'Regions retrieved successfully.');
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
            'name' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $region = Region::create($input);
     
        return $this->sendResponse(new RegionResource($region), 'Region created successfully.');
    }
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $region = Region::find($id);
        if (is_null($region)) {
            return $this->sendError('Region not found.');
        }
        return $this->sendResponse(new RegionResource($region), 'Region retrieved successfully.');
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $region->name = $input['name'];
        $region->save();
     
        return $this->sendResponse(new RegionResource($region), 'Region updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return $this->sendResponse([], 'Region deleted successfully.');
    }
}
