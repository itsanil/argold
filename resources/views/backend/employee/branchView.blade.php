@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
DashBoard
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('client.add') }}">Add New Client</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
{{--
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <!-- <br> -->
    <div class="card-body">
        <table id="customDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
          <thead>
            <tr>
              <th>Client Id</th>
              <th>Exchange</th>
              <th>Mobile</th>
               <th>Balance</th> 
              <!--<th>Status</th>-->
            </tr>
          </thead>
          <tbody>
            @foreach($clients as $client)
            @php($withdrawalSum=$client->getTotalWithdrawals->sum('amount'))
            @php($depositSum=$client->getTotalDeposits->sum('amount'))
            @php($balance=$depositSum-$withdrawalSum)
              <tr>
                <td><a href="{{route('client.clientDetails',$client->id)}}">{{ $client->name }}</a></td>
                <td>{{ $client->exchange->name }}</td>
                <td>{{ $client->mobile }}</td>
                 <td>{{ $client->opening_balance }}</td> 
                <!--@if($withdrawalSum >  $depositSum)-->
                <!--<td><span style="color:green;">{{$balance}}</span></td>-->
                <!--@else-->
                <!--<td><span style="color: red;">{{$balance}}</span></td>-->
                <!--@endif-->
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
  </div>
  <!-- /.modal-dialog -->
</section>
--}}
<div class="card card-primary card-outline card-outline-tabs">
  
  <div class="card-body">
     <div class="row">
      <!-- PHYSICAL BANK -->
        <div class="col-md-6">
            <center>
                <h4>Physical Bank</h4>
            </center>
            <hr/>
            <table id="physicalBankDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Account Number</th>
                  <th>IFSC Code</th>
                  <th>Total Balance</th>
                  <th>Transaction Code</th>
                  <th>Remark</th>
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
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="6">Total:</th>
                </tr>
              </tfoot>
            </table>
        </div>
        
        <!-- VIRTUAL BANK -->
        <div class="col-md-6">
            <center>
                <h4>Virtual Bank</h4>
            </center>
            <hr/>
           <table id="virtualBankDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Bonus</th>
                  <!--<th>IFSC Code</th>-->
                  <th>Branch Balance</th>
                  <!--<th>Transaction Code</th>-->
                  <th>Remark</th>
                </tr>
              </thead>
              <tbody>
                @foreach($virtualBanks as $bank)
                   @php($totalBalance = $bank->branchBanks->sum('opening_balance'))
                  <tr>
                    <td>{{ $bank->name }}</td>
                    <td>{{ $bank->bonus(Auth::user()->branch_id) }}</td>
                    <!--<td>{{ $bank->account_number }}</td>-->
                    <!--<td>{{ $bank->ifsc_code }}</td>-->
                    <td>{{ $totalBalance }}</td>
                    <!--<td>{{ $bank->transaction_code }}</td>-->
                    <td>{{ $bank->remark }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Total:</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
        </div>
     </div>
  </div>
</div>
<!-- FUNDS -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Funds</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
@include('backend.fund.fund_index_section')

@endsection
@section('js')
@include('backend.includes.datatablesJS')
<script type="text/javascript">
  $('#customDataTable').DataTable({
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

    $('#approvedFundDataTable').DataTable({
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": false,
       "responsive": true,
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
   
   $('#rejectedFundDataTable').DataTable({
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": false,
       "responsive": true,
   });

    var physicalBankDataTable = $('#physicalBankDataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    var total = physicalBankDataTable
      .column(3) // Index of the Amount column (0-based)
      .data()
      .reduce(function (acc, val) {
        return acc + parseFloat(val);
      }, 0);

    // Update the footer cell with the total
    physicalBankDataTable
      .column(0) // Index of the Amount column (0-based)
      .footer()
      .innerHTML = 'Total: ' + total;

    var virtualBankDataTable = $('#virtualBankDataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    var bonus_total = virtualBankDataTable
      .column(1) // Index of the Amount column (0-based)
      .data()
      .reduce(function (acc, val) {
        return acc + parseFloat(val);
      }, 0);

    var bonustotal = virtualBankDataTable
      .column(2) // Index of the Amount column (0-based)
      .data()
      .reduce(function (acc, val) {
        return acc + parseFloat(val);
      }, 0);

    // Update the footer cell with the total
    virtualBankDataTable
      .column(1) // Index of the Amount column (0-based)
      .footer()
      .innerHTML =  bonus_total;

    virtualBankDataTable
      .column(2) // Index of the Amount column (0-based)
      .footer()
      .innerHTML =  bonustotal;

</script>
@endsection