@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Client Details ( <b style="color:blue">{{ $client->name }}</b style="color:blue"> )
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <!-- <br> -->
    <div class="card-body">
        <div class="row"> 
          <?php 
              $net = $client->opening_balance - $client->initial_balance;
          ?>
          <div class="col-sm-4">
            <label>
              Client Balance: <span style="color:green">{{ $client->opening_balance }}</span>
            </label>
          </div>
          <div class="col-sm-4">
            <label>
              Swamiji Profit / Loss <span @if($net < 0) style="color:red" @else style="color:green" @endif>{{ $net }}</span>
            </label>
          </div>
          <div class="col-sm-4">
            <label>
              Status: 
                @if($net > 0)
                <span style="color:green">Profit
                @else
                <span style="color:red">Loss
                @endif
              </span>
            </label>
          </div>
        </div>
        <table id="customDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
          <thead>
            <tr>
              <th>Exchange</th>
              <th>Amount</th>
              <th>Exchange Amt</th>
              <th>Bonus(%)</th>
              <th>Date</th>
              <th>Bank</th>
              <th>UTR</th>
              <th>Mode</th>
              <th>Remark</th>
              <th>Type</th>
              
            </tr>
          </thead>
          <tbody>
          @foreach($withdrawals as $withdrawal)
              <tr>
                <td>{{ $withdrawal->exchange->name }}</td>
                <td>{{ $withdrawal->amount }}</td>
                <td>{{ $withdrawal->exchange_amt }}</td>
                <td>NA</td>
                <td>{{ date('d-m-Y',strtotime($withdrawal->date)) }}</td>
                <td>@if($withdrawal->bank){{ $withdrawal->bank->name }}@endif</td>
                <td>{{ $withdrawal->utr }}</td>
                <td>@if($withdrawal->mode){{ $withdrawal->mode->name }}@endif</td>
                <td>{{ $withdrawal->remark }}</td>
                <td style="color:red">Withdrawal</td>
              </tr>
            @endforeach
            @foreach($deposits as $deposit)
              <tr>
                <td>{{ $deposit->exchange->name }}</td>
                <td>{{ $deposit->amount }}</td>
                <td>NA</td>
                <td>{{intval($deposit->amount*$deposit->bonus_percent/100).'Rs/- ('.$deposit->bonus_percent.'%)'}}</td>
                <td>{{ date('d-m-Y',strtotime($deposit->date)) }}</td>
                <td>@if($deposit->bank){{ $deposit->bank->name }}@endif</td>
                <td>{{ $deposit->utr }}</td>
                <td>@if($deposit->mode){{ $deposit->mode->name }}@endif</td>
                <td>{{ $deposit->remark }}</td>
                <td style="color:green">Deposit</td>
              </tr>
            @endforeach  
          </tbody>
        </table>
    </div>
  </div>
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
@include('backend.includes.datatablesJS')
<script type="text/javascript">
  var url = "{{ route('deposit.fetchDepositList') }}";
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
        //         columns: ':not(:last-child)',
        //         modifier: {
        //             search: 'applied',
        //             order: 'applied'  
        //         },
        //        },
        //     }
        //  ],

        
    });

</script>
@endsection