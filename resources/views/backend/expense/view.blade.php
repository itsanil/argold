@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Expenses
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('expense.add') }}">Add New Expense</a>
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
              <th>Bank</th>
              <th>Category</th>
              <th>Amount</th>
              <th>Transaction Date</th>
              <th>Remark</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenses as $expense)
              <tr>
                <td>{{ $expense->branch->branch_number }}</td>
                <td>{{ $expense->bank->name }}</td>
                <td>{{ $expense->category->name }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ date('d-m-Y',strtotime($expense->date)) }}</td>
                <td>{{ $expense->remark }}</td>
                <td>
                  @can('expense-update')
                  <a class="btn btn-secondary btn-sm" href="{{ route('expense.edit', $expense->id) }}">Edit</a>
                  @endcan
                  @can('expense-delete')
                  <a class="btn btn-danger btn-sm"  href="{{ route('expense.delete', $expense->id) }}">Delete</a>
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