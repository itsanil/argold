<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Fund;
use App\Models\BranchBankMap;
use Auth;
use DB;

class FundController extends Controller
{
    //---- Fund View ----//
    public function view(){
        
        $branchId = Branch::checkMultiBranchUser();
        $funds = Fund::with('bank','branch','fromBank')->where('status',1);
        if($branchId){
            $funds->where('branch_id', $branchId);
        }
        $funds = $funds->get();
        // dd($funds[0]);
        $banks = Bank::where('status',1)->get();
        foreach ($banks as $key => $bank) {
            if ($bank->account_type_id == 2) {
                $bank->balance = isset($bank->branchBankHasOne->opening_balance) == 0 ? $bank->opening_balance : $bank->branchBankHasOne->opening_balance;
            }else{
                $bank->balance = $bank->current_balance;
            }
        }
        return view('backend.fund.view', compact('funds','banks'));
    }

    //---- Fund Add ----//
    public function add(){
        $multiBranch = Branch::checkMultiBranchUser();
        $branches = Branch::getMultiBranchData();
        
        if(Auth::user()->hasRole('Branch Admin')){
            $banks = BranchBankMap::select('banks.id','banks.name','branch_bank_map.opening_balance','banks.opening_balance as opening_balances','banks.account_type_id')
                ->join('banks','branch_bank_map.bank_id','banks.id')
                ->where('banks.status',1)
                ->where('branch_bank_map.status',1);
            $banks->where('banks.account_type_id',2)->where('branch_bank_map.branch_id', Auth::user()->branch_id);
            $banks = $banks->get();
        }else{
            $banks = Bank::where('status',1)->get();
        }  
        
        
        foreach($banks as $bank){
            $bank_data = Bank::find($bank->id);
            if ($bank->opening_balance == 0) {
                $bank->opening_balance = isset($bank_data->branchBankHasOne->opening_balance) == 0 ? $bank_data->opening_balance : $bank_data->branchBankHasOne->opening_balance;
            }
            if ($bank->account_type_id == 1) {
                
                if (Auth::user()->hasRole('Branch Admin')) {
                    $bank->opening_balance = $bank_data->branchBanks->sum('opening_balance');
                    
                }else{
                    $bank->opening_balance = $bank->current_balance + $bank_data->branchBanks->sum('opening_balance');
                }
                
            }
            if(!$bank->opening_balance){
                $bank->opening_balance = 0;
            }
        }
        return view('backend.fund.add', compact('branches','multiBranch','banks'));
    }

    //---- Fund Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'bank_id'    => 'required',
            'amount'   => 'required',
            'transaction_date'   => 'required'
        ]);
        $multiBranch = Branch::checkMultiBranchUser();
        // dd($request->all());
        // Insert Data
        $user = Auth::user();
        $insertData = new Fund;
        $insertData->bank_id = $request->bank_id;
        $insertData->amount = $request->amount;
        $insertData->transaction_date = date('Y-m-d H:m:s',strtotime($request->transaction_date));
        $insertData->payment_type = $request->payment_type;
        $insertData->reference_id = $request->reference_id;
        $insertData->remark = $request->remark;
        $insertData->branch_id = ($request->branch_id) ? $request->branch_id : Auth::user()->branch_id;
        $insertData->created_by = $user->id;


        if($multiBranch){
            $insertData->save();
            if ($request->self_transfer == 'self') {
                $request->request->add(['fund' => $insertData->id]); 
                $request->request->add(['remark' => "Branch Created Fund"]); 
                $request->request->add(['bank_id' => $request->approved_bank_id]); 
                $this->approveFund($request);
            }
        }else{
            $insertData->save();
            $request->request->add(['fund' => $insertData->id]); 
            $request->request->add(['remark' => "Admin Created Fund"]); 
            $request->request->add(['bank_id' => $request->approved_bank_id]); 
            $this->approveFund($request);
        }
       
      // Redirect 
      return redirect()->route('fund.view')->with('success', 'Fund Added Successfully');
    }

    //---- Fund Edit ----//
    public function edit($id){
        $fundEdit = Fund::find($id);
        $branches = Branch::getMultiBranchEditData();
        $banks = Bank::where('account_type_id',2)->where('branch_id',$fundEdit->branch_id)->where('status',1)->orWhere('id',$fundEdit->bank_id)->get();        
        foreach($banks as $bank){
            $bank_data = Bank::find($bank->id);
            if ($bank->opening_balance == 0) {
                $bank->opening_balance = isset($bank_data->branchBankHasOne->opening_balance) == 0 ? $bank_data->opening_balance : $bank_data->branchBankHasOne->opening_balance;
            }
            if ($bank->account_type_id == 1) {
                
                if (Auth::user()->hasRole('Branch Admin')) {
                    $bank->opening_balance = $bank_data->branchBanks->sum('opening_balance');
                    
                }else{
                    $bank->opening_balance = $bank->current_balance + $bank_data->branchBanks->sum('opening_balance');
                }
                
            }
            if(!$bank->opening_balance){
                $bank->opening_balance = 0;
            }
        }
        return view('backend.fund.edit', compact('fundEdit','banks','branches'));
    }

    //---- Fund Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'bank_id'    => 'required',
            'amount'   => 'required',
            'transaction_date'   => 'required'
        ]);
        // Update
        $user = Auth::user();
        $updateData = Fund::find($id);
        $updateData->bank_id = $request->bank_id;
        $updateData->amount = $request->amount;
        $updateData->transaction_date = date('Y-m-d H:m:s',strtotime($request->transaction_date));
        $updateData->payment_type = $request->payment_type;
        $updateData->reference_id = $request->reference_id;
        $updateData->remark = $request->remark;
        $updateData->branch_id = $request->branch_id;
        $updateData->updated_by = $user->id;
        $updateData->save();

        /*OLD DATA*/
        // $oldBank = Bank::find($request->old_bank_id);
        // if($oldBank->account_type_id == 2){
        //     $oldBranchBank = BranchBankMap::where('bank_id',$oldBank->id)->where('branch_id',$request->old_branch_id)->where('status',1)->first();
        //     if($oldBranchBank){
        //         $oldBranchBank->opening_balance -= $request->old_amount;
        //         $oldBranchBank->save();
        //     }else{
        //         $oldBank->opening_balance -= $request->old_amount;
        //     }
        // }else if($oldBank->account_type_id == 1){
        //     $oldBank->current_balance -= $request->old_amount;
        // }
        // $oldBank->save();

        // /*NEW DATA*/
        // $bank = Bank::find($request->bank_id);
        // if($bank->account_type_id == 2){
        //     $branchBank = BranchBankMap::where('bank_id',$bank->id)->where('branch_id',$request->branch_id)->where('status',1)->first();
        //     if($branchBank){
        //         $branchBank->opening_balance += $request->amount;
        //         $branchBank->save();
        //     }else{
        //         $bank->opening_balance += $request->amount;
        //     }
        // }else if($bank->account_type_id == 1){
        //     $bank->current_balance -= $request->amount;
        // }
        // $bank->save();

        // Redirect 
      return redirect()->route('fund.view')->with('success', 'Fund Updated Successfully');
    }

    //---- Fund Approve ----//
    public function approve($id, $type){
        $approveData = Fund::find($id);
        if($type == 'approve'){
            $approveData->approved = 1;
        }else if($type == 'reject'){
            $approveData->approved = 2;
        }
        $approveData->approved_by = Auth::id();
        // $approveData->admin_reason = $request->reason;
        $approveData->save();
        $bank = Bank::find($approveData->bank_id);
        $branchBank = BranchBankMap::where('bank_id',$bank->id)->where('branch_id',$approveData->branch_id)->where('status',1)->first();
        if($branchBank){
            $branchBank->opening_balance += $approveData->amount;
            $branchBank->save();
        }
        if($bank->account_type_id == 2){
            $bank->opening_balance += $approveData->amount;
        }else if($bank->account_type_id == 1){
            $bank->current_balance -= $approveData->amount;
        }
        $bank->save();
        // Redirect 
        return redirect()->route('fund.view')->with('error', 'Fund Approved Successfully');
    }

    public function approveFund(Request $request){
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('anil');
        $id = $request->fund;
        $approveData = Fund::find($id);
        $approveData->approved_bank_id = $request->bank_id;
        $approveData->approved_remark = $request->remark;
        $approveData->approved = 1;
        $approveData->approved_by = Auth::id();
        
        $bank = Bank::find($approveData->approved_bank_id);
        $fromBranchBank = BranchBankMap::where('bank_id',$approveData->approved_bank_id)->where('status',1)->first();
        $currentBranchBank = BranchBankMap::where('bank_id',$approveData->bank_id)->where('status',1)->first();

        if($fromBranchBank && $bank->account_type_id == 2){
            if($approveData->payment_type == "Deposit"){
                $fromBranchBank->opening_balance -= $approveData->amount;
                $currentBranchBank->opening_balance += $approveData->amount;
            }else if($approveData->payment_type == "Withdrawal"){
                $fromBranchBank->opening_balance += $approveData->amount;
                $currentBranchBank->opening_balance -= $approveData->amount;
            }
            $fromBranchBank->save();
            $currentBranchBank->save();
            $approveData->approved_branch_id =  $fromBranchBank->branch_id;

        }else{
            if($bank->account_type_id == 2){
                if($approveData->payment_type == "Deposit"){
                    $bank->opening_balance -= $approveData->amount;
                    $currentBranchBank->opening_balance += $approveData->amount;
                }else if($approveData->payment_type == "Withdrawal"){
                    $bank->opening_balance += $approveData->amount;
                    $currentBranchBank->opening_balance -= $approveData->amount;
                }    
            }else if($bank->account_type_id == 1){
                if($approveData->payment_type == "Deposit"){
                    $bank->current_balance -= $approveData->amount;
                    $currentBranchBank->opening_balance += $approveData->amount;
                }else if($approveData->payment_type == "Withdrawal"){
                    $bank->current_balance += $approveData->amount;
                    $currentBranchBank->opening_balance -= $approveData->amount;
                }  
            }
            $bank->save();
            $currentBranchBank->save();
        }

        $approveData->save();

        return redirect()->route('fund.view')->with('error', 'Fund Approved Successfully');
    }

    //---- Fund Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Fund::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('fund.view')->with('error', 'Fund Deleted Successfully');
    }

    public function addFund(Request $request){
        $user = Auth::user();
        $branchBank = BranchBankMap::where('bank_id',$request->bank_id)->where('status',1)->first();
        $bank = Bank::find($request->bank_id);
        if($branchBank){
            $branchBank->opening_balance += $request->amount;
            $branchBank->save();
        }else{
            if($bank->account_type_id == 1){
                $bank->current_balance += $request->amount;
            }else{
                $bank->opening_balance += $request->amount;
            }
            $bank->save();
        }
        if($bank || $branchBank){
            $insertData = new Fund;
            $insertData->bank_id = $request->bank_id;
            $insertData->amount = $request->amount;
            $insertData->transaction_date = date('Y-m-d H:m:s');
            $insertData->payment_type = 'Deposit';
            $insertData->remark = $request->remark;
            $insertData->status = 2;
            $insertData->approved = 1;
            $insertData->created_by = $user->id;
            $insertData->save();
        }

        return redirect()->route('bank.view')->with('error', 'Fund Approved Successfully');
    }

}
