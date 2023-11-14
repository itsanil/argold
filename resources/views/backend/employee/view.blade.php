@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Employee
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('employee.add') }}">Add New Employee</a>
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
              <th>EmployeeID</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Salary</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $client)
              <tr>
                <td>{{ $client->employeeidno }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->contact1 }}/{{ $client->contact2 }}</td>
                <td>{{ $client->salary }}</td>
                <td>
                  <a class="btn btn-secondary btn-sm" href="{{ route('employee.edit', $client->id) }}">Edit</a>
                  <a class="btn btn-success btn-sm"  href="{{ route('employee-salary.view', $client->id) }}">
                    <i class="nav-icon fas fa-dollar-sign" area-hidden="true"></i>
                  Salary</a>
                  <!-- <a class="btn btn-danger btn-sm"  href="{{ route('employee.delete', $client->id) }}">Delete</a> -->
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