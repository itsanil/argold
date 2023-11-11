@extends('backend.master-layouts.main')
@section('contentHeader')
Edit User
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('user.view') }}">View All Users</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
      <form role="form" id="forms"  method="post" action="{{ route('user.update', $userEdit->id) }}">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="branch_id">Branch
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2 branch" id="branch_id" name="branch_id">
                <option value="">Select</option>
                @foreach($branches as $branch)
                  <option value="{{ $branch->id }}"  @if($userEdit->branch_id === $branch->id) selected @endif>{{ $branch->branch_number }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Person Name
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ $userEdit->name }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="mobile">Phone Number</label>
              <input type="number" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile Number" value="{{ $userEdit->mobile }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email Id
                <span class="requiredAstrik">*</span>
              </label>
              <input type="hidden" name="old_email" id="old_email" value="{{ $userEdit->email }}">
              <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email Id" value="{{ $userEdit->email }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="password">Password
                <span class="requiredAstrik">*</span>
              </label>
              <input type="text" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{ base64_decode($userEdit->encrypt_password) }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="role">Role
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2 role" id="role" name="role">
                <option value="">Select</option>
                @foreach($roles as $role)
                  <option value="{{ $role->id }}"  @if($userEdit->roles[0]->id === $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
              </select>
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
         role: 'required',
         branch_id: 'required',
         password: 'required',
         email: {
          required: true,
          email : true,
          remote: {
             url : "{{ route('user.checkEmailExists') }}",
             type : "post",
             data: {
                _token: function(){
                   return $('[name="_token"]').val();
                },
                old_email: function(){
                   return $('#old_email').val();
                },
                type: "edit"
             }
          }
        },
         mobile: {
            required: false,
            maxlength: 10,
            minlength: 10,
         },
      },
      messages: {
        email: { remote: "Email already exists." }
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
@endsection