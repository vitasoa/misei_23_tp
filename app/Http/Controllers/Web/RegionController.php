<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $regions = Region::orderBy('id','desc')->paginate(5);
        return view('regions.index', compact('regions'));
    }
	
	/**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('regions.create');
    }
	
	/**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        Region::create($request->post());

        return redirect()->route('regions.index')->with('success','Region has been created successfully.');
    }
	
	/**
    * Display the specified resource.
    *
    * @param  \App\Models\Region  $region
    * @return \Illuminate\Http\Response
    */
    public function show(Region $region)
    {
        return view('regions.show',compact('region'));
    }
	
	/**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Region  $region
    * @return \Illuminate\Http\Response
    */
    public function edit(Region $region)
    {
        return view('regions.edit',compact('region'));
    }
	
	/**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Region  $region
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        $region->fill($request->post())->save();
        return redirect()->route('regions.index')->with('success','Region Has Been updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Region  $region
    * @return \Illuminate\Http\Response
    */
    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('regions.index')->with('success','Region has been deleted successfully');
    }

}
