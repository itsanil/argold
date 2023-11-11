@extends('backend.master-layouts.main')
@section('contentHeader')
Edit Fund
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
        <form role="form" id="forms"  method="post" action="{{ route('fund.update', $fundEdit->id) }}">
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
                    <option value="{{ $branch->id }}" @if($fundEdit->branch_id == $branch->id) selected @endif>{{ $branch->branch_number }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="bank_id">Bank
                  <span class="requiredAstrik">*</span>
                </label>
                <select class="form-control select2" id="bank_id" name="bank_id">
                  <option value="">Select</option>
                  @foreach($banks as $bank)
                  <option value="{{ $bank->id }}" @if($fundEdit->bank_id == $bank->id) selected @endif>{{ $bank->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="amount">Amount
                  <span class="requiredAstrik">*</span>
                </label>
                <input type="hidden" name="old_bank_id" value="{{ $fundEdit->bank_id }}">
                <input type="hidden" name="old_amount" value="{{ $fundEdit->amount }}">
                <input type="hidden" name="old_branch_id" value="{{ $fundEdit->branch_id }}">
                <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount" value="{{ $fundEdit->amount }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="transaction_date">Transaction Date
                  <span class="requiredAstrik">*</span>
                </label>
                <input type="text" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('d-m-Y h:m:s A',strtotime($fundEdit->transaction_date))}}" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="reference_id">Reference Id</label>
                <input type="text" name="reference_id" class="form-control" id="reference_id" placeholder="Enter Reference Id"  value="{{ $fundEdit->reference_id }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="remark">Remark</label>
                <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark"  value="{{ $fundEdit->remark }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="icheck-primary d-inline form-group">
                <input type="radio" name="payment_type" class="deposit" id="deposit" value="Deposit" @if($fundEdit->payment_type == 'Deposit') checked @endif>
                <label class="radioLabel" for="deposit">Deposit
                  <!-- <span class="requiredAstrik">*</span> -->
                </label>
              </div>
              <div class="icheck-primary d-inline form-group">
                <input type="radio" name="payment_type" class="withdrawal" id="withdrawal" value="Withdrawal" @if($fundEdit->payment_type == 'Withdrawal') checked @endif>
                <label class="radioLabel" for="withdrawal">Withdrawal
                  <!-- <span class="requiredAstrik">*</span> -->
                </label>
              </div>
            </div>
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
var token = $('[name="_token"]').val();
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
     }
  });
}

  jQuery(document).ready(function() {
    //Date picker
    $('#reservationdate').datetimepicker({
      format: 'DD-MM-YYYY'
    });
    jQuery("#forms").validate({
      rules: {
       bank_id: 'required',
       transaction_date: 'required',
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
</script>
@endsection