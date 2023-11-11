@extends('backend.master-layouts.main')
@section('contentHeader')
View Bank Details {{ $bank_data->name }}
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('bank.view') }}">View All Banks</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
   <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 pt-1">
          {{--
         <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="deposit-tab" data-toggle="pill" href="#deposit" role="tab" aria-controls="deposit" aria-selected="true">Deposit</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="withdrawal-tab" data-toggle="pill" href="#withdrawal" role="tab" aria-controls="withdrawal" aria-selected="true">Withdrawals</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="request-funds-tab" data-toggle="pill" href="#request-funds" role="tab" aria-controls="request-funds" aria-selected="true">Fund</a>
            </li>
         </ul>
         --}}
      </div>
      <div class="card-body">
         <center>
             <h2>Deposit</h2>
         </center>
         <hr/>
        <table id="customDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                <thead>
                  <tr>
                    <th></th>
                    <th>Branch</th>
                    <th>Client Id</th>
                    <th>Exchange</th>
                    <th>Amount</th>
                    <th>Win Amt</th>
                    <th>Date</th>
                    <th>Bank</th>
                    <th>Bonus(%)</th>
                    <th>UTR</th>
                    <th>Mode</th>
                    <th>Remark</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
        <hr/>
        <center>
             <h2>Withdraw</h2>
         </center>
         <hr/>     
        <table id="customDataTable1"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
            <thead>
              <tr>
                <th></th>
                <th>Branch</th>
                <th>Client Id</th>
                <th>Exchange</th>
                <th>Amount</th>
                <th>Exchange Amt</th>
                <th>Date</th>
                <th>Bank</th>
                <th>UTR</th>
                <th>Mode</th>
                <th>Remark</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        <hr/>
        <center>
             <h2>Direct Deposit Fund</h2>
         </center>
         <hr/>     
        <table id="directFundDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
                  <thead>
                     <tr>
                        <th>Bank</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                        <th>Type</th>
                        <th>Remark</th>
                        <!-- <th>Action</th> -->
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($dfunds as $fund)
                     <!-- @if($fund->payment_type == 'Deposit') -->
                     <tr>
                        <td>{{ $fund->bank->name }}</td>
                        <td>{{ $fund->amount }}</td>
                        <td>{{ date('d-m-Y h:m:s A',strtotime($fund->transaction_date)) }}</td>
                        <td>{{ $fund->payment_type }}</td>
                        <td>{{ $fund->remark }}</td>
                       <!--  <td>
                           @can('fund-update')
                           <a class="btn btn-secondary btn-sm" href="{{ route('fund.edit', $fund->id) }}">Edit</a>
                           @endcan
                           @can('fund-delete')
                           <a class="btn btn-danger btn-sm"  href="{{ route('fund.delete', $fund->id) }}">Delete</a>
                           @endcan
                        </td> -->
                     </tr>
                     <!-- @endif -->
                     @endforeach
                  </tbody>
          </table>
        <hr/>
        <center>
             <h2>Funds Request</h2>
        </center>
        <hr/>        
        @include('backend.fund.fund_index_section')
         <div class="tab-content" id="custom-tabs-one-tabContent">

          <!-- PHYSICAL BANK -->
            <div class="tab-pane fade show active" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                
            </div>
            
            <!-- VIRTUAL BANK -->
            <div class="tab-pane fade" id="withdrawal" role="tabpanel" aria-labelledby="withdrawal-tab">
               
            </div>

            <div class="tab-pane fade" id="request-funds" role="tabpanel" aria-labelledby="request-funds-tab">
                
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
  var url = "{{ route('deposit.fetchDepositList') }}?bank_id={{ $bank_data->id }}";
  $('#customDataTable').DataTable({
      processing: true,
      serverSide: true,
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      ajax: url,
         columns: [
           {
             data: 'id',
             name: 'id',
             visible: false,
             searchable: false,
           },
           {
             data: 'branch.branch_number',
             name: 'branch.branch_number',
           }, 
           {
             data: 'client_name',
             name: 'client_name',
           }, 
           {
             data: 'exchange.name',
             name: 'exchange.name',
           },
           {
             data: 'amount',
             name: 'amount',
           },{
             data: 'win_amt',
             name: 'win_amt',
           },{
             data: 'date',
             name: 'date',
           },
           {
             data: 'bank_name',
             name: 'bank_name',
           },
          {
             data: 'bonus_percent',
             name: 'bonus_percent',
           },
           {
             data: 'utr',
             name: 'utr',
           },
           {
             data: 'mode_name',
             name: 'mode_name',
           },
           {
             data: 'remark',
             name: 'remark',
           },
           {
             data: 'action',
             name: 'action',
             orderable: false,
             searchable: false,
             width: 100
           },
         ],
         order:[0,'desc'],
    });

</script>
<script type="text/javascript">
  var url = "{{ route('withdrawal.fetchWithdrawalList') }}?bank_id={{ $bank_data->id }}";
// table.settings()[0].jqXHR.abort();

  var table = $('#customDataTable1').DataTable({
      processing: true,
      serverSide: true,
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      ajax: {
        url:url,
        type:"GET",
      },
         columns: [
           {
             data: 'id',
             name: 'id',
             visible: false,
             searchable: false,
           },
           {
             data: 'branch.branch_number',
             name: 'branch.branch_number',
           }, 
           {
             data: 'client_name',
             name: 'client_name',
           }, 
           {
             data: 'exchange.name',
             name: 'exchange.name',
           },
           {
             data: 'amount',
             name: 'amount',
           },{
             data: 'exchange_amt',
             name: 'exchange_amt',
           },{
             data: 'date',
             name: 'date',
           },
           {
             data: 'bank_name',
             name: 'bank_name',
           },
           {
             data: 'utr',
             name: 'utr',
           },
           {
             data: 'mode_name',
             name: 'mode_name',
           },
           {
             data: 'remark',
             name: 'remark',
           },
           {
             data: 'action',
             name: 'action',
             orderable: false,
             searchable: false,
             width: 100
           },
         ],
         order:[0,'desc'],
    });
</script>
<script type="text/javascript">
   $('#approvedFundDataTable').DataTable({
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

   $('#pendingFundDataTable').DataTable({
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": false,
       "responsive": true,
   });

   $('#rejectedFundDataTable,#directFundDataTable').DataTable({
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