<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Spatie\Permission\Models\Role;
use App\Models\Branch;
use Auth;

class UserController extends Controller
{
    //---- Users View ----//
    public function view(){
        $branchId = Branch::checkMultiBranchUser();
    	$users = Admin::with('roles','branchDetail')->where('status',1)->where('id','!=', Auth::id());
        if($branchId){
            $users->where('branch_id', $branchId);
        }
        $users = $users->get();
    	return view('backend.user.view', compact('users'));
    }

    //---- Users Add ----//
    public function add(){
        $multiBranchCheck = Branch::checkMultiBranchUser();
        $roles = Role::where('status',1)->where('id','!=',1);
        if($multiBranchCheck){
            $roles->whereNotIn('id',[2,4]);            
        }
        $roles = $roles->get();
        $branches = Branch::getMultiBranchData();
    	return view('backend.user.add', compact('roles','branches','multiBranchCheck'));
    }

    //---- Users Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
            'email'    => 'required',
            'branch_id'   => 'required',
            'role'   => 'required',
            'password'   => 'required',
        ]);
        // Insert Data
        $insertData = new Admin;
        $insertData->name = $request->name;
        $insertData->email = $request->email;
        $insertData->password = Hash::make($request->password);
        $insertData->encrypt_password = base64_encode($request->password);
        $insertData->mobile = $request->mobile;
        $insertData->branch_id = $request->branch_id;
        $insertData->created_by = Auth::user()->id;
        $insertData->save();
        $insertData->assignRole($request->role);
      // Redirect 
      return redirect()->route('user.view')->with('success', 'Users Added Successfully');
    }

    //---- Users Edit ----//
    public function edit($id){
        $multiBranchCheck = Branch::checkMultiBranchUser();
        $roles = Role::where('status',1)->where('id','!=',1);
        if($multiBranchCheck){
            $roles->whereNotIn('id',[2,4]);            
        }
        $roles = $roles->get();
        $branches = Branch::getMultiBranchEditData();
        $userEdit = Admin::find($id);
        return view('backend.user.edit', compact('userEdit','roles','branches'));
    }

    //---- Users Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
            'email'    => 'required',
            'branch_id'   => 'required',
            'role'   => 'required',
            'password'   => 'required',
        ]);
        // Update
        $updateData = Admin::find($id);
        $updateData->name = $request->name;
        $updateData->email = $request->email;
        $updateData->password = Hash::make($request->password);
        $updateData->encrypt_password = base64_encode($request->password);
        $updateData->mobile = $request->mobile;
        $updateData->branch_id = $request->branch_id;
        $updateData->updated_by = Auth::user()->id;
        $updateData->save();
        
        $updateData->Roles()->detach();
        $updateData->assignRole($request->role);

        // Redirect 
      return redirect()->route('user.view')->with('success', 'Users Updated Successfully');
    }

     //---- Users Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Admin::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('user.view')->with('error', 'Users Deleted Successfully');
    }

    public function checkEmailExists(Request $request){
        if($request->type == 'edit'){
            if($request->email == $request->old_email){
                return "true";
            }
        }
        $count = Admin::where('email',$request->email)->count();
        if($count){
            return "false";
        }
        return "true";
    }

}
