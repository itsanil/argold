<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\City;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Vendor::all();
        return view('backend.vendor.view', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = City::all();
        return view('backend.vendor.add', compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Vendor::create($request->all());
        return redirect()->route('vendor.view')->with('success', 'Vendor Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($vendor)
    {
        $city = City::all();
        $vendor = Vendor::find($vendor);
        return view('backend.vendor.edit', compact('vendor','city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->all();
        unset($data['_token']);
        $vendor_data = Vendor::find($vendor);
        Vendor::where('id',$vendor_data->id)->update($data);
        return redirect()->route('vendor.view')->with('success', 'Vendor Updated Successfully');
        // echo "<pre>"; print_r($vendor); echo "</pre>"; 
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; 
        // die('anil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function delete($vendorPayment)
    {
        $vendorPayment = Vendor::find($vendorPayment);
        $vendorPayment->delete();
        // Redirect 
        return redirect()->back()->with('error', 'data Deleted Successfully');
    }
}
