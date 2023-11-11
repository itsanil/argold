@extends('backend.master-layouts.main')
@section('contentHeader')
Edit Expense
@endsection
@section('contentButton')
<a class="btn btn-success btn-sm" href="{{ route('expense.view') }}">View All Expenses</a>
@endsection
@section('content.wrapper')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    @if(Auth::user()->hasrole('Branch Admin'))
    <?php 
      $branches = $branches->where('id',Auth::user()->branch_id);
    ?>
    @endif
    <div class="container-fluid">
      <div class="card-body">
        <!-- <br> -->
        <form role="form" id="forms"  method="post" action="{{ route('expense.update', $expenseEdit->id) }}">
          {{ csrf_field() }}
          <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="branch_id">Branch
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="branch_id" name="branch_id" onchange="getClient(this.value);getBank(this.value);">
              <!-- <select class="form-control select2" id="branch_id" name="branch_id" @if(Auth::user()->hasrole('Branch Admin')) readonly @endif> -->
                @if(!Auth::user()->hasrole('Branch Admin'))
                <option value="">Select</option>
                @endif
                @foreach($branches as $branch)
                  <option value="{{ $branch->id }}"  @if($expenseEdit->branch_id == $branch->id) selected @endif >{{ $branch->branch_number }}</option>
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
                  <option value="{{ $bank->id }}" @if($expenseEdit->bank_id == $bank->id) selected @endif>{{ $bank->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="category_id">Category
                <span class="requiredAstrik">*</span>
              </label>
              <select class="form-control select2" id="category_id" name="category_id">
                <option value="">Select</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" @if($expenseEdit->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount">Amount
                <span class="requiredAstrik">*</span>
              </label>
              <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount" value="{{ $expenseEdit->amount }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="date">Date
                <span class="requiredAstrik">*</span>
              </label>
              <div class="input-group date" id="reservationdate" data-target-input="nearest">
                  <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ date('d-m-Y',strtotime($expenseEdit->date)) }}">
                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remark" value="{{ $expenseEdit->remark }}">
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
  getBank('{{$expenseEdit->branch_id}}');

  function getBank(id) {
    $.ajax({
       url:"{{route('bank.getBankData')}}",
       type:'post',
       data:{
          '_token':token,
          'id':id,
          'type':'expense',
       },
       success:function (response)
       {
          $('#bank_id').html(response);
          $('#bank_id').val("{{$expenseEdit->bank_id}}");
          var max = $('option:selected', '#bank_id').attr('current_balance');
          $('#amount').attr('max',max);
          $('#bank_id').on('change',function(){
            // const selectedValue = $(this).val();
            // const selectedOption = $(this).find(`option[value="${selectedValue}"]`);
            var max = $('option:selected', this).attr('current_balance');
            $('#amount').attr('max',max);
          });
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