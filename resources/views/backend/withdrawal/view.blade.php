@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Withdrawals
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('withdrawal.add') }}">Add New Withdrawal</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <!-- <br> -->
    <div class="card-body">
        <table id="customDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
          <thead>
            <tr>
              <th></th>
              <th>Branch</th>
              <th>Client Id</th>
              <th>Exchange</th>
              <th>Exchange Amt</th>
              <th>Amount</th>
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
    </div>
  </div>
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
@include('backend.includes.datatablesJS')
<script type="text/javascript">
  var url = "{{ route('withdrawal.fetchWithdrawalList') }}";
// table.settings()[0].jqXHR.abort();

  var table = $('#customDataTable').DataTable({
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
             searchable: false,
             orderable: false,
           }, 
           {
             data: 'client_id',
             name: 'client_id',
           }, 
           {
             data: 'exchange.name',
             name: 'exchange.name',
           },
           {
             data: 'exchange_amt',
             name: 'exchange_amt',
           },
           {
             data: 'amount',
             name: 'amount',
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
@endsection