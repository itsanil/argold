<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Branch;
use Auth;

class CategoryController extends Controller
{
    //---- Category View ----//
    public function view(){
        $branchId = Branch::checkMultiBranchUser();
    	$categories = Category::where('status',1);
        if($branchId){
            $categories->where('branch_id', $branchId);
        }
        $categories = $categories->get();
    	return view('backend.category.view', compact('categories'));
    }

    //---- Category Add ----//
    public function add(){
    	return view('backend.category.add');
    }

    //---- Category Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Insert Data
        $user = Auth::user();
        $insertData = new Category;
        $insertData->name = $request->name;
        $insertData->branch_id = $user->branch_id;
        $insertData->created_by = $user->id;
        $insertData->save();
      // Redirect 
      return redirect()->route('category.view')->with('success', 'Category Added Successfully');
    }

    //---- Category Edit ----//
    public function edit($id){
        $categoryEdit = Category::find($id);
        return view('backend.category.edit', compact('categoryEdit'));
    }

    //---- Category Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Update
        $user = Auth::user();
        $updateData = Category::find($id);
        $updateData->name = $request->name;
        $updateData->branch_id = $user->branch_id;
        $updateData->updated_by = $user->id;
        $updateData->save();
        // Redirect 
      return redirect()->route('category.view')->with('success', 'Category Updated Successfully');
    }

     //---- Category Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Category::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('category.view')->with('error', 'Category Deleted Successfully');
    }

}
