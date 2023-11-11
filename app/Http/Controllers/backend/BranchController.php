<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\BranchBankMap;
use App\Models\BranchEmployeeMap;
use App\Models\BranchBankBalanceLogs;
use App\Models\Fund;
use Auth;
use DB;
use Exception;

class BranchController extends Controller
{
    //---- Branch View ----//
    public function view(){
        $banks = Bank::where('status',1)->get();
        $branches = Branch::getMultiBranchData();
        $branchId = Branch::checkMultiBranchUser();
        $funds = Fund::with('bank')->where('status',1);
        if($branchId){
            $funds->where('branch_id', $branchId);
        }
        $funds = $funds->get();
        return view('backend.branch.view', compact('branches','banks','funds'));
    }

    //---- Branch Add ----//
    public function add(){
        $physicalBanks = Bank::where('account_type_id',2)->pluck('id')->toArray();
        $branchBankMap = BranchBankMap::where('status',1)->whereIn('bank_id',$physicalBanks)->pluck('bank_id')->toArray();
        $banks = Bank::where('status',1)->whereNotIn('id',$branchBankMap)->get();
        return view('backend.branch.add',compact('banks'));
    }

    //---- Branch Store ----//
    public function store(Request $request){
        // validation
        // dd($request->opening_balance[0]);
        $validation = $request->validate([
            'branch_number'    => 'required',
            'phone'   => 'required'
        ]);
        // Insert Data
        $branchInsert = new Branch;
        $branchInsert->branch_number  = $request->branch_number;
        // $branchInsert->name = $request->name;
        $branchInsert->address = $request->address;
        $branchInsert->phone = $request->phone;
        $branchInsert->admin_name = $request->admin_name;
        $branchInsert->remark = $request->remark;
        $branchInsert->whatsapp_1 = $request->whatsapp_1;
        $branchInsert->whatsapp_2 = $request->whatsapp_2;
        $branchInsert->whatsapp_3 = $request->whatsapp_3;
        $branchInsert->whatsapp_4 = $request->whatsapp_4;
        $branchInsert->whatsapp_5 = $request->whatsapp_5;
        $branchInsert->whatsapp_6 = $request->whatsapp_6;
        $branchInsert->created_by = Auth::user()->id;
        
        DB::transaction(function() use($request,$branchInsert) {
            if($branchInsert->save()) {
                foreach ($request->bank_id as $key => $bank) {
                    if($bank){
                        $branchBankMap = new BranchBankMap();
                        $branchBankMap->branch_id = $branchInsert->id;
                        $branchBankMap->bank_id = $request->bank_id[$key];
                        $branchBankMap->initial_balance = $request->opening_balance[$key] ?? 0;
                        $branchBankMap->opening_balance = $request->opening_balance[$key] ?? 0;
                        $branchBankMap->save();

                        $bank = Bank::find($request->bank_id[$key]);
                        $bank->current_balance -=  $branchBankMap->opening_balance;
                        $bank->save();


                    }
                }

                foreach ($request->employee_name as $key => $employee) {
                    if($employee){
                        $branchEmployeeMap = new BranchEmployeeMap();
                        $branchEmployeeMap->branch_id = $branchInsert->id;
                        $branchEmployeeMap->employee_name = $request->employee_name[$key];
                        $branchEmployeeMap->mobile_number = $request->mobile_number[$key];
                        $branchEmployeeMap->save();
                    }
                }
            }
        });
      // Redirect 
      return redirect()->route('dashboard.view')->with('success', 'Branch Added Successfully');
    }

    //---- Branch Edit ----//
    public function edit($id){
        $banks = Bank::where('status',1)->get();        
        $branchEdit = Branch::find($id);
        $branchBankMaps = BranchBankMap::select('branch_bank_map.*','banks.id as bank_id','banks.name as bank_name')->join('banks','banks.id','branch_bank_map.bank_id')->where('branch_bank_map.branch_id',$id)->where('branch_bank_map.status',1)->orderBy('banks.account_type_id','desc')->get();
        $branchEmployeeMaps = BranchEmployeeMap::where('branch_id',$id)->where('status',1)->get();
        $countBranchBankMap = count($branchBankMaps);
        $countBranchEmployeeMap = count($branchEmployeeMaps);
        return view('backend.branch.edit', compact('branchEdit','banks','branchBankMaps','countBranchBankMap','branchEmployeeMaps','countBranchEmployeeMap'));
    }

    //---- Branch Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'branch_number'    => 'required',
            'phone'   => 'required'
        ]);
        // Update
        $branchUpdate = Branch::find($id);
        $branchUpdate->branch_number  = $request->branch_number;
        // $branchUpdate->name = $request->name;
        $branchUpdate->address = $request->address;
        $branchUpdate->phone = $request->phone;
        $branchUpdate->admin_name = $request->admin_name;
        $branchUpdate->remark = $request->remark;
        $branchUpdate->whatsapp_1 = $request->whatsapp_1;
        $branchUpdate->whatsapp_2 = $request->whatsapp_2;
        $branchUpdate->whatsapp_3 = $request->whatsapp_3;
        $branchUpdate->whatsapp_4 = $request->whatsapp_4;
        $branchUpdate->whatsapp_5 = $request->whatsapp_5;
        $branchUpdate->whatsapp_6 = $request->whatsapp_6;
        $branchUpdate->updated_by = Auth::user()->id;
        
        DB::transaction(function() use($request,$branchUpdate) {
            if($branchUpdate->save()) {
                /*BANK MAP*/
                $updateBranchBank =BranchBankMap::where('branch_id',$branchUpdate->id);

                if($request->branch_bank_id){
                   $old_bank_b = $updateBranchBank->whereNotIn('id', array_filter($request->branch_bank_id))->get();
                   foreach ($old_bank_b as $branch_bank_map) {
                        $branchBankMap = BranchBankMap::where('id',$branch_bank_map->id)->where('status',1)->get();

                        $bank = Bank::find($branch_bank_map->bank_id);
                        $bank->current_balance +=  $branchBankMap->sum('opening_balance');
                        $bank->save();
                    }
                    $updateBranchBank->whereNotIn('id', array_filter($request->branch_bank_id))->update(['status'=>0]);
                }

                
                
                if($request->bank_id){
                    foreach ($request->bank_id as $key => $bank) {
                        if($bank){
                            $branchBankMap = new BranchBankMap();
                            $branchBankMap->branch_id = $branchUpdate->id;
                            $branchBankMap->bank_id = $request->bank_id[$key];
                            if($request->opening_balance[$key]){
                                $branchBankMap->initial_balance = $request->opening_balance[$key];
                                $branchBankMap->opening_balance = $request->opening_balance[$key];
                            }
                            $branchBankMap->save();

                            $bank = Bank::find($request->bank_id[$key]);
                            $bank->current_balance -=  $branchBankMap->opening_balance;
                            $bank->save();
                        }
                    }
                }

                /*EMPLOYEE MAP*/
                $updateBranchEmployee =BranchEmployeeMap::where('branch_id',$branchUpdate->id);
                    $updateBranchEmployee->update(['status'=>0]);
                if($request->employee_name){
                    foreach ($request->employee_name as $key => $employee_name) {
                        if($employee_name){
                            $branchEmployeeMap = new BranchEmployeeMap();
                            $branchEmployeeMap->branch_id = $branchUpdate->id;
                            $branchEmployeeMap->employee_name = $request->employee_name[$key];
                            $branchEmployeeMap->mobile_number = $request->mobile_number[$key];
                            $branchEmployeeMap->save();
                        }
                    }
                }
            }
        });
        // Redirect 
      return redirect()->route('dashboard.view')->with('success', 'Branch Updated Successfully');
    }

     //---- Branch Delete ----//
    public function delete($id){
        // Delete
        $branchDelete = Branch::find($id);
        $branchDelete->status = 0;
        $physicalBanks = Bank::select('id')->where('account_type_id',1)->pluck('id')->toArray();
        DB::transaction(function() use($branchDelete, $id,$physicalBanks) {
            if($branchDelete->save()) {
                BranchBankMap::where('branch_id',$id)->where('status',1)->update(['status'=>2]);
            }
            foreach ($physicalBanks as $value) {
                $amount = BranchBankMap::where('branch_id',$id)->where('bank_id',$value)->sum('opening_balance');
                $bank_data = Bank::find($value);
                $bank_data->current_balance += $amount;
                $bank_data->save();
            }
        });
        

        // Redirect 
      return redirect()->route('dashboard.view')->with('error', 'Branch Deleted Successfully');
    }

    public function addNewBank(Request $request)
    {
        DB::transaction(function() use($request) {
            $branchBankMap = new BranchBankMap();
            $branchBankMap->branch_id = $request->id;
            $branchBankMap->bank_id = $request->bank_id;
            $branchBankMap->initial_balance = $request->opening_balance;
            $branchBankMap->opening_balance = $request->opening_balance;
            $branchBankMap->save();
        });
        return 200;
    } 
}
