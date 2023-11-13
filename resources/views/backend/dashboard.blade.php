@extends('backend.master-layouts.main')

@section('contentHeader')
  Dashboard
@endsection

@section('content.wrapper')
<section class="content">
  <!-- Default box -->
  <div class="container-fluid">
    <!-- <br> -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$employee->count()}}</h3>
            <p>Employee</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$vendor->count()}}
            </h3>
            <p>Vendor</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ route('vendor.view') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
    </div>
  <!-- /.modal-dialog -->
</section>
@endsection

@section('js')
@endsection
