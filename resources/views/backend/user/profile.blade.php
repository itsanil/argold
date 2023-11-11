@extends('backend.master-layouts.main')

@section('contentHeader')
    User Profile
@endsection
@section('content.wrapper')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @php
                            $email = "vishal@tingmail.in";
                            $default = "https://www.somewhere.com/homestar.jpg";
                            $size = 200;
                            $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;   
                            @endphp
                            <img class="profile-user-img img-fluid img-circle" src="@if(Auth::user()->photo)
                                {{ asset(Auth::user()->photo) }}
                                @else{{ $grav_url }}@endif" alt="User profile picture">
                        </div>
                        
                        <h3 class="profile-username text-center">{{ auth()->user()->email }}
                        @if(Auth::user()->hasRole('Branch Admin'))
                            <br>
                          {{ Auth::user()->branchDetail->branch_number }}
                        @endif
                        </h3>
                        <p class="text-muted text-center">{{ auth()->user()->getRoleNames()[0] }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <?php 
                                date_default_timezone_set("Asia/Calcutta"); 
                                 ?>
                                <b>Date</b> <a class="float-right">{{ date('d F Y h:i A') }}</a>
                                <!-- <b>Date</b> <a class="float-right">{{ date('d F Y H:i A',strtotime(auth()->user()->created_at)) }}</a> -->
                            </li>
                        </ul>
                        @if(Auth::user()->hasRole('Super-Admin'))
                        <a href="{{route('profile.edit', ['id' => auth()->user()->id])}}" class="btn btn-primary btn-center"><b>Update Password</b></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection