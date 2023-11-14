@extends('backend.master-layouts.main')
@section('contentHeader')
{{ isset($employee) ? 'Update' : 'Add New' }} Employee
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('employee.view') }}">View All Employees</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
  <div class="container-fluid">
    <div class="card-body">
    <!-- <br> -->
    <form role="form" id="forms"  method="post" action="{{ route('employee.store') }}" enctype="multipart/form-data">
      {{ csrf_field() }}
        <!-- Employee Information -->
        <div class="row">
          <input type="hidden" name="id" value="{{ isset($employee) ? $employee->id : 0 }}">
        <div class="form-group col-md-6">
            <label for="employeeidno">Employee ID No:</label>
            <input type="text" name="employeeidno" class="form-control" value="{{ old('employeeidno', isset($employee) ? $employee->employeeidno : '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', isset($employee) ? $employee->name : '') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="id_proof">ID Proof:</label>
            @if(isset($employee) && $employee->id_proof)
              <img src="{{ url($employee->id_proof) }}" width="25px;">
            @endif
            <input type="file" name="id_proof" class="form-control" value="{{ old('id_proof', isset($employee) ? $employee->id_proof : '') }}">
        </div>

        <div class="form-group col-md-6">

            <label for="address_proof">Address Proof:</label>
            @if(isset($employee) && $employee->address_proof)
              <img src="{{ url($employee->address_proof) }}" width="25px;">
            @endif
            <input type="file" name="address_proof" class="form-control" value="{{ old('address_proof', isset($employee) ? $employee->address_proof : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="address">Address:</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', isset($employee) ? $employee->address : '') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="letter">Letter:</label>
            @if(isset($employee) && $employee->letter)
              <img src="{{ url($employee->letter) }}" width="25px;">
            @endif
            <input type="file" name="letter" class="form-control" value="{{ old('letter', isset($employee) ? $employee->letter : '') }}" >
        </div>

        <!-- <div class="form-group col-md-6">
            <label for="exit_date">Exit Date:</label>
            <input type="date" name="exit_date" class="form-control" value="{{ old('exit_date', isset($employee) ? $employee->exit_date : '') }}">
        </div> -->

        <!-- <div class="form-group col-md-6">
            <label for="insurance_no">Insurance No:</label>
            <input type="text" name="insurance_no" class="form-control" value="{{ old('insurance_no', isset($employee) ? $employee->insurance_no : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="insurance_proof">Insurance Proof:</label>
            <input type="file" name="insurance_proof" class="form-control" value="{{ old('insurance_proof', isset($employee) ? $employee->insurance_proof : '') }}">
        </div> -->

        <div class="form-group col-md-6">
            <label for="contact1">Contact 1:</label>
            <input type="number" name="contact1" class="form-control" value="{{ old('contact1', isset($employee) ? $employee->contact1 : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="contact2">Contact 2:</label>
            <input type="number" name="contact2" class="form-control" value="{{ old('contact2', isset($employee) ? $employee->contact2 : '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="city_id">Country:</label>
            {{ Form::select('country_id', $country, isset($employee) ? $employee->country_id : null, [ 'class'=> 'form-control select2',  'placeholder' => 'Select country...']) }}
        </div>
        <div class="form-group col-md-6">
            <label for="city_id">state:</label>
            {{ Form::select('state_id', $state, isset($employee) ? $employee->state_id : null, [ 'class'=> 'form-control select2',  'placeholder' => 'Select state...']) }}
        </div>
        <div class="form-group col-md-6">
            <label for="city_id">City:</label>
            {{ Form::select('city_id', $city, isset($employee) ? $employee->city_id : null, [ 'class'=> 'form-control select2',  'placeholder' => 'Select City...']) }}
        </div>


        <div class="form-group col-md-6">
            <label for="zip">ZIP:</label>
            <input type="text" name="zip" class="form-control" value="{{ old('zip', isset($employee) ? $employee->zip : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="age">Age:</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', isset($employee) ? $employee->age : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="birthdate">Birthdate:</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', isset($employee) ? $employee->birthdate : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="date_hired">Date Hired:</label>
            <input type="date" name="date_hired" class="form-control" value="{{ old('date_hired', isset($employee) ? $employee->date_hired : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="department_id">Department ID:</label>
            {{ Form::select('department_id', $department, isset($employee) ? $employee->department_id : null, [ 'class'=> 'form-control select2',  'placeholder' => 'Select department...']) }}
        </div>

        

        <div class="form-group col-md-6">
            <label for="picture">Picture:</label>
            @if(isset($employee) && $employee->picture)
              <img src="{{ url($employee->picture) }}" width="25px;">
            @endif
            <input type="file" name="picture" class="form-control" value="{{ old('picture', isset($employee) ? $employee->picture : '') }}" >
        </div>

        

        <div class="form-group col-md-6">
            <label for="bankname">Bank Name:</label>
            <input type="text" name="bankname" class="form-control" value="{{ old('bankname', isset($employee) ? $employee->bankname : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="bankaccountno">Bank Account No:</label>
            <input type="text" name="bankaccountno" class="form-control" value="{{ old('bankaccountno', isset($employee) ? $employee->bankaccountno : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="ifsccode">IFSC Code:</label>
            <input type="text" name="ifsccode" class="form-control" value="{{ old('ifsccode', isset($employee) ? $employee->ifsccode : '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="bankcity">Bank City:</label>
            <input type="text" name="bankcity" class="form-control" value="{{ old('bankcity', isset($employee) ? $employee->bankcity : '') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="branch">Branch:</label>
            <input type="text" name="branch" class="form-control" value="{{ old('branch', isset($employee) ? $employee->branch : '') }}">
        </div>

        

        <div class="form-group col-md-6">
            <label for="form11">Form 11:</label>
            @if(isset($employee) && $employee->form11)
              <img src="{{ url($employee->form11) }}" width="25px;">
            @endif
            <input type="file" name="form11" class="form-control" value="{{ old('form11', isset($employee) ? $employee->form11 : '') }}">
        </div>

        

        <div class="form-group col-md-6">
            <label for="panno">PAN No:</label>
            <input type="text" name="panno" class="form-control" value="{{ old('panno', isset($employee) ? $employee->panno : '') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="aadharcardno">Aadhar Card No:</label>
            <input type="text" name="aadharcardno" class="form-control" value="{{ old('aadharcardno', isset($employee) ? $employee->aasharcardno : '') }}" required>
        </div>

        <!-- <div class="form-group col-md-6">
            <label for="salary_status">Salary Status:</label>
            <input type="text" name="salary_status" class="form-control" value="{{ old('salary_status', isset($employee) ? $employee->salary_status : '') }}">
        </div> -->

        <div class="form-group col-md-6">
            <label for="salary">Salary:</label>
            <input type="text" name="salary" class="form-control" value="{{ old('salary', isset($employee) ? $employee->salary : '') }}">
        </div>

        <!-- <div class="form-group col-md-6">
            <label for="resignation_doc">Resignation Document:</label>
            <input type="file" name="resignation_doc" class="form-control" value="{{ old('resignation_doc', isset($employee) ? $employee->resignation_doc : '') }}">
        </div> -->
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
         bankname: 'required',
         bankaccountno: 'required',
         ifsccode: 'required',
         bankcity: 'required',
         branch: 'required',
      },
      errorElement: "div",
      errorPlacement: function (error, element) {
          error.appendTo( element.parents('.form-group') ); 
      },
   });
});
</script>
@endsection