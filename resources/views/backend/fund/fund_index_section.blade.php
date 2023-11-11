<section class="content">
   <!-- Default box -->
   <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 pt-1">
         <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Approved
               <span class="badge bg-success">{{$funds->where('approved',1)->count()}}</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="custom-tabs-one-reject-tab" data-toggle="pill" href="#custom-tabs-one-reject" role="tab" aria-controls="custom-tabs-one-reject" aria-selected="true">Rejected
               <span class="badge bg-danger">{{$funds->where('approved',2)->count()}}</span>
            </a>
               
            </li>
            <li class="nav-item">
               <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Pending
               <span class="badge bg-info">{{$funds->where('approved',0)->count()}}</span>
            </a>
            </li>
         </ul>
      </div>
      <div class="card-body">
         <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
               <table id="approvedFundDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                  <thead>
                     <tr>
                        <th>Branch</th>
                        <th>Bank</th>
                        <th>From Bank</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                        <th>Type</th>
                        <th>Reference Id</th>
                        <th>Remark</th>
                        <th>Admin Remark</th>
                        <!-- <th>Action</th> -->
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($funds as $fund)
                     @if($fund->approved == 1)
                     <tr>
                        <td>{{ $fund->branch->branch_number }}</td>
                        <td>{{ $fund->bank->name }}</td>
                        <td>@if($fund->fromBank){{ $fund->fromBank->name }}@endif</td>
                        <td>{{ $fund->amount }}</td>
                        <td>{{ date('d-m-Y h:m:s A',strtotime($fund->transaction_date)) }}</td>
                        <td>{{ $fund->payment_type }}</td>
                        <td>{{ $fund->reference_id }}</td>
                        <td>{{ $fund->remark }}</td>
                        <td>{{ $fund->admin_reason }}</td>
                       <!--  <td>
                           @can('fund-update')
                           <a class="btn btn-secondary btn-sm" href="{{ route('fund.edit', $fund->id) }}">Edit</a>
                           @endcan
                           @can('fund-delete')
                           <a class="btn btn-danger btn-sm"  href="{{ route('fund.delete', $fund->id) }}">Delete</a>
                           @endcan
                        </td> -->
                     </tr>
                     @endif
                     @endforeach
                  </tbody>
               </table>
            </div>
            
            <!-- REJECT -->
            <div class="tab-pane fade" id="custom-tabs-one-reject" role="tabpanel" aria-labelledby="custom-tabs-one-reject-tab">
               <table id="rejectedFundDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                  <thead>
                     <tr>
                        <th>Branch</th>
                        <th>Bank</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                        <th>Type</th>
                        <th>Reference Id</th>
                        <th>Remark</th>
                        <th>Admin Remark</th>
                        <!-- <th>Action</th> -->
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($funds as $fund)
                     @if($fund->approved == 2)
                     <tr>
                        <td>{{ $fund->branch->branch_number }}</td>
                        <td>{{ $fund->bank->name }}</td>
                        <td>{{ $fund->amount }}</td>
                        <td>{{ date('d-m-Y',strtotime($fund->transaction_date)) }}</td>
                        <td>{{ $fund->payment_type }}</td>
                        <td>{{ $fund->reference_id }}</td>
                        <td>{{ $fund->remark }}</td>
                        <td>{{ $fund->admin_reason }}</td>
                        <!-- <td>
                           @can('fund-update')
                           <a class="btn btn-secondary btn-sm" href="{{ route('fund.edit', $fund->id) }}">Edit</a>
                           @endcan
                           @can('fund-delete')
                           <a class="btn btn-danger btn-sm"  href="{{ route('fund.delete', $fund->id) }}">Delete</a>
                           @endcan
                        </td> -->
                     </tr>
                     @endif
                     @endforeach
                  </tbody>
               </table>
            </div>

            <!-- PENDING -->
            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
               <table id="pendingFundDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                  <thead>
                     <tr>
                        <th>Branch</th>
                        <th>Bank</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                        <th>Type</th>
                        <th>Reference Id</th>
                        <th>Remark</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($funds as $fund)
                     @if($fund->approved == 0)
                     <tr>
                        <td>{{ $fund->branch->branch_number }}</td>
                        <td>{{ $fund->bank->name }}</td>
                        <td>{{ $fund->amount }}</td>
                        <td>{{ date('d-m-Y',strtotime($fund->transaction_date)) }}</td>
                        <td>{{ $fund->payment_type }}</td>
                        <td>{{ $fund->reference_id }}</td>
                        <td>{{ $fund->remark }}</td>
                        <td>
                           @can('fund-approve')
                           <!-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approval">Approve</button> -->
                           <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reject">Reject</button> -->
                           <a class="btn btn-success btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default1{{$fund->id}}">Approve</a>
                           <!-- <a class="btn btn-success btn-sm" href="#">Approve</a> -->
                           <!-- <a class="btn btn-success btn-sm" href="{{ route('fund.approve', [$fund->id,'approve']) }}">Approve</a> -->
                           <a class="btn btn-primary btn-sm" href="{{ route('fund.approve', [$fund->id,'reject']) }}">Reject</a>
                           @endcan
                           @can('fund-update')
                           <a class="btn btn-secondary btn-sm" href="{{ route('fund.edit', $fund->id) }}">Edit</a>
                           @endcan
                           @can('fund-delete')
                           <a class="btn btn-danger btn-sm"  href="{{ route('fund.delete', $fund->id) }}">Delete</a>
                           @endcan
                        </td>
                        <!-- /.modal-dialog -->
                        <div class="modal fade" id="modal-default1{{$fund->id}}">
                            <!-- /.modal-dialog -->
                            <div class="modal-dialog">
                               <!-- /.modal-content -->
                               <form action="{{route('fund.approve-fund')}}"  method="post">
                                 @csrf
                                  <input type="hidden" name="fund" id="fund" value="{{$fund->id}}">
                                  <div class="modal-content">
                                     <div class="modal-header">
                                        <h4 class="modal-title">Approve Fund</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                     </div>
                                     <div class="modal-body" >
                                       <div class="form-group row" >
                                          <div class="col-sm-4">
                                            <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Select Bank&nbsp;&nbsp; :- </label>
                                          </div>
                                          <div class="col-sm-8">
                                              <select class="form-control select2 bank" id="bank" name="bank_id">
                                                 <option value="">Select</option>
                                                 {{--
                                                 <!-- @foreach($fund->branch->branchBanks as $bank) -->
                                                 --}}
                                                 @foreach($banks as $bank)
                                                   <option value="{{ $bank->id }}" @if($bank->id == $fund->bank_id) selected @endif  >{{ $bank->name }} (Balance:{{ $bank->balance }})</option>
                                                 @endforeach
                                               </select>
                                              <span class="help-block amount_error" id="amount_error" style="color: red"></span>
                                           </div>
                                        </div>
                                        <div class="form-group row" >
                                          <div class="col-sm-4">
                                            <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Remark&nbsp;&nbsp; :- </label>
                                          </div>
                                          <div class="col-sm-8">
                                              <textarea  class="form-control" name="remark" placeholder="Enter Remark"></textarea>
                                              <span class="help-block amount_error" id="amount_error" style="color: red"></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" >Approve</button>
                                     </div>
                                  </div>
                               </form>
                               <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                         </div>
                     </tr>
                     @endif
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- /.card -->
   </div>
   <!-- /.modal-dialog -->

</section>