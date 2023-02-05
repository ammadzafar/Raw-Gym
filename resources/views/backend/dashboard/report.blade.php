@extends('layouts.master')

@section('title') Report @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
{{--    <link href="{{ URL::asset('/libs/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>--}}

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <style>
        .checked-out{
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Dashboard   @endslot
        @slot('title_li') Report  @endslot
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

                                        <div class="col-md-3">
                                            <label>Name</label>
                                            <input type="text" id="filter_name" name="name" class="form-control" placeholder="name" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Membership</label>
                                            <select name="membership" id="filter_membership" class="form-control" >
                                                <option value="">Select Membership</option>
                                                <option value="guest">Guest</option>
                                                <option value="member">Member</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Date</label>
                                            <input class="form-control daterange" type="text" name="daterange" id="filter_date" value="" placeholder="Select Date Range" autocomplete="off"/>
                                        </div>
                                        <div class="mt-4" align="center">
                                            <button type="button" name="filter" id="filter" class="btn btn-info ml-3">Filter</button>

                                            <button type="button" name="reset" id="reset" class="btn btn-secondary ml-3">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        @if($user->hasRole('super-admin'))--}}
{{--                            @if($salariesData)--}}
{{--                                <div class="col-12">--}}
{{--                                    <h3>Salaries To Be Transferred</h3>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="row">--}}
{{--                                        @foreach($salariesData as $data)--}}
{{--                                            <div class="col-md-4">--}}
{{--                                                <div class="card">--}}
{{--                                                    <div class="card-body">--}}
{{--                                                        <h4 class="card-title">{{ $data['user']->name }}</h4>--}}
{{--                                                        <p class="m-0">--}}
{{--                                                            <b>Month: </b>{{ $data['monthStartDate']->format('M, Y') }}--}}
{{--                                                        </p>--}}
{{--                                                        <p class="m-0"><b>Total--}}
{{--                                                                Salary: </b>{{ $data['userTotalSalary'] }}</p>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endif--}}

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

{{--                                <h4 style="text-align: right"><a class="btn btn-success" href="{{route('attendances.days')}}">Daily</a> <a class="btn btn-secondary" href="{{route('attendances.months')}}">Monthly</a> </h4>--}}

                                <table id="attendance_data" class="table datatable table-bordered dt-responsive nowrap w-100"
                                       style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                    </tr>
                                    </thead>


{{--                                    <tbody class="search-data">--}}
{{--                                    @foreach($attendances as $attendance)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ $attendance->created_at->format('d M Y') }}</td>--}}
{{--                                            <td> {{ $attendance->member->name }} </td>--}}
{{--                                            <td>--}}
{{--                                                --}}{{-- @if($attendance->status == 'present')--}}
{{--                                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">--}}
{{--                                                        <input type="checkbox" class="custom-control-input toggle-status-attendance clock-in"--}}
{{--                                                               id="member-togglstatus-{{ $attendance->id }}"--}}
{{--                                                               data-id="{{ $attendance->id }}" >--}}
{{--                                                        <label class="custom-control-label"--}}
{{--                                                               for="member-togglstatus-{{ $attendance->id }}"></label>--}}
{{--                                                    </div>--}}
{{--                                                @else--}}
{{--                                                    <h6 style="color: darkgreen">Clocked In</h6>--}}
{{--                                                @endif --}}


{{--                                                    <div class="custom-control custom-switch d-inline-block checked-out" dir="ltr">--}}
{{--                                                        <button type="button" data-id="2" class="btn btn-primary toggle-status-attendance clock-in" id="member-togglstatus" >Clocked-in</button>--}}
{{--                                                    </div>--}}


{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                --}}{{-- @if($attendance->status == 'absent')--}}
{{--                                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">--}}
{{--                                                        <input type="checkbox" class="custom-control-input toggle-status-attendance clock-out"--}}
{{--                                                               id="member-togglstatus-{{ $attendance->id }}"--}}
{{--                                                               data-id="{{ $attendance->id }}" >--}}
{{--                                                        <label class="custom-control-label"--}}
{{--                                                               for="member-togglstatus-{{ $attendance->id }}"></label>--}}
{{--                                                    </div>--}}
{{--                                                @else--}}
{{--                                                    <h6 style="color: red">Clocked Out</h6>--}}
{{--                                                @endif --}}


{{--                                                    <div class="custom-control custom-switch d-inline-block checked-out" dir="ltr">--}}
{{--                                                        <button type="button" class="btn btn-success toggle-status-attendance clock-out" id="member-togglstatus" data-id="">Clocked-out</button>--}}
{{--                                                    </div>--}}

{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}


                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12"  id="attend_per" >
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <table id="attendance_percenatge" class="table datatable table-bordered dt-responsive nowrap w-100"
                                           style="border-collapse: collapse; border-spacing: 0;">

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                        @endif--}}
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Member Attendance Report Chart</h4>
                                <div id="payment-chart" class="apex-charts">

                                </div>
                            </div>
                        </div>
                    </div>
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

@include('backend.dashboard.ajax.dashboard-report')
