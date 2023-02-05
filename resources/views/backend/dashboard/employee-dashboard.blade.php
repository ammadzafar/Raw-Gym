@extends('layouts.master')

@section('title') Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .checked-out{
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Dashboard   @endslot
        @slot('title_li') Welcome to RAW GYM Dashboard   @endslot
    @endcomponent

    <div class="row">

       {{-- @if($user->employ_type)
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between">
                    <h6>Mark Your Today Attendance</h6>
                    <div class="">
                        @if($user->userAttendances()->exists())
                            @forelse($shifts as $shift)

                                @php
                                    $shiftFrom = \Carbon\Carbon::createFromFormat('g A', $shift->from);
                                    $attendance = $user->userAttendances()->where('shift_time', $shiftFrom)->firstOrFail();

                                    $btnClass = '';
                                    $type = '';
                                    $text = '';
                                    if($attendance->clock_in && !$attendance->clock_out) {
                                        $btnClass = 'btn-danger';
                                        $type = 'clock-out';
                                        $text = 'Clock Out';
                                    } else {
                                        $btnClass = 'btn-warning';
                                        $type = 'clock-in';
                                        $text = 'Clock In';
                                    }
                                @endphp

                                <button class="btn btn-box btn-sm markAttendanceBtn {{ $btnClass }}"
                                        data-type="{{ $type }}"
                                        data-shift-name="{{ $shift->name }}" data-shift-from="{{ $shift->from }}"><b
                                        class="text-dark">{{ $shift->name }}: </b><span>{{ $text }}</span></button>
                            @empty
                                <button class="bth btn-box btn-warning btn-sm" disabled>No Shift!</button>
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        @endif--}}

        <div class="col-md-12 col-xl-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            @php
                                                $today = \Carbon\Carbon::today()->format("l,d F Y");
                                            @endphp
                                            <h1> {{$today}}</h1>
                                            <p>Welcome {{ auth()->user()->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($user->hasRole('super-admin'))
                            @if($salariesData)
                                <div class="col-12">
                                    <h3>Salaries To Be Transferred</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($salariesData as $data)
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">{{ $data['user']->name }}</h4>
                                                        <p class="m-0">
                                                            <b>Month: </b>{{ $data['monthStartDate']->format('M, Y') }}
                                                        </p>
                                                        <p class="m-0"><b>Total
                                                                Salary: </b>{{ $data['userTotalSalary'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

               {{--@if($user->employ_type)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Payments</h4>

                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 datatable">
                                            <thead>
                                            <tr>
                                                <th>Register Date</th>
                                                <th>Salary</th>
                                                <th>Receive Amount</th>
                                                <th>Receive Date</th>
                                                <th>Receive Time</th>
                                                <th>Payment Method</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($salaries as $salary)
                                                <tr>
                                                    <td>{{$user->created_at->format('d F Y')}}</td>
                                                    <td>{{$user->salary?$user->salary:"---"}}</td>
                                                    <td>{{$salary->amount}}</td>
                                                    <td>{{$salary->payment_date->format('d F Y')}}</td>
                                                    <td>{{$salary->created_at->format('g:i A')}}</td>
                                                    <td>{{$salary->payment_method}}</td>
                                                </tr>
                                            @empty
                                                <tr class="text-center">
                                                    <td colspan="6">No salary exist!</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif--}}
                    </div>
                    {{-- daily attendance--}}
{{--                    @if($user->hasRole('super-admin'))--}}
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 style="text-align: right">
{{--                                    <a class="btn btn-success" href="{{route('attendances.days')}}">Daily</a>--}}
                                    <a class="btn btn-secondary" href="{{route('dashboard.report')}}">Report</a>
                                </h4>
                                <table class="table datatable table-bordered dt-responsive nowrap w-100"
                                       style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($todayAttendances as $attendance)
                                        <tr class="attend_records">
                                            <td>{{ $attendance->created_at->format('d M Y') }}</td>
                                            <td>{{ $attendance->member->name}}</td>
                                            <td>
                                                {{-- @if($attendance->status == 'present')
                                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                                        <input type="checkbox" class="custom-control-input toggle-status-attendance clock-in"
                                                               id="member-togglstatus-{{ $attendance->id }}"
                                                               data-id="{{ $attendance->id }}" >
                                                        <label class="custom-control-label"
                                                               for="member-togglstatus-{{ $attendance->id }}"></label>
                                                    </div>
                                                @else
                                                    <h6 style="color: darkgreen">Clocked In</h6>
                                                @endif --}}


                                                @if($attendance->clock_in == null)
                                                    <div class="custom-control custom-switch d-inline-block checked-out" dir="ltr">
                                                        <button type="button" data-id="{{ $attendance->id }}" class="btn btn-primary toggle-status-attendance clock-in" id="member-togglstatus-{{ $attendance->id }}" >Clocked-in</button>
                                                    </div>
                                                @else
                                                    <h6 style="color: darkgreen">{{ $attendance->clock_in }}</h6>
                                                @endif

                                            </td>
                                            <td class="clock_btn_dist">
                                                {{-- @if($attendance->status == 'absent')
                                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                                        <input type="checkbox" class="custom-control-input toggle-status-attendance clock-out"
                                                               id="member-togglstatus-{{ $attendance->id }}"
                                                               data-id="{{ $attendance->id }}" >
                                                        <label class="custom-control-label"
                                                               for="member-togglstatus-{{ $attendance->id }}"></label>
                                                    </div>
                                                @else
                                                    <h6 style="color: red">Clocked Out</h6>
                                                @endif --}}


                                                @if($attendance->clock_out == null)
                                                    <div class="custom-control custom-switch d-inline-block checked-out" dir="ltr">
                                                               <button type="button" class="example btn btn-success toggle-status-attendance clock-out" id="member-togglstatus-{{ $attendance->id }}" data-id="{{ $attendance->id }}" {{ $attendance->clock_in == null ? 'disabled': '' }}>Clocked-out</button>
                                                    </div>
                                                @else
                                                    <h6 style="color: red">{{ $attendance->clock_out }}</h6>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
{{--                        @endif--}}
                </div>

            </div>

        </div>

{{--        <div class="col-md-12 col-xl-3">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="profile-widgets py-3">--}}

{{--                        <div class="text-center">--}}
{{--                            <div class="">--}}
{{--                                <a class="member-profile-image">--}}
{{--                                    <img--}}
{{--                                        src="{{ asset($user->image??'images/users/noprofile.jfif') }}"--}}
{{--                                        alt=""--}}
{{--                                        class="avatar-lg mx-auto img-thumbnail rounded-circle">--}}
{{--                                    <div class="online-circle"><i class="fas fa-circle text-success"></i></div>--}}
{{--                                </a>--}}
{{--                            </div>--}}

{{--                            <div class="mt-3 ">--}}
{{--                                <a href="#" class="text-dark font-weight-medium font-size-16"></a>--}}
{{--                                <p class="text-body mt-1 mb-1">--}}
{{--                                <h5><b>{{$user->name}} </b></h5>--}}
{{--                                </p>--}}
{{--                                <p class="text-body mt-1 mb-1"></p>--}}
{{--                                <small><a href="{{ route('profile') }}" target="_blank"><i>Go to profile--}}
{{--                                            page</i></a></small>--}}
{{--                            </div>--}}

{{--                           <div class="mt-4">--}}

{{--                                 <ui class="list-inline social-source-list">--}}
{{--                                     <li class="list-inline-item">--}}
{{--                                         <div class="avatar-xs">--}}
{{--                                                             <span class="avatar-title rounded-circle">--}}
{{--                                                                     <i class="mdi mdi-facebook"></i>--}}
{{--                                                                 </span>--}}
{{--                                         </div>--}}
{{--                                     </li>--}}

{{--                                     <li class="list-inline-item">--}}
{{--                                         <div class="avatar-xs">--}}
{{--                                                             <span class="avatar-title rounded-circle bg-info">--}}
{{--                                                                     <i class="mdi mdi-twitter"></i>--}}
{{--                                                                 </span>--}}
{{--                                         </div>--}}
{{--                                     </li>--}}

{{--                                     <li class="list-inline-item">--}}
{{--                                         <div class="avatar-xs">--}}
{{--                                                             <span class="avatar-title rounded-circle bg-danger">--}}
{{--                                                                 <i class="mdi mdi-google-plus"></i>--}}
{{--                                                             </span>--}}
{{--                                         </div>--}}
{{--                                     </li>--}}

{{--                                     <li class="list-inline-item">--}}
{{--                                         <div class="avatar-xs">--}}
{{--                                                             <span class="avatar-title rounded-circle bg-pink">--}}
{{--                                                                 <i class="mdi mdi-instagram"></i>--}}
{{--                                                             </span>--}}
{{--                                         </div>--}}
{{--                                     </li>--}}
{{--                                 </ui>--}}

{{--                             </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title mb-3">Personal Information</h5>--}}


{{--                    <p class="card-title-desc">--}}

{{--                    </p>--}}


{{--                    <div class="mt-3">--}}
{{--                        <p class="font-size-12 text-muted mb-1">Email</p>--}}
{{--                        <h6 class="">{{$user->email}}</h6>--}}
{{--                    </div>--}}
{{--                    <div class="mt-3">--}}
{{--                        <p class="font-size-12 text-muted mb-1">Phone number</p>--}}
{{--                        <h6 class="">{{$user->phone}}</h6>--}}
{{--                    </div>--}}
{{--                    <div class="mt-3">--}}
{{--                        <p class="font-size-12 text-muted mb-1">Date of Birth</p>--}}
{{--                        <h6 class="">{{$user->dob?$user->dob->format('d F Y'):'---'}}</h6>--}}
{{--                    </div>--}}
{{--                    <div class="mt-3">--}}
{{--                        <p class="font-size-12 text-muted mb-1">Register Date</p>--}}
{{--                        <h6 class="">{{$user->created_at->format('d F  Y')}}</h6>--}}
{{--                    </div>--}}
{{--                    <div class="mt-3">--}}
{{--                        <p class="font-size-12 text-muted mb-1">Status</p>--}}

{{--                        <h6 class="{{ $user->status ? 'text-success' : 'text-danger' }}">{{ $user->status ? 'Active' : 'Inctive' }}</h6>--}}
{{--                    </div>--}}
{{--                    <div class="mt-3">--}}
{{--                        <p class="font-size-12 text-muted mb-1">Address</p>--}}
{{--                        <h6 class=""></h6>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}


    </div>

    <!-- end row -->

    <!-- Right Sidebar -->
    {{-- @include('layouts.right-sidebar')--}}
    <!-- /Right-bar -->

@endsection

@include('backend.dashboard.ajax.employee-dashboard')
