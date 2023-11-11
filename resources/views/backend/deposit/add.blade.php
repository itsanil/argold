@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Deposit
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('deposit.view') }}">View All Deposits</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('deposit.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="branch_id">Branch
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="branch_id" name="branch_id" onchange="getClient(this.value);getBank(this.value);">
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
              <label for="client_id">Client Id
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="client_id" name="client_id"    onchange="getExchangeName(this.value)">
                <option value="">Select</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exchange_name">Exchange
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="exchange_name" class="form-control" id="exchange_name" readonly>
              <input type="hidden" name="exchange_id" class="form-control" id="exchange_id">
            </div>
          </div>
          <!--<div class="col-md-6">-->
          <!--  <div class="form-group">-->
          <!--    <label for="amount">Win Amount-->
          <!--      <span class="requiredAstrik">*</span>-->
          <!--    </label>-->
              <input type="hidden" name="win_amt" value="0" class="form-control" id="win_amt" placeholder="Enter Win Amount">
          <!--  </div>-->
          <!--</div>-->
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount">Amount
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
            </div>
          </div>
        <!-- </div> -->
        <!-- <div class="row"> -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="date">Date
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="date" id="date" class="form-control" value="{{date('d-m-Y h:m:s A')}}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bank_id">Bank
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="bank_id" name="bank_id">
                <option value="">Select</option>
              </select>
            </div>
          </div>
        <!-- </div> -->
        <!-- <div class="row"> -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="date">UTR
                <span class="requiredAstrik">*</span>
              </label>
                <input type="text" name="utr" id="utr" class="form-control"  required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bonus">Bonus</label>
              <select class="form-control select2" id="bonus" name="bonus">
                <option value="">Select</option>
                @foreach($percentages as $percentage)
                  <option value="{{ $percentage->key }}">{{ $percentage->value }}</option>
                @endforeach
              </select>
              <label>Bonus Amount:<span id="result_amount"></span></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mode_id">Mode
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="mode_id" name="mode_id">
                <option value="">Select</option>
                @foreach($modes as $mode)
                  <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        <!-- </div> -->
        <!-- <div class="row"> -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark">
            </div>
          </div>
        </div>
            @if(session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
            @endif
         <button type="submit" class="btn btn-primary  float-right">Submit</button>
      </form>
    </div>
  </div>
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
<script type="text/javascript">
    function getResultAmount() {
    var amount = $("#amount").val();
    var bonus = $("#bonus").val();
    var result = 0;
    if (amount) {
      result = parseInt(amount * bonus/100);
    }
    $("#result_amount").html(result);
  }
  getResultAmount();
  $('#bonus ,#amount').on('change',function(){
    getResultAmount();
  });
  var token = $('[name="_token"]').val();
  function getClient(id) {
    $.ajax({
       url:"{{route('client.getClientFromBranch')}}",
       type:'post',
       data:{
          '_token':token,
          'id':id,
       },
       success:function (response)
       {
          $('#client_id').html(response);
       }
    });
  }

  function getBank(id) {
    $.ajax({
       url:"{{route('bank.getBankData')}}",
       type:'post',
       data:{
          '_token':token,
          'type':'bank',
          'id':id,
       },
       success:function (response)
       {
          $('#bank_id').html(response);
       }
    });
  }
  
  jQuery(document).ready(function() {

    @if($multiBranch)
    getBank({{$multiBranch}});
    getClient({{$multiBranch}});
    @endif
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
    });
   jQuery("#forms").validate({
      rules: {
         branch_id: 'required',
         client_id: 'required',
         win_amt: 'required',
         exchange_name: 'required',
         bank_id: {
              required: function(element) {
                  // Implement your conditional logic here
                  // For example, if another field with id "otherField" has a certain value, make this field required
                  return jQuery("#amount").val() > 0;
              }
          },
          utr: {
              required: function(element) {
                  // Implement your conditional logic here
                  // For example, if another field with id "otherField" has a certain value, make this field required
                  return jQuery("#amount").val() > 0;
              }
          },
          mode_id: {
              required: function(element) {
                  // Implement your conditional logic here
                  // For example, if another field with id "otherField" has a certain value, make this field required
                  return jQuery("#amount").val() > 0;
              }
          },
         date: 'required',
         amount: {
            required: true,
            min: 0,
            step: .01,
         },
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});

 function getExchangeName(id){
  $.ajax({
    url:"{{ route('get.exchangeDetailsFromId') }}",
    type:"GET",
    data:{id:id},
    success:function(data){
      $('#exchange_id').val(data.id);
      $('#exchange_name').val(data.name+'(Balance:'+data.opening_balance+')');
    }
   });
  }
</script>
@endsection