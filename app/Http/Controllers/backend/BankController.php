<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\BranchBankMap;
use App\Models\Fund;
use Auth;

class BankController extends Controller
{
    //---- Bank View ----//
    public function view(){
        $branchId = Branch::checkMultiBranchUser();
        $physicalBanks = Bank::with('branchBankHasOne')->where('account_type_id',2)->where('status',1);
        $virtualBanks = Bank::with('branchBanks')->where('account_type_id',1)->where('status',1);
        if($branchId){
            $physicalBanks->where('branch_id', $branchId);
            $virtualBanks->where('branch_id', $branchId);
        }
        $physicalBanks = $physicalBanks->get();
        $virtualBanks = $virtualBanks->get();
        // dd($banks[0]->branchBankHasOne->branch_id);
        return view('backend.bank.view', compact('physicalBanks','virtualBanks'));
    }
    
    public function show($bank_id){
        $bank_data = Bank::find($bank_id);
        $branchId = Branch::checkMultiBranchUser();
        $funds = Fund::with('bank','branch','fromBank')->where('bank_id',$bank_id)->where('status',1);
        if($branchId){
            $funds->where('branch_id', $branchId);
        }
        $funds = $funds->orderBy('created_at','DESC')->get();
        // dd($funds[0]);
        $dfunds = Fund::with('bank','branch','fromBank')->where('bank_id',$bank_id)->where('status',2);
        if($branchId){
            $dfunds->where('branch_id', $branchId);
        }
        $dfunds = $dfunds->orderBy('created_at','DESC')->get();
        $banks = Bank::where('id',$bank_id)->get();
        return view('backend.bank.show', compact('bank_data','funds','banks','dfunds'));
    }

    //---- Bank Add ----//
    public function add(){
        $accountTypes = AccountType::where('status',1)->get();
        return view('backend.bank.add', compact('accountTypes'));
    }

    //---- Bank Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
            'account_type_id'    => 'required',
            'opening_balance'   => 'required'
        ]);
        // Insert Data
        $user = Auth::user();
        $insertData = new Bank;
        $insertData->name = $request->name;
        $insertData->account_type_id = $request->account_type_id;
        $insertData->opening_balance = $request->opening_balance;
        $insertData->current_balance = $request->opening_balance;
        $insertData->transaction_code = $request->transaction_code;
        $insertData->account_number = $request->account_number;
        $insertData->ifsc_code = $request->ifsc_code;
        $insertData->source = $request->source;
        $insertData->remark = $request->remark;
        $insertData->branch_id = $user->branch_id;
        $insertData->created_by = $user->id;
        $insertData->save();
      // Redirect 
      return redirect()->route('bank.view')->with('success', 'Bank Added Successfully');
    }

    //---- Bank Edit ----//
    public function edit($id){
        $accountTypes = AccountType::where('status',1)->get();
        $bankEdit = Bank::find($id);
        return view('backend.bank.edit', compact('bankEdit','accountTypes'));
    }

    //---- Bank Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
        ]);
        // Update
        $user = Auth::user();
        $updateData = Bank::find($id);
        $updateData->name = $request->name;
        $updateData->transaction_code = $request->transaction_code;
        $updateData->account_number = $request->account_number;
        $updateData->ifsc_code = $request->ifsc_code;
        $updateData->source = $request->source;
        $updateData->remark = $request->remark;
        $updateData->branch_id = $user->branch_id;
        $updateData->updated_by = $user->id;
        $updateData->save();
        // Redirect 
      return redirect()->route('bank.view')->with('success', 'Bank Updated Successfully');
    }

     //---- Bank Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Bank::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('bank.view')->with('error', 'Bank Deleted Successfully');
    }

     //---- Bank Bank Data ----//
    public function getBankData(Request $request){
        $banks = BranchBankMap::select('banks.id','banks.name','branch_bank_map.opening_balance','banks.opening_balance as opening_balances','banks.account_type_id')
                ->join('banks','branch_bank_map.bank_id','banks.id')
                ->where('branch_bank_map.branch_id', $request->id)
                ->where('banks.status',1)
                ->where('branch_bank_map.status',1);
        if($request->type == "exchange"){
            $banks->where('banks.account_type_id',1);
        }  
        if($request->type == "bank" || $request->type == "expense" || Auth::user()->hasRole('Branch Admin')){
            $banks->where('banks.account_type_id',2);
        }             
        $types = isset($request->types)?$request->types:'';
        $banks = $banks->get();
        $html = '<option value="">Select</option>';
        foreach($banks as $bank){
            if ($bank->opening_balance == 0) {
                $bank->opening_balance = $bank->opening_balances;
            }
            if ($bank->account_type_id == 1) {
                $bank_data = Bank::find($bank->id);
                if (Auth::user()->hasRole('Branch Admin') || $types == 'branch') {
                    $bank->opening_balance = $bank_data->branchBanks->where('branch_id',$request->id)->sum('opening_balance');
                }else{
                    $bank->opening_balance = $bank_data->current_balance + $bank_data->branchBanks->where('branch_id',$request->id)->sum('opening_balance');
                }
            }
            $html .= '<option value="'.$bank->id.'" current_balance="'.$bank->opening_balance.'" >'.$bank->name.'(Current Balance:'.$bank->opening_balance.')</option>';
        }
        return $html;
    }
    
}
