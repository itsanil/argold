@extends('backend.master-layouts.main')
@section('contentHeader')
Edit Withdrawal
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('withdrawal.view') }}">View All Withdrawals</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">

    <div class="container-fluid">
      <div class="card-body">
        <!-- <br> -->
        <form role="form" id="forms"  method="post" action="{{ route('withdrawal.update', $withdrawalEdit->id) }}">
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
                  <option value="{{ $branch->id }}" @if($withdrawalEdit->branch_id == $branch->id) selected @endif>{{ $branch->branch_number }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="client_id">Client Id
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="client_id" name="client_id" onchange="getExchangeName(this.value)">
                <option value="">Select</option>
                @foreach($clients as $client)
                  <option value="{{ $client->id }}" @if($withdrawalEdit->client_id == $client->id) selected current_balance="{{ $client->opening_balance+$withdrawalEdit->exchange_amt+$withdrawalEdit->amount }}" @else current_balance="{{ $client->opening_balance }}"  @endif>{{ $client->name }}
                    (Current Balance:
                    @if($withdrawalEdit->client_id == $client->id) {{ $client->opening_balance+$withdrawalEdit->exchange_amt+$withdrawalEdit->amount }} 
                    @else
                    {{ $client->opening_balance }}
                    @endif
                    )</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="bank_id">Exchange
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="exchange_name" class="form-control" id="exchange_name" readonly value="{{ $exchange->name }}">
              <input type="hidden" name="exchange_id" class="form-control" id="exchange_id" value="{{ $withdrawalEdit->exchange_id }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="exchange_name">Exchange Amount
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="exchange_amt" min="0" class="form-control" id="exchange_amt" placeholder="Enter Amount" value="{{ $withdrawalEdit->exchange_amt }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount">Amount
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount" value="{{ $withdrawalEdit->amount }}">
            </div>
          </div>
        <!-- </div> -->
        <!-- <div class="row"> -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="date">Date
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="date" id="date" class="form-control" value="{{ date('d-m-Y h:m:s A',strtotime($withdrawalEdit->date))}}" readonly>
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
                  <option value="{{ $bank->id }}" @if($withdrawalEdit->bank_id == $bank->id) selected @endif>{{ $bank->name }}</option>
                @endforeach
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
                <input type="text" name="utr" id="utr" class="form-control" value="{{ $withdrawalEdit->utr }}" required>
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
                  <option value="{{ $mode->id }}" @if($withdrawalEdit->mode_id == $mode->id) selected @endif>{{ $mode->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark" value="{{ $withdrawalEdit->remark }}">
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
  </div>
  <!-- /.modal-dialog -->
</section>
@endsection
@section('js')
<script type="text/javascript">
  
  jQuery(document).ready(function() {
    // getExchangeName({{ $withdrawalEdit->client_id }});
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY H:m A'
    });
   jQuery("#forms").validate({
      rules: {
         client_id: 'required',
         exchange_name: 'required',
         bank_id: 'required',
         mode_id: 'required',
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
      $('#exchange_name').val(data.name);
    }
   });
}
</script>
@endsection