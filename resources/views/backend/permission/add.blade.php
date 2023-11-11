@extends('backend.master-layouts.main')
@section('contentHeader')
Add New Permission
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('permission.view') }}">View All Permissions</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('permission.store') }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Permission Name
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
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
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
@endsection