@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Fund
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('fund.view') }}">View All Funds</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('fund.store') }}">
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
          @if(Auth::user()->hasRole('Branch Admin'))
          <div class="col-md-6">
            <div class="form-group" style="margin-top: 40px;">
              <div class="icheck-primary d-inline form-group">
                <input type="radio" name="self_transfer" class="check" id="self" value="self" >
                <label class="radioLabel" for="self">Self Transfer
                  <!-- <span class="requiredAstrik">*</span> -->
                </label>
              </div>
              <div class="icheck-primary d-inline form-group">
                <input type="radio" name="self_transfer" class="check" id="other" value="other" checked>
                <label class="radioLabel" for="other">Other Request
                  <!-- <span class="requiredAstrik">*</span> -->
                </label>
              </div>
            </div>
          </div>
          @endif
          <div class="col-md-6" @if(Auth::user()->hasRole('Branch Admin')) style="display:none;" @endif> </div>
          @if(Auth::user()->hasRole('Branch Admin'))
            <div class="col-md-6 self" style="display:none;">
              <div class="form-group">
                <label for="approved_bank_id">From Bank
                  <span class="requiredAstrik">*</span>
                </label>
                <select class="form-control select2" id="approved_bank_id" name="approved_bank_id" onchange="updateToDropdown()">
                  <option value="">Select</option>
                  @foreach($banks as $bank)
                    <option value="{{ $bank->id }}" current_balance="{{ $bank->opening_balance }}">{{ $bank->name }} (Current Balance: {{ $bank->opening_balance }})</option>
                  @endforeach
                </select>
              </div>
            </div>
          @endif
          @if(!$multiBranch)
          <div class="col-md-6">
            <div class="form-group">
              <label for="approved_bank_id">From Bank
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="approved_bank_id" name="approved_bank_id" onchange="updateToDropdown()">
                <option value="">Select</option>
                @foreach($banks as $bank)
                  <option value="{{ $bank->id }}" current_balance="{{ $bank->opening_balance }}">{{ $bank->name }} (Current Balance: {{ $bank->opening_balance }})</option>
                @endforeach
              </select>
            </div>
          </div>
          @endif
          <!-- <div class="col-md-1">
            <center>
              
                
            </center>
          </div> -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="bank_id"><img style="    width: 3%;" src="https://cdn.pixabay.com/photo/2012/04/28/19/04/right-44058_1280.png">To Bank
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="bank_id" name="bank_id" onchange="updateToDropdowns()">
                <option value="">Select</option>
              </select>
            </div>
          </div>
        </div>
        <!--  <div class="col-md-6">-->
        <!--    <div class="form-group">-->
        <!--      <label for="bank_id">Bank-->
        <!--        <span class="requiredAstrik">*</span>-->
        <!--      </label>-->
        <!--      <select class="form-control select2" id="bank_id" name="bank_id">-->
        <!--        <option value="">Select</option>-->
        <!--      </select>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount">Amount
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="transaction_date">Transaction Date
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="transaction_date" id="transaction_date" class="form-control" value="{{date('d-m-Y h:m:s A')}}" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="reference_id">Reference Id</label>
              <input type="text" name="reference_id" class="form-control" id="reference_id" placeholder="Enter Opening balance">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="icheck-primary d-inline form-group">
              <input type="radio" name="payment_type" class="deposit check" id="deposit" value="Deposit" checked>
              <label class="radioLabel" for="deposit">Deposit
                <!-- <span class="requiredAstrik">*</span> -->
              </label>
            </div>
            <div class="icheck-primary d-inline form-group">
              <input type="radio" name="payment_type" class="withdrawal check" id="withdrawal" value="Withdrawal">
              <label class="radioLabel" for="withdrawal">Withdrawal
                <!-- <span class="requiredAstrik">*</span> -->
              </label>
            </div>
          </div>
          <!--@if(!$multiBranch)-->
          <!--<div class="col-md-6">-->
          <!--  <div class="form-group">-->
          <!--    <label for="approved_bank_id">From Bank-->
          <!--      <span class="requiredAstrik">*</span>-->
          <!--    </label>-->
          <!--    <select class="form-control select2" id="approved_bank_id" name="approved_bank_id">-->
          <!--      <option value="">Select</option>-->
          <!--      @foreach($banks as $bank)-->
          <!--        <option value="{{ $bank->id }}">{{ $bank->name }}</option>-->
          <!--      @endforeach-->
          <!--    </select>-->
          <!--  </div>-->
          <!--</div>-->
          <!--@endif-->
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
function updateToDropdown() {
    const fromDropdown = document.getElementById("approved_bank_id");
    const toDropdown = document.getElementById("bank_id");

    // Get the selected option from the "From" dropdown
    const selectedOption = fromDropdown.options[fromDropdown.selectedIndex].value;

    // Loop through the options in the "To" dropdown
    for (let i = 0; i < toDropdown.options.length; i++) {
        const option = toDropdown.options[i];
        if (option.value === selectedOption) {
            // Remove the option that matches the selected option in the "From" dropdown
            toDropdown.removeChild(option);
            break; // Exit the loop after removing the option
        }
    }
}

function updateToDropdowns() {
    const toDropdown = document.getElementById("approved_bank_id");
    const fromDropdown = document.getElementById("bank_id");

    // Get the selected option from the "From" dropdown
    const selectedOption = fromDropdown.options[fromDropdown.selectedIndex].value;

    // Loop through the options in the "To" dropdown
    for (let i = 0; i < toDropdown.options.length; i++) {
        const option = toDropdown.options[i];
        if (option.value === selectedOption) {
            // Remove the option that matches the selected option in the "From" dropdown
            toDropdown.removeChild(option);
            break; // Exit the loop after removing the option
        }
    }
}
function getBank(id) {
  $.ajax({
     url:"{{route('bank.getBankData')}}",
     type:'post',
     data:{
        '_token':token,
        'id':id,
     },
     success:function (response)
     {
        $('#bank_id').html(response);
        if ("{{ Auth::user()->hasRole('Branch Admin') }}") {
          $('#approved_bank_id').html(response);
        }
        $('#bank_id').on('change',function(){
          // const selectedValue = $(this).val();
          // const selectedOption = $(this).find(`option[value="${selectedValue}"]`);
          var max = $('option:selected', this).attr('current_balance');
          // alert(max);
          if ($('#withdrawal').is(':checked')) {
            $('#amount').attr('max',max);
          }else{
            $('#amount').removeAttr('max');
          }
        });
     }
  });
}
$('input[name="payment_type"]').on('click',function(){
  var max = $('option:selected', '#bank_id').attr('current_balance');
  if ($('#withdrawal').is(':checked')) {
    $('#amount').attr('max',max);
  }else{
    $('#amount').removeAttr('max');
  }
  
  // alert(max);
  
});

$('input[name="self_transfer"]').on('click',function(){
  if ($('#self').is(':checked')) {
    $('.self').show();
  }else{
    $('.self').hide();
    // var selectedOption = $("#approved_bank_id option:selected");

    // // Check if an option is selected
    // if (selectedOption.length > 0) {
    //     // Remove the selected option
    //     selectedOption.remove();
        
    //     // If you want to keep the first option selected, you can select it
    //     // after removing the selected option
    //     $("#approved_bank_id option:first").prop("selected", true);
    // }
    $("#approved_bank_id option:selected").removeAttr("selected");
    $('#approved_bank_id').val('');
  }
});
  jQuery(document).ready(function() {
    @if($multiBranch)
    getBank({{$multiBranch}});
    @endif
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
    });

    $.validator.addMethod("self_transfer", function(value, element) {
      return ($('#self').is(':checked'));
    }, "This field is required.");

   jQuery("#forms").validate({
      rules: {
         bank_id: 'required',
         transaction_date: 'required',
         amount: {
            required: true,
            min: 0,
            step: .01,
         },
          approved_bank_id: {
            required: true,
          },
        @if(!$multiBranch)
         approved_bank_id: 'required',
        @else
          // approved_bank_id: {
          //   self_transfer: true,
          // },
        @endif
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
@endsection