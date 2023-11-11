@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Clients
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('client.add') }}">Add New Client</a>
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
              <th>Branch</th>
              <th>Client Id</th>
              <th>Exchange</th>
              <th>Mobile</th>
              <th>Opening Balance</th>
              <th>Current Balance</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clients as $client)
              <tr>
                <td>{{ $client->branch->branch_number }}</td>
                <td><a href="{{route('client.clientDetails',$client->id)}}">{{ $client->name }}</a></td>
                <td>{{ $client->exchange->name }}</td>
                <td>{{ $client->mobile }}</td>
                <td>{{ $client->initial_balance }}</td>
                <td>{{ $client->opening_balance }}</td>
                <td>
                  @can('client-update')
                  <a class="btn btn-secondary btn-sm" href="{{ route('client.edit', $client->id) }}">Edit</a>
                  @endcan
                  @can('client-delete')
                  <a class="btn btn-danger btn-sm @if($client->getTotalWithdrawals()->count() > 0 || $client->getTotalDeposits()->count() > 0 ) disabled @endif"  href="{{ route('client.delete', $client->id) }}">Delete</a>
                  @endcan
               </td>
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

</script>
@endsection