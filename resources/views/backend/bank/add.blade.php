@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Bank
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('bank.view') }}">View All Banks</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('bank.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Bank Name
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="account_type_id">Account Type
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="select2" id="account_type_id" name="account_type_id" required>
                <option value="">Select</option>
                @foreach($accountTypes as $accountType)
                  <option value="{{ $accountType->id }}">{{ $accountType->account_type }}</option>
                @endforeach
              </select>
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
              <label for="transaction_code">Transaction Code</label>
              <input type="text" name="transaction_code" class="form-control" id="transaction_code" placeholder="Enter Transaction Code">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="account_number">Account Number</label>
              <input type="number" name="account_number" class="form-control" id="account_number" placeholder="Enter Account Number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ifsc_code">IFSC Code</label>
              <input type="text" name="ifsc_code" class="form-control" id="ifsc_code" placeholder="Enter IFSC Code">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="source">Source</label>
              <input type="text" name="source" class="form-control" id="source" placeholder="Enter Remark">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark">
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
  jQuery(document).ready(function() {
   jQuery("#forms").validate({
      rules: {
         name: 'required',
         account_type_id: 'required',
         opening_balance: {
            required: true,
            min: 0,
            step: .01,
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