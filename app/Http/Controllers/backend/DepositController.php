<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Mode;
use App\Models\Deposit;
use App\Models\Branch;
use App\Models\BranchBankMap;
use App\Models\Percentage;
use Auth;
use DB;
use DataTables;

class DepositController extends Controller
{
    //---- Deposit View ----//
    public function view(){
        return view('backend.deposit.view');
    }

    //---- Deposit Add ----//
    public function add($id = 0){
        $multiBranch = Branch::checkMultiBranchUser();
        $branches = Branch::getMultiBranchData();
        $modes = Mode::where('status',1)->get();
        $percentages = Percentage::where('status',1)->get();
        return view('backend.deposit.add', compact('multiBranch','branches','modes','percentages'));
    }

    //---- Deposit Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'branch_id'    => 'required',
            'client_id'    => 'required',
            'exchange_id'   => 'required',
            'amount'   => 'required',
            'date'   => 'required',
            'bank_id'   => 'required_if:amount,>0',
            'utr'   => 'required_if:amount,>0',
            'mode_id'   => 'required_if:amount,>0',
            'win_amt'   => 'required',
        ]);
        // Insert Data
        $user = Auth::user();
        $depositAmount = $request->amount;
        $win_amt = $request->win_amt;
        $bonusPercent = $request->bonus ?? 0;
        
        $branchExchangeMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->exchange_id)->first();
        $bonusAmount = $depositAmount + (($depositAmount / 100) * $bonusPercent);
        $previous_balance = $branchExchangeMap->opening_balance;
        $new_balance = $previous_balance - $bonusAmount;
        if ($new_balance < 0) {
            return redirect()->back()->with('error', 'Exchange Balance can not go below 0 ('.$new_balance.')');
        }
        $insertData = new Deposit;
        $insertData->client_id = $request->client_id;
        $insertData->exchange_id = $request->exchange_id;
        $insertData->win_amt = $win_amt;
        $insertData->amount = $depositAmount;
        $insertData->date = date('Y-m-d H:m:s',strtotime($request->date));
        $insertData->bank_id = $request->bank_id;
        $insertData->utr = $request->utr;
        $insertData->bonus_percent = $bonusPercent;
        $insertData->mode_id = $request->mode_id;
        $insertData->remark = $request->remark;
        $insertData->updated_by = $user->id;

        DB::transaction(function() use($request,$insertData,$depositAmount,$bonusPercent,$win_amt) {
            $insertData->branch_id = $request->branch_id;
            if($insertData->save()) {
                if ($request->bank_id) {
                    $branchBankMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->bank_id)->first();
                    $previous_balance = $branchBankMap->opening_balance;
                    $new_balance = $previous_balance + $depositAmount;
                    $branchBankMap->opening_balance = $new_balance;
                    $branchBankMap->save();
                }
                

                $branchExchangeMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->exchange_id)->first();
                $bonusAmount = $depositAmount + (($depositAmount / 100) * $bonusPercent);
                $previous_balance = $branchExchangeMap->opening_balance;
                $new_balance = $previous_balance - $bonusAmount;
                $branchExchangeMap->opening_balance = $new_balance;
                $branchExchangeMap->save();

                $client = Client::find($request->client_id);
                $client->opening_balance += $bonusAmount + $win_amt;
                $client->save();
            }
        });
      // Redirect 
      return redirect('/')->with('success', 'Deposit Added Successfully');
    }

    //---- Deposit Edit ----//
    public function edit($id){
        $branches = Branch::getMultiBranchEditData();
        $depositEdit = Deposit::find($id);
        $clients = Client::where('branch_id', $depositEdit->branch_id)->where('status',1)->orWhere('id',$depositEdit->client_id)->groupby('id')->get();
        $banks = BranchBankMap::select('banks.*')
                    ->join('banks','branch_bank_map.bank_id','banks.id')
                    ->where('banks.account_type_id',2)
                    ->where('branch_bank_map.status',1)
                    ->where('branch_bank_map.branch_id',$depositEdit->branch_id)
                    ->where('banks.status',1)
                    ->orWhere('banks.id',$depositEdit->bank_id)
                    ->groupby('banks.id')
                    ->get();
        $modes = Mode::where('status',1)->orWhere('id',$depositEdit->mode_id)
                ->get();
        $exchange = Bank::where('id',$depositEdit->exchange_id)->first();
        $percentages = Percentage::where('status',1)->get();
        return view('backend.deposit.edit', compact('depositEdit','clients','banks','modes','exchange','percentages','branches'));
    }

    //---- Deposit Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'branch_id'    => 'required',
            'client_id'    => 'required',
            'exchange_id'   => 'required',
            'amount'   => 'required',
            'date'   => 'required',
            'win_amt'   => 'required',
            'bank_id'   => 'required_if:amount,>0',
            'utr'   => 'required_if:amount,>0',
            'mode_id'   => 'required_if:amount,>0',
        ]);
        // Update
        $user = Auth::user();
        $updateData = Deposit::find($id);
        $old_balance = $updateData->amount;
        $old_win_amt = $updateData->win_amt;
        $old_bank = $updateData->bank_id;
        $old_branch = $updateData->branch_id;
        $oldBonusPercent = $updateData->bonus_percent;
        $oldBonusAmount = $old_balance + (($old_balance / 100) * $oldBonusPercent);

        $depositAmount = $request->amount;
        $win_amt = $request->win_amt;
        $bonusPercent = $request->bonus ?? 0;
        
        
            $branchBankMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->exchange_id)->first();
            $previous_balance = $branchBankMap->opening_balance;
            $new_balance = $previous_balance + $depositAmount;
            if($old_bank == $request->bank_id){
                $new_balance = $new_balance - $old_balance;
            }
            if ($new_balance < 0) {
                return redirect()->back()->with('error', 'Exchange Balance can not go below 0 ('.$new_balance.')');
            }
        
        
        $updateData->client_id = $request->client_id;
        $updateData->utr = $request->utr;
        $updateData->win_amt = $request->win_amt;
        $updateData->exchange_id = $request->exchange_id;
        $updateData->amount = $depositAmount;
        $updateData->date = date('Y-m-d H:m:s',strtotime($request->date));
        $updateData->bank_id = $request->bank_id;
        $updateData->utr = $request->utr;
        $updateData->mode_id = $request->mode_id;
        $updateData->bonus_percent = $bonusPercent;
        $updateData->remark = $request->remark;
        $updateData->updated_by = $user->id;
        DB::transaction(function() use($request,$updateData,$old_balance,$old_bank,$old_branch,$depositAmount,$bonusPercent,$oldBonusAmount,$win_amt,$old_win_amt) {
            $updateData->branch_id = $request->branch_id;
            if($updateData->save()) {
                $previous_balance = 0;
                if ($request->bank_id) {
                    $branchBankMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->bank_id)->first();
                    $previous_balance = $branchBankMap->opening_balance;
                }
                
                $new_balance = $previous_balance + $depositAmount;

                if($old_bank == $request->bank_id){
                    $new_balance = $new_balance + $old_balance;
                }else{
                    if($old_bank && $old_bank > 0){
                        $oldBankMap = BranchBankMap::where('branch_id',$old_branch)->where('bank_id', $old_bank)->first();
                        $oldBankMap->opening_balance = $oldBankMap->opening_balance - $old_balance;
                        $oldBankMap->save();
                    }
                }
                if ($request->bank_id && $request->bank_id > 0) {
                    $branchBankMap->opening_balance = $new_balance;
                    $branchBankMap->save();
                }

                

                $branchExchangeMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->exchange_id)->first();
                $bonusAmount = $depositAmount + (($depositAmount / 100) * $bonusPercent);
                $previous_balance = $branchExchangeMap->opening_balance;
                $new_balance = $previous_balance - $bonusAmount;
                $branchExchangeMap->opening_balance = $new_balance + $oldBonusAmount;
                $branchExchangeMap->save();

                $client = Client::find($request->client_id);
                $client->opening_balance += ($depositAmount + $win_amt) - ($old_balance + $old_win_amt);
                $client->save();
            }
        });

        // Redirect 
      return redirect('/')->with('success', 'Deposit Updated Successfully');
    }

     //---- Deposit Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Deposit::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('deposit.view')->with('error', 'Deposit Deleted Successfully');
    }

     //---- Fetch Deposit List----//
    public function fetchDepositList(Request $request){
        $branchId = Branch::checkMultiBranchUser();
        if ($request->bank_id) {
            $deposit = Deposit::with('client','bank','exchange','mode','branch')->where('bank_id',$request->bank_id)->orwhere('exchange_id',$request->bank_id)->where('deposits.status',1)->orderBy('deposits.created_at','DESC');
        } else {
            $deposit = Deposit::with('client','bank','exchange','mode','branch')->where('deposits.status',1)->orderBy('deposits.created_at','DESC');
        }
        
        
        if($branchId){
            $deposit->where('deposits.branch_id', $branchId);
        }
        $user = Auth::user();
        $updatePermission = ($user->hasPermissionTo('deposit-update')) ? 1 :0;
        $deletePermission = ($user->hasPermissionTo('deposit-delete')) ? 1 :0;

        return DataTables::of($deposit)
             ->editColumn('date', function ($deposit) {
                    return date('d-m-Y h:m:s A',strtotime($deposit->date));
                })
            ->editColumn('bonus_percent', function ($deposit) {
                    return intval($deposit->amount*$deposit->bonus_percent/100).'Rs/- ('.$deposit->bonus_percent.'%)';
                })
            ->editColumn('bank_name', function ($deposit) {
                    return $deposit->bank?$deposit->bank->name:'';
            })
            ->editColumn('mode_name', function ($deposit) {
                    return $deposit->mode?$deposit->mode->name:'';
            })
            ->editColumn('client_name', function ($deposit) {
                    return "<a href=".route('client.clientDetails',$deposit->client->id).">".$deposit->client->name."</a>";
                })
             ->editColumn('action', function ($deposit) use ($updatePermission, $deletePermission) {
                    $html = '';
                    if($updatePermission){
                        $html .= '<a class="btn btn-secondary btn-sm" href="'.route('deposit.edit', $deposit->id) .'">Edit</a>';
                    }                
                    if($deletePermission){
                        $html .= '<a class="btn btn-danger btn-sm"  href="'.route('deposit.delete', $deposit->id) .'">Delete</a>';
                    }
                    return $html;
                })
             ->rawColumns(['action','client_name'])
            ->make(true);
    }

}
