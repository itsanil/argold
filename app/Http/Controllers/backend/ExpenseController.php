<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Branch;
use App\Models\BranchBankMap;
use Auth;
use DB;

class ExpenseController extends Controller
{
    //---- Expense View ----//
    public function view(){
        $branchId = Branch::checkMultiBranchUser();
    	$expenses = Expense::with('bank','branch','category')->where('status',1);
        if($branchId){
            $expenses->where('branch_id', $branchId);
        }
        $expenses = $expenses->get();
    	return view('backend.expense.view', compact('expenses'));
    }

    //---- Expense Add ----//
    public function add(){
        $branches = Branch::where('status',1)->get();
        $banks = Bank::where('account_type_id',2)->where('status',1)->get();
        $categories = Category::where('status',1)->get();
    	return view('backend.expense.add', compact('branches','banks','categories'));
    }

    //---- Expense Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'branch_id'    => 'required',
            'bank_id'   => 'required',
            'category_id'   => 'required',
            'amount'   => 'required',
            'date'   => 'required',
        ]);
        // Insert Data
        $insertData = new Expense;
        $insertData->branch_id = $request->branch_id;
        $insertData->bank_id = $request->bank_id;
        $insertData->category_id = $request->category_id;
        $insertData->amount = $request->amount;
        $insertData->date = date('Y-m-d',strtotime($request->date));
        $insertData->remark = $request->remark;
        $insertData->created_by = Auth::user()->id;

        $bank = Bank::find($request->bank_id);
        $fromBranchBank = BranchBankMap::where('bank_id',$request->bank_id)->where('status',1)->first();
        $ExpenseAmount = $request->amount;

        if($fromBranchBank && $bank->account_type_id == 2){
            $fromBranchBank->opening_balance -= $ExpenseAmount;
            $fromBranchBank->save();
        }else{
            if($bank->account_type_id == 2){
                $bank->opening_balance -= $ExpenseAmount;
            }else if($bank->account_type_id == 1){
                $bank->current_balance -= $ExpenseAmount;
            }
            $bank->save();
        }
        $insertData->save();


        DB::transaction(function() use($request,$insertData,$ExpenseAmount) {
            $insertData->branch_id = $request->branch_id;
            if($insertData->save()) {
                $branchBankMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->bank_id)->first();
                $previous_balance = $branchBankMap->opening_balance;
                $new_balance = $previous_balance - $ExpenseAmount;
                $branchBankMap->opening_balance = $new_balance;
                $branchBankMap->save();

                $branchExchangeMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->bank_id)->first();
                $previous_balance = $branchExchangeMap->opening_balance;
                $new_balance = $previous_balance + $ExpenseAmount;
                $branchExchangeMap->opening_balance = $new_balance;
                $branchExchangeMap->save();

                // $client = Client::find($request->client_id);
                // $client->opening_balance -= $ExpenseAmount;
                // $client->save();

            }
        });
       
      // Redirect 
      return redirect()->route('expense.view')->with('success', 'Expense Added Successfully');
    }

    //---- Expense Edit ----//
    public function edit($id){
        $expenseEdit = Expense::find($id);
        $branches = Branch::where('status',1)->orWhere('id',$expenseEdit->branch_id)->get();
        $banks = Bank::where('account_type_id',2)->where('status',1)->orWhere('id',$expenseEdit->bank_id)->get();
        $categories = Category::where('status',1)->orWhere('id',$expenseEdit->category_id)->get();        
        return view('backend.expense.edit', compact('expenseEdit','branches','banks','categories'));
    }

    //---- Expense Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'branch_id'    => 'required',
            'bank_id'   => 'required',
            'category_id'   => 'required',
            'amount'   => 'required',
            'date'   => 'required',
        ]);
        // Update
        $updateData = Expense::find($id);
        $old_balance = $updateData->amount;
        $old_bank = $updateData->bank_id;
        $old_branch = $updateData->branch_id;


        $updateData->branch_id = $request->branch_id;
        $updateData->bank_id = $request->bank_id;
        $updateData->category_id = $request->category_id;
        $updateData->amount = $request->amount;
        $updateData->date = date('Y-m-d',strtotime($request->date));
        $updateData->remark = $request->remark;
        $updateData->updated_by = Auth::user()->id;
        // $updateData->save();

        $ExpenseAmount = $request->amount;

        // echo "<pre>"; print_r($updateData); echo "</pre>"; die('anil');

        DB::transaction(function() use($request,$updateData,$old_balance,$old_bank,$old_branch,$ExpenseAmount) {
            $updateData->branch_id = $request->branch_id;
            if($updateData->save()) {

                $bank = Bank::find($old_bank);
                $fromBranchBank = BranchBankMap::where('bank_id',$old_bank)->where('status',1)->first();
                // $ExpenseAmount = $request->amount;
                
                if($fromBranchBank && $bank->account_type_id == 2){
                    $fromBranchBank->opening_balance += $old_balance;
                    $fromBranchBank->save();
                }else{
                    if($bank->account_type_id == 2){
                        $bank->opening_balance += $old_balance;
                    }else if($bank->account_type_id == 1){
                        $bank->current_balance += $old_balance;
                    }
                    $bank->save();
                }

                $bank = Bank::find($request->bank_id);
                $fromBranchBank = BranchBankMap::where('bank_id',$request->bank_id)->where('status',1)->first();
                $ExpenseAmount = $request->amount;

                if($fromBranchBank && $bank->account_type_id == 2){
                    $fromBranchBank->opening_balance -= $ExpenseAmount;
                    $fromBranchBank->save();
                }else{
                    if($bank->account_type_id == 2){
                        $bank->opening_balance -= $ExpenseAmount;
                    }else if($bank->account_type_id == 1){
                        $bank->current_balance -= $ExpenseAmount;
                    }
                    $bank->save();
                }
            }
        });
        // Redirect 
      return redirect()->route('expense.view')->with('success', 'Expense Updated Successfully');
    }

     //---- Expense Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Expense::find($id);
        $old_balance = $updateData->amount;
        $old_bank = $updateData->bank_id;
        $old_branch = $updateData->branch_id;
        $bank = Bank::find($old_bank);
        $fromBranchBank = BranchBankMap::where('bank_id',$old_bank)->where('status',1)->first();
        // $ExpenseAmount = $request->amount;
        
        if($fromBranchBank && $bank->account_type_id == 2){
            $fromBranchBank->opening_balance += $old_balance;
            $fromBranchBank->save();
        }else{
            if($bank->account_type_id == 2){
                $bank->opening_balance += $old_balance;
            }else if($bank->account_type_id == 1){
                $bank->current_balance += $old_balance;
            }
            $bank->save();
        }
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('expense.view')->with('error', 'Expense Deleted Successfully');
    }

}
