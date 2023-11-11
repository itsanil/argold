@extends('backend.master-layouts.main')
@section('contentHeader')
Permission for "{{ $role->name }}"
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('role.view') }}">View All Roles</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
      <form role="form" id="forms"  method="post" action="{{ route('role.updateRolePermission', $role->id) }}">
      {{ csrf_field() }}
      <table id="customDataTable"  class="table table-bordered table-striped dataTable dtr-inline table-hover" >
          <thead>
            <tr>
              <th>Permission Name</th>
              <th width="25%">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
              <tr>
                <td>{{ $permission->name }}</td>
                <td>
                 <div class="form-check">
                    <input class="form-check-input" name="permission[]" type="checkbox" value="{{ $permission->id }}" @if(in_array($permission->id, $rolePermissions)) checked @endif>
                    <!-- <label for="customCheckbox1" class="custom-control-label"></label> -->
                  </div>
               </td>
              </tr>
            @endforeach
          </tbody>
        </table>
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