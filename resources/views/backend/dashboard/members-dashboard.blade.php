@extends('layouts.master')

@section('title') Members Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Dashboard   @endslot
        @slot('title_li') Members Dashboard   @endslot
    @endcomponent

    {{--<button type="button"
            class="dashboard-right-sidebar-btn btn btn-dark btn-sm noti-icon right-bar-toggle waves-effect d-flex align-items-center">
        <i class="mdi mdi-currency-usd" style="font-size: 15px"></i>
        <span>Pending Fees</span>
    </button>--}}

    <div class="row">

        <div class="col-12">
            <h3 class="card-title mb-4">Member's</h3>
        </div>
        <div class="col-xl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-white-50">
                        <h4 class="text-white">+{{$newcustomer}} New Customer's Registered In Last Month</h4>
                        <p class="m-0">Click on the below button to view all customers</p>
                    </div>
                    <div class="row justify-content-end align-items-center">
                        <div class="col-4">
                            <a href="{{ route('members', ['type' => 'all']) }}" class="btn btn-outline-success btn-sm">View
                                All</a>
                        </div>
                        <div class="col-8">
                            <div class="mt-4">
                                <img src="{{ asset('images/widget-img.png') }}" alt=""
                                     class="img-fluid mx-auto d-block" style="width: 8rem">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Today</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentDay']['members'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Yesterday</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['yesterday']['members'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Current Week</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentWeek']['members'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Current Month</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentMonth']['members'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Current Year</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentYear']['members'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Total</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentTotal']['members'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Customers</h4>

                    <div class="row">
                        <div class="col-lg-6 d-flex justify-content-center align-items-center">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-12">
                                    <p class="mb-2">Last 6 Months Customers</p>
                                    <h4>{{ @$membersStats['last6Months']['members'] }}</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <p class="mb-2 text-truncate">This Month</p>
                                        <h5 class="d-inline-block align-middle mb-0">{{ @$membersStats['currentMonth']['members'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <p class="mb-2 text-truncate">Last Month</p>
                                        <h5>{{ @$membersStats['lastMonth']['members'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div id="bar-chart" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Gender Chart</h4>

                    <div class="row align-items-center py-3">
                        <div class="col-sm-6">
                            <div id="genderDonatChart" class="apex-charts"></div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i
                                                    class="mdi mdi-circle text-primary mr-1"></i> Male</p>
                                            <h5>{{ @json_decode($genderDonat)[0] }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i
                                                    class="mdi mdi-circle text-success mr-1"></i> Female</p>
                                            <h5>{{ @json_decode($genderDonat)[1] }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i
                                                    class="mdi mdi-circle text-warning mr-1"></i> Trans</p>
                                            <h5>{{ @json_decode($genderDonat)[2] }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i
                                                    class="mdi mdi-circle text-danger mr-1"></i> Other</p>
                                            <h5>{{ @json_decode($genderDonat)[3] }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Customer With Memberships</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <div id="customersDonatChart" class="apex-charts"></div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="py-3">
                                                    <p class="mb-1 text-truncate"><i
                                                            class="mdi mdi-circle mr-1" style="color: #FFA81E"></i>
                                                        Membership</p>
                                                    <h5>{{ @json_decode($customersDonatChart)[0] }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="py-3">
                                                    <p class="mb-1 text-truncate"><i
                                                            class="mdi mdi-circle mr-1" style="color: #49A5FF"></i>
                                                        Without Membership</p>
                                                    <h5>{{ @json_decode($customersDonatChart)[1] }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Membership and Guest </h4>

                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>MemberShips</th>
                            <th>Number of User</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $memberships = \App\Models\Membership::withCount('members')->get();;
                        @endphp
                        @foreach($memberships as $membership)
                            <tr>

                               <td>
                                  {{$membership->name}}
                                </td>
                                <td>{{$membership->members_count}}</td>


                            </tr>
                        @endforeach
                        <tr>
                            <td><b>Guests</b></td>
                            @php
                            $guestMembers = \App\Models\Member::where('guest_member',1)->count();
                            @endphp
                            <td>{{$guestMembers}}</td>

                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Today Attendance</h4>

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
                            <tr>
                                <td>{{ $attendance->created_at->format('d M Y') }}</td>
                                <td>{{ $attendance->member->name}}</td>
{{--                                <td>--}}
{{--                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">--}}
{{--                                        <input type="checkbox" class="custom-control-input toggle-status-attendance"--}}
{{--                                               id="member-togglstatus-{{ $attendance->id }}"--}}
{{--                                               data-id="{{ $attendance->id }}" {{ $attendance->status == 'present' ? "checked" : "" }}>--}}
{{--                                        <label class="custom-control-label"--}}
{{--                                               for="member-togglstatus-{{ $attendance->id }}"></label>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
                                <td>{{ $attendance->clock_in ? $attendance->clock_in : '-' }}</td>
                                <td>{{ $attendance->clock_out ? $attendance->clock_out : '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

@endsection

@include('backend.dashboard.ajax.members-dashboard')
