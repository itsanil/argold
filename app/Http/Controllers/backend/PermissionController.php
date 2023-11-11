<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Auth;

class PermissionController extends Controller
{
    //---- Permission View ----//
    public function view(){
    	$permissions = Permission::where('status',1)->get();
    	return view('backend.permission.view', compact('permissions'));
    }

    //---- Permission Add ----//
    public function add(){
    	return view('backend.permission.add');
    }

    //---- Permission Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Insert Data
        $insertData = new Permission;
        $insertData->name = $request->name;
        $insertData->save();

        $permission = Permission::find($insertData->id);
        $role = Role::find(1);
        $role->givePermissionTo($permission);
      // Redirect 
      return redirect()->route('permission.view')->with('success', 'Permission Added Successfully');
    }

    //---- Permission Edit ----//
    public function edit($id){
        $permissionEdit = Permission::find($id);
        return view('backend.permission.edit', compact('permissionEdit'));
    }

    //---- Permission Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Update
        $updateData = Permission::find($id);
        $updateData->name = $request->name;
        $updateData->save();
        // Redirect 
      return redirect()->route('permission.view')->with('success', 'Permission Updated Successfully');
    }

     //---- Permission Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Permission::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('permission.view')->with('error', 'Permission Deleted Successfully');
    }

}
