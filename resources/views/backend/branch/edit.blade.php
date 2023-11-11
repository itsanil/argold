@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Branch
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('dashboard.view') }}">View All Branches</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="container-fluid">
      <div class="card-body">
        <!-- <br> -->
        <form role="form" id="forms"  method="post" action="{{ route('branch.update', $branchEdit->id) }}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="branch_number">Branch Number
                  <span class="requiredAstrik">*</span>
                </label>
                <input type="text" name="branch_number" class="form-control" id="branch_number" placeholder="Enter Branch Number" value="{{ $branchEdit->branch_number }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone">Phone Number
                  <span class="requiredAstrik">*</span>
                </label>
                <input type="number" name="phone" class="form-control" id="phone" placeholder="Enter Phone Number"  value="{{ $branchEdit->phone }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address" value="{{ $branchEdit->address }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="admin_name">Admin Name</label>
                <input type="text" name="admin_name" class="form-control" id="admin_name" placeholder="Enter Admin Name"  value="{{ $branchEdit->admin_name }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="remark">Remark</label>
                <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark" value="{{ $branchEdit->remark }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp_1">WhatsApp 1</label>
                <input type="number" name="whatsapp_1" class="form-control" id="whatsapp_1" placeholder="Enter Whatsapp Number" value="{{ $branchEdit->whatsapp_1 }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp_2">WhatsApp 2</label>
                <input type="number" name="whatsapp_2" class="form-control" id="whatsapp_2" placeholder="Enter Whatsapp Number" value="{{ $branchEdit->whatsapp_2 }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp_3">WhatsApp 3</label>
                <input type="number" name="whatsapp_3" class="form-control" id="whatsapp_3" placeholder="Enter Whatsapp Number" value="{{ $branchEdit->whatsapp_3 }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp_4">WhatsApp 4</label>
                <input type="number" name="whatsapp_4" class="form-control" id="whatsapp_4" placeholder="Enter Whatsapp Number" value="{{ $branchEdit->whatsapp_4 }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp_5">WhatsApp 5</label>
                <input type="number" name="whatsapp_5" class="form-control" id="whatsapp_5" placeholder="Enter Whatsapp Number" value="{{ $branchEdit->whatsapp_5 }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp_6">WhatsApp 6</label>
                <input type="number" name="whatsapp_6" class="form-control" id="whatsapp_6" placeholder="Enter Whatsapp Number" value="{{ $branchEdit->whatsapp_6 }}">
              </div>
            </div>
          </div>
          <div class="multiData1">
            @if($countBranchEmployeeMap > 0)
            @foreach($branchEmployeeMaps as $key => $branchEmployeeMap )
            @php
            if($key == 0){
              $cloneData = "cloneData1";
              $deleteIcon = "deleteIcon1";
            }else{
              $cloneData = "cloneData1".($key+1);
              $deleteIcon = "deleteIcon1".($key+1);
            }
            @endphp
            <div class="row cloneData1" id="{{ $cloneData }}">
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="employee_name">Employee Name</label>
                      <input type="text" name="employee_name[]" class="form-control" id="employee_name" placeholder="Enter Employee Name" value="{{$branchEmployeeMap->employee_name}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="mobile_number">Employee Number</label>
                      <input type="number" name="mobile_number[]" class="form-control" id="mobile_number" placeholder="Enter Opening Balance" value="{{ $branchEmployeeMap->mobile_number }}">
                    </div>
                  </div>
                </div>
              </div>
              @if($key == 0)
              <div class="col-md-2 plusIconDiv1">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="{{$deleteIcon}}" onclick="clearField1(this.id)" aria-hidden="true" style="padding-top:35px"></i>
                <i onclick="addField1()" class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true" style="padding-top:35px"></i>
              </div>
              @endif
              <div class="col-md-2 deleteIconDiv1" @if($key == 0)style="display:none;"@endif>
                <i class="fa fa-2x fa-trash trashIcon deleteIcon1" id="{{$deleteIcon}}" onclick="deleteField1(this.id)" aria-hidden="true" style="padding-top:35px"></i>
              </div>
            </div>
            @endforeach
            @else
            <div class="row cloneData1" id="cloneData1">
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="employee_name">Employee Name</label>
                      <input type="text" name="employee_name[]" class="form-control" id="employee_name" placeholder="Enter Employee Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="mobile_number">Mobile Number</label>
                      <input type="number" name="mobile_number[]" class="form-control" id="mobile_number" placeholder="Enter Mobile Number">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2 plusIconDiv1" onclick="addField1()">
                <i class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true" style="padding-top:35px"></i>
              </div>
              <div class="col-md-2 deleteIconDiv1" id="deleteIconDiv" style="display:none;">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon1" id="deleteIcon1" onclick="deleteField1(this.id)" aria-hidden="true" style="padding-top:35px"></i>
              </div>
            </div>
            @endif
          </div>
          <div class="multiData">
            @if($countBranchBankMap > 0)
            @foreach($branchBankMaps as $key => $branchBankMap )
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
              <div class="col-md-10">
                <div class="row">
                  <input type="hidden" id="branch_bank_id" name="branch_bank_id[]" value="{{ $branchBankMap->id }}">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="bank_id">Bank</label>
                      <select class="form-control select2 bank" id="{{'bank'.$key}}" name="bank_id[]" disabled>
                        <option value="">Select</option>
                        @foreach($banks as $bank)
                        <option value="{{ $bank->id }}" @if($branchBankMap->bank_id == $bank->id)selected @endif>{{ $bank->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="opening_balance">Opening Balance</label>
                      <input type="number" name="opening_balance[]" class="form-control" id="opening_balance" placeholder="Enter Opening Balance" value="{{ $branchBankMap->opening_balance }}" disabled>
                    </div>
                  </div>
                </div>
              </div>
              @if($key == 0)
              <div class="col-md-2 plusIconDiv">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="{{$deleteIcon}}" onclick="clearField(this.id)" aria-hidden="true" style="padding-top:35px"></i>
                <i onclick="addField()" class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true" style="padding-top:35px"></i>
              </div>
              @endif
              <div class="col-md-2 deleteIconDiv" @if($key == 0)style="display:none;"@endif>
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="{{$deleteIcon}}" onclick="deleteField(this.id)" aria-hidden="true" style="padding-top:35px"></i>
              </div>
            </div>
            @endforeach
            @else
            <div class="row cloneData" id="cloneData">
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="bank_id">Bank</label>
                      <select class="form-control select2 bank" id="bank" name="bank_id[]">
                        <option value="">Select</option>
                        @foreach($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="opening_balance">Opening Balance</label>
                      <input type="number" name="opening_balance[]" class="form-control" id="opening_balance" placeholder="Enter Opening Balance">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2 plusIconDiv" onclick="addField()">
                <i class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true" style="padding-top:35px"></i>
              </div>
              <div class="col-md-2 deleteIconDiv" id="deleteIconDiv" style="display:none;">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="deleteIcon" onclick="deleteField(this.id)" aria-hidden="true" style="padding-top:35px"></i>
              </div>
            </div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary  float-right">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
<script type="text/javascript">

  var id = {{$countBranchBankMap}};
  if(id == 0){
    id=1;
  }

  var id2 = {{$countBranchEmployeeMap}};
  if(id2 == 0){
    id2=1;
  }

  function addField(){
    id += 1;
    var clone = $('#cloneData').clone().attr('id','cloneData'+id).appendTo(".multiData");
    clone.find('.plusIconDiv').hide();
    clone.find('.deleteIcon').attr('id','deleteIcon'+id);
    clone.find('.deleteIconDiv').show();
    clone.find("span.select2 ").remove();
    clone.find(".bank").attr('id','bank'+id);
    clone.find(".bank").removeAttr('disabled').val('');
    clone.find("#opening_balance").removeAttr('disabled').val('');
    $('#bank'+id).select2();
    $(".select2").select2();
    // clone.find("#opening_balance").val('');

  }

  function deleteField(deleteId){
    id -= 1;
    var id1 = $('#'+deleteId).parent().parent().remove();
    // clone.find('.deleteIconDiv').show();
  }

  function clearField(deleteId){

    $('#'+deleteId).remove();
    var clone = $('#'+deleteId).parent().parent();
    clone.find('#opening_balance').val("");
    clone.find('#bank').val("");
    clone.find('#branch_bank_id').val("");
    clone.find(".bank").removeAttr('disabled').val('');
    clone.find("#opening_balance").removeAttr('disabled').val('');
    clone.find('#bank').select2();
    // clone.find('#branch_bank_id').remove();
    $(".select2").select2();
  }

  /*Employee*/
  function addField1(){
    id2 += 1;
    var clone = $('#cloneData1').clone().attr('id','cloneData1'+id2).appendTo(".multiData1");
    clone.find('.plusIconDiv1').hide();
    clone.find('.deleteIcon1').attr('id','deleteIcon1'+id2);
    clone.find('.deleteIconDiv1').show();
    clone.find("#employee_name").val('');
    clone.find("#mobile_number").val('');
  }

  function deleteField1(deleteId){
    id2 -= 1;
    var id1 = $('#'+deleteId).parent().parent().remove();
    // clone.find('.deleteIconDiv').show();
  }

  function clearField1(deleteId){

    $('#'+deleteId).remove();
    var clone = $('#'+deleteId).parent().parent();
    clone.find('#employee_name').val("");
    clone.find('#mobile_number').val("");
  }

  $.validator.addMethod("uniqueBankIDs", function(value, element) {
    var bankIDs = $("select[name='bank_id[]']").map(function() {
      return $(this).val();
    }).get();

    // Use a Set to check for unique values
    var uniqueBankIDs = new Set(bankIDs);

    // Check if the uniqueBankIDs size is the same as the original bankIDs size
    return uniqueBankIDs.size === bankIDs.length;
  }, "Bank must be unique.");

  var ruleForWhatsapp = {
          required: false,
          maxlength: 10,
          minlength: 10,
       };
  jQuery("#forms").validate({
    rules: {
       name: 'required',
       branch_number: 'required',
       "opening_balance[]": {
          required: false,
          min: 0,
          step: .01,
       },
       phone: {
          required: true,
          maxlength: 10,
          minlength: 10,
       },
       "bank_id[]": {
          uniqueBankIDs: true
        },
       whatsapp_1: ruleForWhatsapp,
       whatsapp_2: ruleForWhatsapp,
       whatsapp_3: ruleForWhatsapp,
       whatsapp_4: ruleForWhatsapp,
       whatsapp_5: ruleForWhatsapp,
       whatsapp_6: ruleForWhatsapp,
    },
    messages: {
      "opening_balance[]": {
          step: "Please enter two digit decimal.",
      },
      "bank_id[]": {
        uniqueBankIDs: "Bank must be unique."
      },
    },
    errorElement: "div",
    errorPlacement: function (error, element) {
        error.appendTo( element.parents('.form-group') ); 
    },
  });
 </script>
 @endsection