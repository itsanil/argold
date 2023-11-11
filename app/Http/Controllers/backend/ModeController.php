<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mode;
use App\Models\Branch;
use Auth;

class ModeController extends Controller
{
    //---- Mode View ----//
    public function view(){
        $branchId = Branch::checkMultiBranchUser();
    	$modes = Mode::where('status',1);
        if($branchId){
            $modes->where('branch_id', $branchId);
        }
        $modes = $modes->get();
    	return view('backend.mode.view', compact('modes'));
    }

    //---- Mode Add ----//
    public function add(){
    	return view('backend.mode.add');
    }

    //---- Mode Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Insert Data
        $user = Auth::user();
        $insertData = new Mode;
        $insertData->name = $request->name;
        $insertData->branch_id = $user->branch_id;
        $insertData->created_by = $user->id;
        $insertData->save();
      // Redirect 
      return redirect()->route('mode.view')->with('success', 'Mode Added Successfully');
    }

    //---- Mode Edit ----//
    public function edit($id){
        $modeEdit = Mode::find($id);
        return view('backend.mode.edit', compact('modeEdit'));
    }

    //---- Mode Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Update
        $user = Auth::user();
        $updateData = Mode::find($id);
        $updateData->name = $request->name;
        $updateData->branch_id = $user->branch_id;
        $updateData->updated_by = $user->id;
        $updateData->save();
        // Redirect 
      return redirect()->route('mode.view')->with('success', 'Mode Updated Successfully');
    }

     //---- Mode Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Mode::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('mode.view')->with('error', 'Mode Deleted Successfully');
    }

}
