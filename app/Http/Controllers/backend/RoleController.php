<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class RoleController extends Controller
{
    //---- Role View ----//
    public function view(){
    	$roles = Role::where('status',1)->get();
    	return view('backend.role.view', compact('roles'));
    }

    //---- Role Add ----//
    public function add(){
    	return view('backend.role.add');
    }

    //---- Role Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Insert Data
        $insertData = new Role;
        $insertData->name = $request->name;
        $insertData->created_by = Auth::user()->id;
        $insertData->save();
      // Redirect 
      return redirect()->route('role.view')->with('success', 'Role Added Successfully');
    }

    //---- Role Edit ----//
    public function edit($id){
        $roleEdit = Role::find($id);
        return view('backend.role.edit', compact('roleEdit'));
    }

    //---- Role Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Update
        $updateData = Role::find($id);
        $updateData->name = $request->name;
        $updateData->updated_by = Auth::user()->id;
        $updateData->save();
        // Redirect 
      return redirect()->route('role.view')->with('success', 'Role Updated Successfully');
    }

     //---- Role Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Role::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('role.view')->with('error', 'Role Deleted Successfully');
    }

    //---- Role Permission Edit ----//
    public function permission($id){
        $permissions = Permission::where('status',1)->get();
        $role = Role::find($id);
        // $roleEdit->syncPermissions($permissions);
        $rolePermissions = $role->getAllPermissions()->pluck('id')->toarray();
        // dd($rolePermissions);
        return view('backend.role.rolePermission', compact('role', 'permissions', 'rolePermissions'));
    }

    //---- Role Permission Update ----//
    public function updateRolePermission($id, Request $request){
        // Update
        $permissionArray = $request->permission ?? [];
        $permissions = Permission::whereIn('id', $permissionArray)->get();
        $role = Role::find($id);
        $role->syncPermissions($permissions);
        // Redirect 
        return redirect()->route('role.view')->with('success', 'Role Permission Updated Successfully');
    }

    //---- Give All Permission to Super-Admin ----//
    public function allPermissionToSuperAdmin(){
        $permissions = Permission::where('status',1)->get();
        $role = Role::find(1);
        $role->syncPermissions($permissions);
        dd("accomplished");
    }
}
