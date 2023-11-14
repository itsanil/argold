@extends('backend.master-layouts.main')
@section('contentHeader')
Edit vendor
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('vendor.view') }}">View All Vendor</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('vendor.update', $vendor->id) }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">vendor Name
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter vendor Name" value="{{ $vendor->name }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankname">Bank Name</label>
              <input type="text" name="bankname" class="form-control" id="bankname" placeholder="Enter Transaction Code" value="{{ $vendor->bankname }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankaccountno">Bank Account Number</label>
              <input type="number" name="bankaccountno" class="form-control" id="bankaccountno" placeholder="Enter Account Number" value="{{ $vendor->bankaccountno }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ifsc_code">IFSC Code</label>
              <input type="text" name="ifsccode" class="form-control" id="ifsccode" placeholder="Enter IFSC Code" value="{{ $vendor->ifsccode }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankcity">City
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="select2" id="bankcity" name="bankcity" required>
                <option value="">Select</option>
                @foreach($city as $cit)
                  <option value="{{ $cit->name }}" @if($vendor->bankcity === $cit->name) selected @endif>{{ $cit->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ifsc_code">Branch</label>
              <input type="text" name="branch" class="form-control" id="branch" placeholder="Enter Branch" value="{{ $vendor->branch }}">
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