@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Banks
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('bank.add') }}">Add New Bank</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
   <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 pt-1">
         <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Physical Bank</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="custom-tabs-one-reject-tab" data-toggle="pill" href="#custom-tabs-one-reject" role="tab" aria-controls="custom-tabs-one-reject" aria-selected="true">Virtual Bank</a>
            </li>
         </ul>
      </div>
      <div class="card-body">
         <div class="tab-content" id="custom-tabs-one-tabContent">

          <!-- PHYSICAL BANK -->
            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                <table id="physicalBankDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Account Number</th>
                      <th>IFSC Code</th>
                      <th>Total Balance</th>
                      <th>Transaction Code</th>
                      <th>Remark</th>
                      <th width="20%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($physicalBanks as $bank)
                     @php($totalBalance = isset($bank->branchBankHasOne->opening_balance) == 0 ? $bank->opening_balance : $bank->branchBankHasOne->opening_balance)
                      <tr>
                        <td>{{ $bank->name }}</td>
                        <td>{{ $bank->account_number }}</td>
                        <td>{{ $bank->ifsc_code }}</td>
                        <td>{{ $totalBalance }}</td>
                        <td>{{ $bank->transaction_code }}</td>
                        <td>{{ $bank->remark }}</td>
                        <td>
                        <a class="btn btn-secondary btn-sm" href="{{ route('bank.show', $bank->id) }}"><i class="fa fa-eye"></i></a>
                          <a class="btn btn-success btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default1{{$bank->id}}">Add Fund
                          <i class="fa fa-plus"></i></a>
                          @can('bank-update')
                          <a class="btn btn-secondary btn-sm" href="{{ route('bank.edit', $bank->id) }}">Edit</a>
                          @endcan
                          @can('bank-delete')
                          <a class="btn btn-danger btn-sm @if($bank->branchBankHasOne()->count() > 0) disabled @endif"  href="{{ route('bank.delete', $bank->id) }}">Delete</a>
                          @endcan
                          <!--<a class="btn btn-info btn-sm" href="{{ route('client.view', $bank->id) }}">Client-->
                          <!--<i class="fa fa-users"></i></a>-->
                       </td>
                       <div class="modal fade" id="modal-default1{{$bank->id}}">
                          <!-- /.modal-dialog -->
                          <div class="modal-dialog">
                             <!-- /.modal-content -->
                             <form action="{{route('fund.addFund')}}"  method="post">
                               @csrf
                                <input type="hidden" name="bank_id" id="bank_id" value="{{$bank->id}}">
                                <div class="modal-content">
                                   <div class="modal-header">
                                      <h4 class="modal-title">Add Master Fund</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                   </div>
                                   <div class="modal-body" >
                                      <div class="form-group row" >
                                        <div class="col-sm-4">
                                          <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Amount&nbsp;&nbsp; :- </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
                                            <span class="help-block amount_error" id="amount_error" style="color: red"></span>
                                         </div>
                                      </div>
                                      <div class="form-group row" >
                                        <div class="col-sm-4">
                                          <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Remark&nbsp;&nbsp; :- </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <textarea name="remark" class="form-control" id="remark" placeholder="Enter Remark">
                                            </textarea>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success" >Submit</button>
                                   </div>
                                </div>
                             </form>
                             <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                       </div>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            
            <!-- VIRTUAL BANK -->
            <div class="tab-pane fade" id="custom-tabs-one-reject" role="tabpanel" aria-labelledby="custom-tabs-one-reject-tab">
               <table id="virtualBankDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Account Number</th>
                      <th>IFSC Code</th>
                      <th>Branch Balance</th>
                      <th>Master Balance</th>
                      <th>Total Balance</th>
                      <th>Transaction Code</th>
                      <th>Remark</th>
                      <th width="20%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($virtualBanks as $bank)
                       @php($totalBalance = $bank->branchBanks->sum('opening_balance'))
                      <tr>
                        <td>{{ $bank->name }}</td>
                        <td>{{ $bank->account_number }}</td>
                        <td>{{ $bank->ifsc_code }}</td>
                        <td>{{ $totalBalance }}</td>
                        <td>{{ $bank->current_balance }}</td>
                        <td>{{ $bank->current_balance + $totalBalance}}</td>
                        <td>{{ $bank->transaction_code }}</td>
                        <td>{{ $bank->remark }}</td>
                        <td>
                            <a class="btn btn-secondary btn-sm" href="{{ route('bank.show', $bank->id) }}"><i class="fa fa-eye"></i></a>
                          <a class="btn btn-success btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default1{{$bank->id}}">Add Fund <i class="fa fa-plus"></i></a>
                          @can('bank-update')
                          <a class="btn btn-secondary btn-sm" href="{{ route('bank.edit', $bank->id) }}">Edit</a>
                          @endcan
                          @can('bank-delete')
                          <a class="btn btn-danger btn-sm @if($bank->branchBankHasOne()->count() > 0) disabled @endif"  href="{{ route('bank.delete', $bank->id) }}">Delete</a>
                          @endcan
                          <!--<a class="btn btn-info btn-sm" href="{{ route('client.view', $bank->id) }}">Client-->
                          <!--<i class="fa fa-users"></i></a>-->
                       </td>
                       <div class="modal fade" id="modal-default1{{$bank->id}}">
                          <!-- /.modal-dialog -->
                          <div class="modal-dialog">
                             <!-- /.modal-content -->
                             <form action="{{route('fund.addFund')}}"  method="post">
                               @csrf
                                <input type="hidden" name="bank_id" id="bank_id" value="{{$bank->id}}">
                                <div class="modal-content">
                                   <div class="modal-header">
                                      <h4 class="modal-title">Add Master Fund</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                   </div>
                                   <div class="modal-body" >
                                      <div class="form-group row" >
                                        <div class="col-sm-4">
                                          <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Amount&nbsp;&nbsp; :- </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
                                            <span class="help-block amount_error" id="amount_error" style="color: red"></span>
                                         </div>
                                      </div>
                                      <div class="form-group row" >
                                        <div class="col-sm-4">
                                          <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Remark&nbsp;&nbsp; :- </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <textarea name="remark" class="form-control" id="remark" placeholder="Enter Remark">
                                            </textarea>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success" >Submit</button>
                                   </div>
                                </div>
                             </form>
                             <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                       </div>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
         </div>
      </div>
    </div>
      <!-- /.card -->
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
@include('backend.includes.datatablesJS')
<script type="text/javascript">
  $('#physicalBankDataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
        // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>'
        //    +'<"row"<"col-sm-12"tr>>' +
        //    '<"row"<"col-sm-4"i><"col-sm-8"p>>',
        //   buttons: [
        //     {
        //     extend: 'excel',
        //     className: "btn btn-success fas fa-file-excel",
        //     title:'Branches',
        //     exportOptions: {
        //     columns: ':not(:last-child)',
        //       modifier: {
        //           search: 'applied',
        //           order: 'applied'  
        //       },
        //     }
        //     },
        //     {
        //        extend: 'pdf',
        //        className: "btn btn-secondary fas fa-file-pdf",
        //        title:'Branches',
        //        exportOptions: {
        //         modifier: {
        //             search: 'applied',
        //             order: 'applied'  
        //         },
        //        },
        //     }
        //  ],
    });

  $('#virtualBankDataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

</script>
@endsection