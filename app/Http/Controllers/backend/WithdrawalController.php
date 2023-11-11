<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Mode;
use App\Models\Withdrawal;
use App\Models\Branch;
use App\Models\BranchBankMap;
use Auth;
use DB;
use DataTables;

class WithdrawalController extends Controller
{
    //---- Withdrawal View ----//
    public function view(){
        return view('backend.withdrawal.view');
    }

    //---- Withdrawal Add ----//
    public function add($id = 0){
        $multiBranch = Branch::checkMultiBranchUser();
        $branches = Branch::getMultiBranchData();
        $modes = Mode::where('status',1)->get();
        return view('backend.withdrawal.add', compact('multiBranch','branches','modes'));
    }

    //---- Withdrawal Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'branch_id'    => 'required',
            'client_id'    => 'required',
            'exchange_id'   => 'required',
            'exchange_amt'   => 'required',
            'amount'   => 'required',
            'date'   => 'required',
            'bank_id'   => 'required_if:amount,>0',
            'utr'   => 'required_if:amount,>0',
            'mode_id'   => 'required_if:amount,>0',
        ]);
        // Insert Data
        $withdrawalAmount = ($request->amount)?$request->amount:0;
        $exchange_amt = ($request->exchange_amt)?$request->exchange_amt:0;
        // $client = Client::find($request->client_id);
        // $client_opening_balance = $client->opening_balance - (($withdrawalAmount + $exchange_amt));
        // if ($client_opening_balance < 0) {
        //     return redirect()->back()->with('error', 'Client Balance can not go below 0 ('.$client_opening_balance.')');
        // }
        $user = Auth::user();
        $insertData = new Withdrawal;
        $insertData->client_id = $request->client_id;
        $insertData->exchange_id = $request->exchange_id;
        $insertData->amount = $withdrawalAmount;
        $insertData->date = date('Y-m-d H:m:s',strtotime($request->date));
        $insertData->bank_id = ($request->bank_id)?$request->bank_id:0;
        $insertData->exchange_amt = $request->exchange_amt;
        $insertData->utr = $request->utr;
        $insertData->mode_id = ($request->mode_id)?$request->mode_id:0;
        $insertData->remark = $request->remark;
        $insertData->created_by = $user->id;

        DB::transaction(function() use($request,$insertData,$withdrawalAmount,$exchange_amt) {
            $insertData->branch_id = $request->branch_id;
            if($insertData->save()) {
                if ($request->bank_id) {
                    $branchBankMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->bank_id)->first();
                    $previous_balance = $branchBankMap->opening_balance;
                    $new_balance = $previous_balance - $withdrawalAmount;
                    $branchBankMap->opening_balance = $new_balance;
                    $branchBankMap->save();
                }
                

                $branchExchangeMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->exchange_id)->first();
                $previous_balance = $branchExchangeMap->opening_balance;
                $new_balance = $previous_balance + $withdrawalAmount + $exchange_amt;
                $branchExchangeMap->opening_balance = $new_balance;
                $branchExchangeMap->save();

                $client = Client::find($request->client_id);
                $client->opening_balance -= $withdrawalAmount + $exchange_amt;
                $client->save();

            }
        });
       
      // Redirect 
      return redirect('/')->with('success', 'Withdrawal Added Successfully');
    }

    //---- Withdrawal Edit ----//
    public function edit($id){
        $branches = Branch::getMultiBranchEditData();
        $withdrawalEdit = Withdrawal::find($id);
        $clients = Client::where('branch_id', $withdrawalEdit->branch_id)->where('status',1)->orWhere('id',$withdrawalEdit->client_id)->groupby('id')->get();
        $banks = BranchBankMap::select('banks.*')
                    ->join('banks','branch_bank_map.bank_id','banks.id')
                    ->where('banks.account_type_id',2)
                    ->where('branch_bank_map.status',1)
                    ->where('branch_bank_map.branch_id',$withdrawalEdit->branch_id)
                    ->where('banks.status',1)
                    ->orWhere('banks.id',$withdrawalEdit->bank_id)
                    ->groupby('banks.id')
                    ->get();
        $modes = Mode::where('status',1)->orWhere('id',$withdrawalEdit->mode_id)
                ->get();
        $exchange = Bank::where('id',$withdrawalEdit->exchange_id)->first();
       
        return view('backend.withdrawal.edit', compact('withdrawalEdit','clients','banks','modes','exchange','branches'));
    }

    //---- Withdrawal Update ----//
    public function update($id, Request $request){
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
        ]);
        // Update
        $user = Auth::user();
        $updateData = Withdrawal::find($id);
        $old_balance = $updateData->amount;
        $old_exchange_amt = $updateData->exchange_amt;
        $old_bank = ($updateData->bank_id)?$updateData->bank_id:0;
        $old_branch = $updateData->branch_id;

        $withdrawalAmount = $request->amount;
        $exchange_amt = $request->exchange_amt;

        // $client = Client::find($request->client_id);
        // $client_opening_balance = $client->opening_balance - (($withdrawalAmount + $exchange_amt) - ($old_balance + $old_exchange_amt));
        // if ($client_opening_balance < 0) {
        //     return redirect()->back()->with('error', 'Client Balance can not go below 0 ('.$client_opening_balance.')');
        // }
        $updateData->client_id = $request->client_id;
        $updateData->exchange_id = $request->exchange_id;
        $updateData->exchange_amt = $request->exchange_amt;
        $updateData->amount = $withdrawalAmount;
        $updateData->date = date('Y-m-d H:m:s',strtotime($request->date));
        $updateData->bank_id = ($request->bank_id)?$request->bank_id:0;
        $updateData->utr = $request->utr;
        $updateData->mode_id = ($request->mode_id)?$request->mode_id:0;
        $updateData->remark = $request->remark;
        $updateData->updated_by = $user->id;
        
        DB::transaction(function() use($request,$updateData,$old_balance,$old_bank,$old_branch,$old_exchange_amt,$exchange_amt,$withdrawalAmount) {
            $updateData->branch_id = $request->branch_id;
            $request->bank_id = $request->bank_id?$request->bank_id:0;
            if($updateData->save()) {
                $new_balance = 0;
                if ($request->bank_id && $request->bank_id > 0) {
                    $branchBankMap = BranchBankMap::where('branch_id',$request->branch_id)->where('bank_id', $request->bank_id)->first();
                    $previous_balance = $branchBankMap->opening_balance;
                    $new_balance = $previous_balance - $withdrawalAmount;
                }
                
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
                $previous_balance = $branchExchangeMap->opening_balance;
                $new_balance = ($previous_balance + $withdrawalAmount + $exchange_amt) - ($old_balance + $old_exchange_amt) ;
                $branchExchangeMap->opening_balance = $new_balance;
                $branchExchangeMap->save();

                $client = Client::find($request->client_id);
                $client->opening_balance -= ($withdrawalAmount + $exchange_amt) - ($old_balance + $old_exchange_amt);
                $client->save();
            }
        });

        // Redirect 
        return redirect()->route('withdrawal.view')->with('success', 'Withdrawal Updated Successfully');
    }

    //---- Withdrawal Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Withdrawal::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('withdrawal.view')->with('error', 'Withdrawal Deleted Successfully');
    }

    //---- Fetch Withdrawal List----//
    public function fetchWithdrawalList(Request $request){
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('anil');
        if (isset($request['columns']) && isset($request['search']) && isset($request['order'])) {
            // foreach ($request['columns'] as $key => $value) {
            //     if ($request['columns'][$key]['data'] == 'client_name') {
            //         $request['columns'][$key]['data'] = 'client_id';
            //         $request['columns'][$key]['name'] = 'client_id';
            //     }
            //     if ($request['columns'][$key]['data'] == 'branch.branch_number') {
            //         $request['columns'][$key]['data'] = 'branch.id';
            //         $request['columns'][$key]['name'] = 'branch.id';
            //     }
            // }
        }
        // echo "<pre>"; print_r($request['columns']); echo "</pre>"; die('anil');

        $branchId = Branch::checkMultiBranchUser();
        if ($request->bank_id) {
            $withdrawal = Withdrawal::with('client','bank','exchange','mode','branch')->where('bank_id',$request->bank_id)->orwhere('exchange_id',$request->bank_id)->where('withdrawals.status',1)->orderBy('withdrawals.created_at','DESC');
        } else {
            $withdrawal = Withdrawal::with('client','bank','exchange','mode','branch')->where('withdrawals.status',1)->orderBy('withdrawals.created_at','DESC');
        }
        
        if($branchId){
            $withdrawal->where('withdrawals.branch_id', $branchId);
        }

        $user = Auth::user();
        $updatePermission = ($user->hasPermissionTo('withdrawal-update')) ? 1 :0;
        $deletePermission = ($user->hasPermissionTo('withdrawal-delete')) ? 1 :0;

        return DataTables::of($withdrawal)
             ->editColumn('date', function ($withdrawal) {
                    return date('d-m-Y h:m:s A',strtotime($withdrawal->date));
                })
            ->editColumn('bank_name', function ($withdrawal) {
                    return $withdrawal->bank?$withdrawal->bank->name:'';
            })
            ->editColumn('mode_name', function ($withdrawal) {
                    return $withdrawal->mode?$withdrawal->mode->name:'';
            })
            ->editColumn('client_id', function ($withdrawal) {
                return "<a href=".route('client.clientDetails',$withdrawal->client->id).">".$withdrawal->client->name."</a>";
            })
             ->editColumn('action', function ($withdrawal) use ($updatePermission, $deletePermission) {
                    $html = '';
                    if($updatePermission){
                        $html .= '<a class="btn btn-secondary btn-sm" href="'.route('withdrawal.edit', $withdrawal->id) .'">Edit</a>';
                    }                
                    if($deletePermission){
                        $html .= '<a class="btn btn-danger btn-sm"  href="'.route('withdrawal.delete', $withdrawal->id) .'">Delete</a>';
                    }
                    return $html;
                })
             ->rawColumns(['action','client_id'])
            ->make(true);
    }
}
