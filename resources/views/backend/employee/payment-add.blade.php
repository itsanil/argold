@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Vendor Payment
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('vendor.view') }}">View All vendors</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('vendor-payment.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankcity">vendor
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="select2" id="vendor_id" name="vendor_id" required>
                <option value="">Select</option>
                @foreach($vendors as $cit)
                  <option value="{{ $cit->id }}" >{{ $cit->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" name="date" class="form-control" id="date" placeholder="Enter Transaction Code" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="payment">Payment</label>
              <input type="number" name="payment" class="form-control" id="payment" placeholder="Enter Payment" >
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
         date: 'required',
         vendor_id: 'required',
         payment: 'required',
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
@endsection