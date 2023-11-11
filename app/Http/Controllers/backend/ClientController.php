<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Client;
use App\Models\ClientBankMap;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\BranchBankMap;
use App\Models\Withdrawal;
use App\Models\Deposit;
use App\Models\Fund;
use Auth;
use DB;

class ClientController extends Controller
{
    //---- Client View ----//
    public function view($bank_id = null){
        
        $branchId = Branch::checkMultiBranchUser();
        $clients = Client::with('exchange','branch')->where('status',1);
        if($branchId){
            $clients->where('branch_id', $branchId);
        }
        if ($bank_id) {
            $branch_ids = BranchBankMap::where('bank_id',$bank_id)->where('status',1)->pluck('branch_id')->toArray();
            $branch_ids = array_unique($branch_ids);
            $clients->whereIn('branch_id',$branch_ids);
        }
        $clients = $clients->get();
        return view('backend.client.view', compact('clients'));
    }

    //---- Client Add ----//
    public function add(){
        $multiBranch = Branch::checkMultiBranchUser();
        $branches = Branch::getMultiBranchData();
        return view('backend.client.add', compact('multiBranch','branches'));
    }

    //---- Client Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
            'exchange_id'    => 'required',
            'opening_balance'   => 'required'
        ]);
        // Insert Data
        $user = Auth::user();
        $insertData = new Client;
        $insertData->name = $request->name;
        $insertData->exchange_id = $request->exchange_id;
        $insertData->mobile = $request->mobile;
        $insertData->initial_balance = $request->opening_balance;
        $insertData->opening_balance = $request->opening_balance;
        $insertData->remark = $request->remark;
        $insertData->branch_id = $request->branch_id;
        $insertData->created_by = $user->id;

        DB::transaction(function() use($request,$insertData) {
            if($insertData->save()) {
                foreach ($request->bank as $key => $banks) {
                    $is_primary = $request->is_primary == $key+1 ? 1 : 0;
                    if($request->bank[$key] || $request->account_number[$key] || $request->ifsc_code[$key] || $request->upi[$key]){
                        $clientBankMap = new ClientBankMap();
                        $clientBankMap->client_id = $insertData->id;
                        $clientBankMap->bank = $request->bank[$key];
                        $clientBankMap->account_number = $request->account_number[$key];
                        $clientBankMap->ifsc_code = $request->ifsc_code[$key];
                        $clientBankMap->upi = $request->upi[$key];
                        $clientBankMap->is_primary = $is_primary;
                        $clientBankMap->save();
                    }
                }
            }
        });    
      // Redirect 
      return redirect()->route('client.view')->with('success', 'Client Added Successfully');
    }

    //---- Client Edit ----//
    public function edit($id){
        $clientEdit = Client::find($id);
        $branches = Branch::getMultiBranchEditData();
        $exchanges = BranchBankMap::select('banks.*')
                    ->join('banks','branch_bank_map.bank_id','banks.id')
                    ->where('banks.account_type_id',1)
                    ->where('branch_bank_map.status',1)
                    ->where('branch_bank_map.branch_id',$clientEdit->branch_id)
                    ->where('banks.status',1)
                    ->orWhere('banks.id',$clientEdit->exchange_id)
                    ->groupby('banks.id')
                    ->get();
        $banks = Bank::where('account_type_id',2)->get();        
        $clientBankMaps = ClientBankMap::where('client_id',$id)->where('status',1)->get();
        $countClientBankMap = count($clientBankMaps);
        return view('backend.client.edit', compact('clientEdit','clientBankMaps','countClientBankMap','exchanges','banks','branches'));
    }

    //---- Client Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'  => 'required',
            'exchange_id'    => 'required',
            'opening_balance'   => 'required'
        ]);
        // Update
        $user = Auth::user();
        $updateData = Client::find($id);
        $updateData->name = $request->name;
        $updateData->exchange_id = $request->exchange_id;
        $updateData->mobile = $request->mobile;
        $updateData->initial_balance = $request->opening_balance;
        $updateData->remark = $request->remark;
        $updateData->branch_id = $request->branch_id;
        $updateData->updated_by = $user->id;

        DB::transaction(function() use($request,$updateData) {
            if($updateData->save()) {
                ClientBankMap::where('client_id',$updateData->id)->delete();
                foreach ($request->bank as $key => $banks) {
                    $is_primary = $request->is_primary == $key+1 ? 1 : 0;
                    if($request->bank[$key] || $request->account_number[$key] || $request->ifsc_code[$key] || $request->upi[$key]){
                        $clientBankMap = new ClientBankMap();
                        $clientBankMap->client_id = $updateData->id;
                        $clientBankMap->bank = $request->bank[$key];
                        $clientBankMap->account_number = $request->account_number[$key];
                        $clientBankMap->ifsc_code = $request->ifsc_code[$key];
                        $clientBankMap->upi = $request->upi[$key];
                        $clientBankMap->is_primary = $is_primary;
                        $clientBankMap->save();
                    }
                }
            }
        });
        // Redirect 
      return redirect()->route('client.view')->with('success', 'Client Updated Successfully');
    }

     //---- Client Delete ----//
    public function delete($id){
        // Delete
        $deleteData = Client::find($id);
        $deleteData->status = 0;
        $deleteData->save();
        // Redirect 
      return redirect()->route('client.view')->with('error', 'Client Deleted Successfully');
    }

    //---- Get bank details ----//
    public function exchangeDetailsFromId(Request $request){
        $data = Client::select('banks.id','banks.name','clients.branch_id')
                ->join('banks','clients.exchange_id','banks.id')
                ->where('clients.id', $request->id)
                ->where('clients.status',1)
                ->first();
        $bank_data = Bank::find($data->id);
        $data->opening_balance = $bank_data->branchBanks->where('branch_id',$data->branch_id)->sum('opening_balance');
        return $data;
    }

    //---- Client Branch admin View ----//
    public function branchView(){
        $branchId = Branch::checkMultiBranchUser();
        $clients = Client::with('exchange','getTotalWithdrawals','getTotalDeposits')->where('status',1);
        $funds = Fund::with('bank','fromBank')->where('status',1);
        if($branchId){
            $clients->where('branch_id', $branchId);
            $funds->where('branch_id', $branchId);
        }
        $clients = $clients->get();
        $funds = $funds->get();
        $bank_id = BranchBankMap::select('banks.id','banks.name','branch_bank_map.opening_balance','banks.opening_balance as opening_balances','banks.account_type_id')
                ->join('banks','branch_bank_map.bank_id','banks.id')
                ->where('branch_bank_map.branch_id', Auth::user()->branch_id)
                ->where('banks.status',1)
                ->where('branch_bank_map.status',1)->pluck('id')->toArray();
        $physicalBanks = Bank::with('branchBankHasOne')->whereIn('id',$bank_id)->where('account_type_id',2)->where('status',1);
        $virtualBanks = Bank::with('branchBanks')->whereIn('id',$bank_id)->where('account_type_id',1)->where('status',1);
        
        $physicalBanks = $physicalBanks->get();
        $virtualBanks = $virtualBanks->get();

        $banks = Bank::where('status',1)->whereIn('id',$bank_id)->get();
        // dd($clients[0]->getTotalWithdrawals->sum('amount'));
        // $withdrawal = Withdrawal::where('client_id',)->where('status',1)
        return view('backend.client.branchView', compact('clients','funds','banks','physicalBanks','virtualBanks'));
    }

    //---- Client User admin View ----//
    public function userView(){
        $branchId = Branch::checkMultiBranchUser();
        $clients = Client::with('exchange')->where('status',1);
        if($branchId){
            $clients->where('branch_id', $branchId);
        }
        $clients = $clients->get();
        return view('backend.client.userView', compact('clients'));
    }

    //---- Client Details ----//
    public function clientDetails($id){
        $client = Client::find($id);
        $withdrawals = Withdrawal::where('client_id',$id)->get();
        $deposits = Deposit::where('client_id',$id)->get();
        return view('backend.client.clientDetails', compact('client','withdrawals','deposits'));
    }

    public function getClientFromBranch(Request $request){
        $clients = Client::where('status',1)->where('branch_id', $request->id)->get();
        $html = '<option value="">Select</option>';
        foreach($clients as $client){
            $html .= '<option value="'.$client->id.'" current_balance = "'.$client->opening_balance.'" >'.$client->name.'(Current Balance:'.$client->opening_balance.')</option>';
        }
        return $html;
    }

    public function checkClientExchange(Request $request){
        $count = Client::where('exchange_id',$request->exchange_id)->where('name',$request->name)->count();
        if($count){
            return "false";
        }
        return "true";
    }

}
