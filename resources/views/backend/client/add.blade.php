@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Client
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('client.view') }}">View All Clients</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('client.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="branch_id">Branch
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="branch_id" name="branch_id" onchange="getBank(this.value)">
                @if(!$multiBranch)
                <option value="">Select</option>
                @endif
                @foreach($branches as $branch)
                  <option value="{{ $branch->id }}">{{ $branch->branch_number }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Client Id
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exchange_id">Exchange
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="exchange_id" name="exchange_id">
                <option value="">Select</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mobile">Mobile Number</label>
              <input type="number" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile Number">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="opening_balance">Opening Balance
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="opening_balance" class="form-control" id="opening_balance" placeholder="Enter Opening balance">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark">
            </div>
          </div>
        </div>
        <div class="multiData">
          <div class="row cloneData" id="cloneData">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="bank">Bank</label>
                    <input type="text" name="bank[]" class="form-control bank" id="bank" placeholder="Enter Bank">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ifsc_code">IFSC Code</label>
                    <input type="text" name="ifsc_code[]" class="form-control" id="ifsc_code" placeholder="Enter IFSC Code">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="number" name="account_number[]" class="form-control" id="account_number" placeholder="Enter Remark">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="upi">UPI Id</label>
                    <input type="text" name="upi[]" class="form-control" id="upi" placeholder="Enter Remark">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="icheck-primary d-inline form-group">
                    <input type="radio" name="is_primary" class="is_primary" id="is_primary" value="1">
                    <label class="radioLabel" for="is_primary">Is Primary
                      <!-- <span class="requiredAstrik">*</span> -->
                    </label>
                  </div>
                </div>
            <div class="col-md-2 plusIconDiv" >
                <i onclick="addField()" class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true"></i>
            </div>
            <div class="col-md-2 deleteIconDiv" style="display:none;">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="deleteIcon" onclick="deleteField(this.id)" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        
         <button type="submit" class="btn btn-primary  float-right">Submit</button>
      </form>
    </div>
  </div>
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
<script type="text/javascript">
  var token = $('[name="_token"]').val();
  function getBank(id) {
    $.ajax({
       url:"{{route('bank.getBankData')}}",
       type:'post',
       data:{
          '_token':token,
          'type':'exchange',
          'types':'branch',
          'id':id,
       },
       success:function (response)
       {
          $('#exchange_id').html(response);
       }
    });
  }
  var id = 1;
  function addField(){
    id += 1;
    var clone = $('#cloneData').clone().attr('id',id).appendTo(".multiData");
    clone.find('.plusIconDiv').hide();
    $('.deleteIconDiv').hide();
    clone.find('.deleteIcon').attr('id','deleteIcon'+id);
    clone.find('.deleteIconDiv').show();
    // clone.find("span.select2 ").remove();
    clone.find(".is_primary").attr('id','is_primary'+id);
    clone.find(".is_primary").val(id);
    clone.find(".radioLabel").attr('for','is_primary'+id);
    clone.find("#bank").val('');
    clone.find("#ifsc_code").val('');
    clone.find("#account_number").val('');
    clone.find("#upi").val('');
    // $('.select2').select2();
    // $('#bank'+id).select2();
    // $(".select2").select2();

  }

  function deleteField(deleteId){
    id -= 1;
    var id1 = $('#'+deleteId).parent().parent().remove();
    $('#deleteIcon'+id).parent().show();
    // clone.find('.deleteIconDiv').show();
  }

  jQuery(document).ready(function() {
    @if($multiBranch)
    getBank({{$multiBranch}});
    @endif
   jQuery("#forms").validate({
      rules: {
         name: 'required',
         exchange_id:{
            required: true,
            remote: {
               url : "{{ route('client.checkClientExchange') }}",
               type : "post",
               data: {
                  _token: function(){
                     return $('[name="_token"]').val();
                  },
                  name: function(){
                     return $('#name').val();
                  }
               }
            }
         },
         // is_primary: 'required',
         opening_balance: {
            required: true,
            min: 0,
            step: .01,
         },
         mobile: {
            required: false,
            maxlength: 10,
            minlength: 10,
         },
      },
      messages: {
        exchange_id: { remote: "Client ID and exhange already exist." },
        opening_balance: {
            step: "Please enter two digit decimal.",
        }
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
@endsection