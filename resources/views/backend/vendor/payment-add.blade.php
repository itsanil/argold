@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Vendor Payment
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('vendor.view') }}">View All vendors</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('vendor-payment.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankcity">vendor
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="select2" id="vendor_id" name="vendor_id" required>
                <option value="">Select</option>
                @foreach($vendors as $cit)
                  <option value="{{ $cit->id }}" >{{ $cit->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" name="date" class="form-control" id="date" placeholder="Enter Transaction Code" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="payment">Payment</label>
              <input type="number" name="payment" class="form-control" id="payment" placeholder="Enter Payment" >
            </div>
          </div>
        </div>
         <button type="submit" class="btn btn-primary  float-right">Submit</button>
      </form>

      
    </div>
    <hr>

      <table id="customDataTable"  class=" container-fluid table table-bordered table-striped dataTable dtr-inline table-hover" >
          <thead>
            <tr>
              <th>Vendor</th>
              <th>Date</th>
              <th>Amt</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $dat)
              <tr>
                <td>@if($dat->getVendor){{ $dat->getVendor->name }}@endif</td>
                <td>{{ $dat->date }}</td>
                <td>{{ $dat->payment }}</td>
                <td>
                 
                  <a class="btn btn-success btn-sm modal-trigger" data-toggle="modal" data-target="#modal-default{{$dat->id}}"><i class="fa fa-edit"></i></a>
                  <a class="btn btn-danger btn-sm" href="{{ route('vendor-payment.delete', $dat->id) }}"><i class="fa fa-trash"></i></a>
                  <!-- /.modal-dialog -->
                    <div class="modal fade modalShowHide" id="modal-default{{$dat->id}}">
                      <!-- /.modal-dialog -->
                      <div class="modal-dialog">
                         <!-- /.modal-content -->
                         <form role="form" id="forms"  method="post" action="{{ route('vendor-payment.update',$dat->id) }}">
                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="vendor_id" id="vendor_id" value="{{$dat->vendor_id}}">
                            <div class="modal-content">
                               <div class="modal-header">
                                  <h4 class="modal-title">Update Payment</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                               </div>
                               <div class="modal-body" >
                                  <div class="form-group row" >
                                      <div class="col-sm-6">
                                        <input type="date" class="form-control" name="date" id="date_{{$dat->id}}" placeholder="Enter Date" value="{{ $dat->date }}" required>
                                     </div>
                                     <div class="col-sm-6">
                                        <input type="number" class="form-control" name="payment" id="payment_{{$dat->id}}" placeholder="Enter Amount" value="{{ $dat->payment }}">
                                        <span class="help-block payment_error" id="payment_error_{{$dat->id}}" style="color: red"></span>
                                     </div>
                                  </div>
                               </div>
                               <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" >Save</button>
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
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
@include('backend.includes.datatablesJS')

<script type="text/javascript">
  jQuery(document).ready(function() {
   jQuery("#forms").validate({
      rules: {
         date: 'required',
         vendor_id: 'required',
         payment: 'required',
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
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
           url:"{{route('vendor-payment.addNewBank')}}",
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
</script>
@endsection