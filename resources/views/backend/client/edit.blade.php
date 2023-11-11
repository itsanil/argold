@extends('backend.master-layouts.main')
@section('contentHeader')
Edit Client
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
      <form role="form" id="forms"  method="post" action="{{ route('client.update', $clientEdit->id) }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="branch_id">Branch
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="branch_id" name="branch_id" onchange="getBank(this.value)">
                <option value="">Select</option>
                @foreach($branches as $branch)
                  <option value="{{ $branch->id }}" @if($clientEdit->branch_id == $branch->id) selected @endif>{{ $branch->branch_number }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Client Id
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ $clientEdit->name }}">
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
                @foreach($exchanges as $exchange)
                  <option value="{{ $exchange->id }}" @if($clientEdit->exchange_id === $exchange->id) selected @endif>{{ $exchange->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mobile">Mobile Number</label>
              <input type="number" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile Number" value="{{ $clientEdit->mobile }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="opening_balance">Opening Balance
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="opening_balance" class="form-control" id="opening_balance" placeholder="Enter Opening balance" value="{{ $clientEdit->initial_balance }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark" value="{{ $clientEdit->remark }}">
            </div>
          </div>
        </div>
        <div class="multiData">
          <input type="hidden" id="countClientBankMap" value="{{ $countClientBankMap }}">
          @if($countClientBankMap > 0)
          @foreach($clientBankMaps as $key => $clientBankMap )
          @php
          if($key == 0){
            $cloneData = "cloneData";
            $deleteIcon = "deleteIcon";
          }else{
            $cloneData = "cloneData".($key+1);
            $deleteIcon = "deleteIcon".($key+1);
          }
          @endphp
          <div class="row cloneData" id="{{ $cloneData }}">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="bank_id">Bank</label>
                    <input type="text" name="bank[]" class="form-control bank" id="bank" placeholder="Enter Bank" value="{{ $clientBankMap->bank }}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ifsc_code">IFSC Code</label>
                    <input type="text" name="ifsc_code[]" class="form-control" id="ifsc_code" placeholder="Enter IFSC Code" value="{{ $clientBankMap->ifsc_code }}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="number" name="account_number[]" class="form-control" id="account_number" placeholder="Enter Account Number" value="{{ $clientBankMap->account_number }}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="upi">UPI Id</label>
                    <input type="text" name="upi[]" class="form-control" id="upi" placeholder="Enter UPI Id" value="{{ $clientBankMap->upi }}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="icheck-primary d-inline">
                    <input type="radio" name="is_primary" class="is_primary" id="{{'is_primary'.($key+1)}}" value="{{ $key+1 }}" @if($clientBankMap->is_primary == 1) checked @endif>
                    <label class="radioLabel" for="{{'is_primary'.($key+1)}}">Is Primary
                      <!-- <span class="requiredAstrik">*</span> -->
                    </label>
                  </div>
                </div>
            @if($key == 0)
            <div class="col-md-2 plusIconDiv" onclick="addField()">
                <i class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true"></i>
            </div>
            @endif
            <div class="col-md-2 deleteIconDiv" @if($key != ($countClientBankMap-1) || $key == 0) style="display:none;" @endif>
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="{{$deleteIcon}}" onclick="deleteField(this.id)" aria-hidden="true"></i>
            </div>
          </div>
          @endforeach
          @else
          <div class="row cloneData" id="cloneData">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="bank_id">Bank</label>
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
                    <input type="text" name="account_number[]" class="form-control" id="account_number" placeholder="Enter Remark">
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
                      <span class="requiredAstrik">*</span>
                    </label>
                  </div>
                </div>
            <div class="col-md-2 plusIconDiv" onclick="addField()">
                <i class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true"></i>
            </div>
            <div class="col-md-2 deleteIconDiv" style="display:none;">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="deleteIcon" onclick="deleteField(this.id)" aria-hidden="true"></i>
            </div>
          </div>
          @endif
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

  var id = $('#countClientBankMap').val();
  if(id == 0){
    id=1;
  }
  function addField(){
    id += 1;
    var clone = $('#cloneData').clone().attr('id','cloneData'+id).appendTo(".multiData");
    clone.find('.plusIconDiv').hide();
    $('.deleteIconDiv').hide();
    clone.find('.deleteIcon').attr('id','deleteIcon'+id);
    clone.find('.deleteIconDiv').show();
    clone.find(".is_primary").attr('id','is_primary'+id);
    clone.find(".is_primary").val(id);
    clone.find(".radioLabel").attr('for','is_primary'+id);
    clone.find("#bank").val('');
    clone.find("#ifsc_code").val('');
    clone.find("#account_number").val('');
    clone.find("#upi").val('');
  }

  function deleteField(deleteId){
    id -= 1;
    var id1 = $('#'+deleteId).parent().parent().remove();
    $('#deleteIcon'+id).parent().show();
  }

  jQuery(document).ready(function() {
   jQuery("#forms").validate({
      rules: {
         name: 'required',
         exchange_id: 'required',
         // "is_primary": 'required',
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