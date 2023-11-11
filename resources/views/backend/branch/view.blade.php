@extends('backend.master-layouts.main')
@section('css')
@include('backend.includes.datatablesCSS')
@endsection
@section('contentHeader')
Branches
@endsection
@section('contentButton')
<a class="btn btn-primary btn-sm" href="{{ route('branch.add') }}">Add New Branch</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <!-- <br> -->
    <div class="card-body">
        <!-- <button class="btn btn-success btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default" style="display: none">hidden</button> -->

        <table id="customDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
          <thead>
            <tr>
              <th>Branch No</th>
              <!-- <th>Name</th> -->
              <th>Phone No</th>
              <th>Admin Name</th>
              <th>Balance</th>
              <th>Remark</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($branches as $branch)
              <tr>
                <td>{{ $branch->branch_number }}</td>
                <!-- <td>{{ $branch->name }}</td> -->
                <td>{{ $branch->phone }}</td>
                <td>{{ $branch->admin_name }}</td>
                @php($totalBalance=$branch->branchBanks->sum('opening_balance'))
                <td>{{ $totalBalance }}</td>
                <td>{{ $branch->remark }}</td>
                <td>
                  @can('branch-update')
                  <a class="btn btn-secondary btn-sm" href="{{ route('branch.edit', $branch->id) }}">Edit</a>
                  @endcan
                  @can('branch-delete')
                  <a class="btn btn-danger btn-sm"  href="{{ route('branch.delete', $branch->id) }}">Delete</a>
                  @endcan
                  <a class="btn btn-success btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default{{$branch->id}}"><i class="fa fa-plus"></i></a>
                  <!-- /.modal-dialog -->
                  <div class="modal fade modalShowHide" id="modal-default{{$branch->id}}">
                      <!-- /.modal-dialog -->
                      <div class="modal-dialog">
                         <!-- /.modal-content -->
                         <form role="form" id="forms"  method="post" action="{{ route('branch.store') }}">
                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="dye_id" id="dye_id" value="0">
                            <input type="hidden" id="count" value="">
                            <div class="modal-content">
                               <div class="modal-header">
                                  <h4 class="modal-title">Add Bank</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                               </div>
                               <div class="modal-body" >
                                  <div class="form-group row" >
                                    <div class="col-sm-6">
                                      <select class="form-control select2 bank" id="bank_id_{{$branch->id}}" name="bank_id">
                                        <option value="">Select Bank</option>
                                        @foreach($banks as $bank)
                                         @if(!in_array($bank->id, $branch->branchBankDetails->pluck('id')->all()))
                                          <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endif
                                        @endforeach
                                      </select>
                                      <span class="help-block bank_id_error" id="bank_id_error_{{$branch->id}}" style="color: red"></span>
                                    </div>
                                     <div class="col-sm-6">
                                        <input type="number" class="form-control" name="opening_balance" id="opening_balance_{{$branch->id}}" placeholder="Enter Opening balance" value="">
                                        <span class="help-block opening_balance_error" id="opening_balance_error_{{$branch->id}}" style="color: red"></span>
                                     </div>
                                  </div>
                               </div>
                               <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary" id="add_dye" onclick="save({{ $branch->id }})" >Save</button>
                               </div>
                            </div>
                         </form>
                         <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                   </div>


                   <a class="btn btn-primary btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default1{{$branch->id}}"><i class="fa fa-eye"></i></a>
                  <!-- /.modal-dialog -->
                  <div class="modal fade" id="modal-default1{{$branch->id}}">
                      <!-- /.modal-dialog -->
                      <div class="modal-dialog">
                         <!-- /.modal-content -->
                         <form >
                            <input type="hidden" name="dye_id" id="dye_id" value="0">
                            <div class="modal-content">
                               <div class="modal-header">
                                  <h4 class="modal-title">View Banks</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                               </div>
                               <div class="modal-body" >
                                @foreach($branch->branchBankDetails as $branchBank)
                                  <div class="form-group row" >
                                    <div class="col-sm-4">
                                      <label for="dye" class="col-sm-3.2 col-form-label">{{$branchBank->name}}&nbsp;&nbsp; :- </label>
                                      <input type="hidden" value="{{$branchBank->id}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" id="amount" placeholder="Enter Amount" value="{{$branchBank->opening_balance}}" readonly>
                                        <span class="help-block amount_error" id="amount_error" style="color: red"></span>
                                     </div>
                                  </div>
                                @endforeach
                                  <div class="form-group row" >
                                    <div class="col-sm-4">
                                      <label for="dye" class="col-sm-3.2 col-form-label" style="color:blue;">Total&nbsp;&nbsp; :- </label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" id="amount" placeholder="Enter Amount" value="{{$totalBalance}}" readonly style="color:blue;">
                                        <span class="help-block amount_error" id="amount_error" style="color: red"></span>
                                     </div>
                                  </div>
                               </div>
                               <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                               </div>
                            </div>
                         </form>
                         <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                   </div>
               </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
  </div>
  
</section>

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
jQuery(document).ready(function() {
  $(".bank").select2();
});

function save(id)
   {
      $(".bank_id_error").text('');
      $(".opening_balance_error").text('');
      var token = $('[name="_token"]').val();
      var bank_id = $("#bank_id_"+id).val();
      var opening_balance = $("#opening_balance_"+id).val();
      // console.log(bank_id);
      // console.log(opening_balance);
      if(!bank_id){
        $("#bank_id_error_"+id).text('This field is required');
        return false;
      }
      if(!opening_balance){
        $("#opening_balance_error_"+id).text('This field is required');
        return false;
      }
        $.ajax({
           url:"{{route('branch.addNewBank')}}",
           type:'post',
           data:{
              '_token':token,
              'id':id,
              'bank_id':bank_id,
              'bank_id':bank_id,
              'opening_balance':opening_balance
           },
           success:function (response)
           {
              if(response == 200)
              {
                $('.modalShowHide').modal('hide'); //or  $('#IDModal').modal('hide');
                location. reload()
              }else if(response == 203){
                alert('Insert at least one data.');
              }
              else
              {
                 alert('Data Was Not Inserted');
              }
           }
        });
      }

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
    // $(document).ready(function () {
    //   setTimeout(function () {
    //     // alert('Reloading Page');
    //     location.reload(true);
    //   }, 10000);
    // });
</script>
@endsection