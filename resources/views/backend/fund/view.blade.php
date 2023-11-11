@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Funds
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('fund.add') }}">Add New Fund</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
@include('backend.fund.fund_index_section')

@endsection
@section('js')
@include('backend.includes.datatablesJS')
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

   $('#rejectedFundDataTable').DataTable({
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