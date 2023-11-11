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
      <form role="form" id="forms"  method="post" action="{{ route('branch.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="branch_number">Branch Number
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="branch_number" class="form-control" id="branch_number" placeholder="Enter Branch Number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone">Phone Number
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="phone" class="form-control" id="phone" placeholder="Enter Phone Number">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="admin_name">Admin Name</label>
              <input type="text" name="admin_name" class="form-control" id="admin_name" placeholder="Enter Address">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Address">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="whatsapp_1">WhatsApp 1</label>
              <input type="number" name="whatsapp_1" class="form-control" id="whatsapp_1" placeholder="Enter Whatsapp Number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="whatsapp_2">WhatsApp 2</label>
              <input type="number" name="whatsapp_2" class="form-control" id="whatsapp_2" placeholder="Enter Whatsapp Number">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="whatsapp_3">WhatsApp 3</label>
              <input type="number" name="whatsapp_3" class="form-control" id="whatsapp_3" placeholder="Enter Whatsapp Number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="whatsapp_4">WhatsApp 4</label>
              <input type="number" name="whatsapp_4" class="form-control" id="whatsapp_4" placeholder="Enter Whatsapp Number">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="whatsapp_5">WhatsApp 5</label>
              <input type="number" name="whatsapp_5" class="form-control" id="whatsapp_5" placeholder="Enter Whatsapp Number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="whatsapp_6">WhatsApp 6</label>
              <input type="number" name="whatsapp_6" class="form-control" id="whatsapp_6" placeholder="Enter Whatsapp Number">
            </div>
          </div>
        </div>
        <div class="multiData1">
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
            <div class="col-md-2 plusIconDiv1" >
                <i onclick="addField1()" class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true" style="padding-top:35px"></i>
            </div>
            <div class="col-md-2 deleteIconDiv1" style="display:none;">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon1" id="deleteIcon1" onclick="deleteField1(this.id)" aria-hidden="true" style="padding-top:35px"></i>
            </div>
          </div>
        </div>
        <div class="multiData">
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
                    <input type="number" name="opening_balance[]" class="form-control" id="opening_balance" placeholder="Enter Remark">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 plusIconDiv" >
                <i onclick="addField()" class="fa fa-2x fa-plus-circle plusIcon" aria-hidden="true" style="padding-top:35px"></i>
            </div>
            <div class="col-md-2 deleteIconDiv" style="display:none;">
                <i class="fa fa-2x fa-trash trashIcon deleteIcon" id="deleteIcon" onclick="deleteField(this.id)" aria-hidden="true" style="padding-top:35px"></i>
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
  var id = 1;
  var id2 = 1;
  /*Bank*/
  function addField(){
    id += 1;
    var clone = $('#cloneData').clone().attr('id',id).appendTo(".multiData");
    clone.find('.plusIconDiv').hide();
    clone.find('.deleteIcon').attr('id','deleteIcon'+id);
    clone.find('.deleteIconDiv').show();
    clone.find("span.select2 ").remove();
    clone.find(".bank").attr('id','bank'+id);
    // $('.select2').select2();
    $('#bank'+id).select2();
    $(".select2").select2();
    clone.find("#opening_balance").val('');

  }

  function deleteField(deleteId){
    var id1 = $('#'+deleteId).parent().parent().remove();
    // clone.find('.deleteIconDiv').show();
  }

  /*Employee*/
  function addField1(){
    id2 += 1;
    var clone = $('#cloneData1').clone().attr('id',id2).appendTo(".multiData1");
    clone.find('.plusIconDiv1').hide();
    clone.find('.deleteIcon1').attr('id','deleteIcon1'+id2);
    clone.find('.deleteIconDiv1').show();
    clone.find("#employee_name").val('');
    clone.find("#mobile_number").val('');
  }

  function deleteField1(deleteId){
    var id1 = $('#'+deleteId).parent().parent().remove();
    // clone.find('.deleteIconDiv').show();
  }


  jQuery(document).ready(function() {
    $.validator.addMethod("uniqueBankIDs", function(value, element) {
      var bankIDs = $("select[name='bank_id[]']").map(function() {
        return $(this).val();
      }).get();

      // Use a Set to check for unique values
      var uniqueBankIDs = new Set(bankIDs);

      // Check if the uniqueBankIDs size is the same as the original bankIDs size
      return uniqueBankIDs.size === bankIDs.length;
    }, "Bank IDs must be unique.");
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
         "mobile_number[]": {
            required: false,
            maxlength: 10,
            minlength: 10,
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
          uniqueBankIDs: "Bank IDs must be unique."
        },
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});

</script>
@endsection