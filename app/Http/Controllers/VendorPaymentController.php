<?php

namespace App\Http\Controllers;

use App\Models\VendorPayment;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vendor_id)
    {
        $data = VendorPayment::where('vendor_id',$vendor_id)->orderBy('date','DESC')->get();
        return view('backend.vendor.payment',compact('data','vendor_id'));
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
        VendorPayment::create($request->all());
        return redirect()->back()->with('success', 'Vendor Added Successfully');
        echo "<pre>"; print_r($request->all()); echo "</pre>"; die('anil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function show(VendorPayment $vendorPayment)
    {
        $data = $request->all();
        unset($data['_token']);
        $vendor_data = VendorPayment::find($vendorPayment);
        VendorPayment::where('id',$vendor->id)->update($data);
        return redirect()->back()->with('success', 'Vendor Updated Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorPayment $vendorPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorPayment $vendorPayment)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);
        // echo "<pre>"; print_r($data); echo "</pre>"; die('anil');
        $vendor_data = VendorPayment::find($request->id);
        VendorPayment::where('id',$vendor_data->id)->update($data);
        return redirect()->back()->with('success', 'Vendor Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function delete($vendorPayment)
    {
        $vendorPayment = VendorPayment::find($vendorPayment);
        $vendorPayment->delete();
        // Redirect 
        return redirect()->back()->with('error', 'data Deleted Successfully');
    }
}
