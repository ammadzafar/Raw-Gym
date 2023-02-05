@extends('layouts.master')

@section('title') Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Dashboard   @endslot
        @slot('title_li') Welcome to MBG Dashboard   @endslot
    @endcomponent

    <button type="button" class="dashboard-right-sidebar-btn btn btn-dark btn-sm noti-icon right-bar-toggle waves-effect">
        <i class="mdi mdi-currency-usd"></i>
        <span>Pending Fees</span>
    </button>

    <div class="row">

        <div class="col-12">
            <h3 class="card-title mb-4">Member's</h3>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Today</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentDay']['members'] }} @endslot
                                    @slot('reg_fees') {{ @$membersStats['currentDay']['reg_fees'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Yesterday</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['yesterday']['members'] }} @endslot
                                    @slot('reg_fees') {{ @$membersStats['yesterday']['reg_fees'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Current Month</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentMonth']['members'] }} @endslot
                                    @slot('reg_fees') {{ @$membersStats['currentMonth']['reg_fees'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Current Year</h3>
                            <div>
                                @component('common-components.dashboard-members-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('members') {{ @$membersStats['currentYear']['members'] }} @endslot
                                    @slot('reg_fees') {{ @$membersStats['currentYear']['reg_fees'] }} @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 dashboard-row-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Total</h3>
                    <div>
                        @component('common-components.dashboard-members-overview')
                            @slot('mainClass') pb-1  @endslot
                            @slot('members') {{ @$membersStats['currentTotal']['members'] }} @endslot
                            @slot('reg_fees') {{ @$membersStats['currentTotal']['reg_fees'] }} @endslot
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h3 class="card-title mb-4">Income/Expense</h3>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('dashboard.report.income-expense.day', ['date' => \Carbon\Carbon::today()->format('Y-m-d')]) }}"
                       class="card card-hover-pointer todayInExReportBtn">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Today</h3>
                            <div>
                                @component('common-components.dashboard-overview')
                                    @slot('mainClass') pb-1  @endslot
                                    @slot('income') {{$currentDayincome}} @endslot
                                    @slot('expense') {{$currentDayExpense}} @endslot
                                    @slot('profit') {{$currentDayprofit}}  @endslot
                                @endcomponent
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <div class="card card-hover-pointer">
                        <a href="{{ route('dashboard.report.income-expense.day', ['date' => \Carbon\Carbon::yesterday()->format('Y-m-d')]) }}">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Yesterday</h3>
                                <div>
                                    @component('common-components.dashboard-overview')
                                        @slot('mainClass') pb-1  @endslot
                                        @slot('income') {{$yesterdayIncome}} @endslot
                                        @slot('expense') {{$yesterdayExpense}} @endslot
                                        @slot('profit') {{$yesterdayProfit}}  @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-hover-pointer">
                        <a href="{{ route('dashboard.report.income-expense.month', ['month' => \Carbon\Carbon::today()->format('m-Y')]) }}">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Current Month</h3>
                                <div>
                                    @component('common-components.dashboard-overview')
                                        @slot('mainClass') pb-1  @endslot
                                        @slot('income') {{$currentmonthincome}} @endslot
                                        @slot('expense') {{$currentMonthExpense}} @endslot
                                        @slot('profit') {{$currentMonthprofit}}  @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-hover-pointer">
                        <a href="{{ route('dashboard.report.income-expense.year', ['year' => \Carbon\Carbon::today()->year]) }}">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Current Year</h3>
                                <div>
                                    @component('common-components.dashboard-overview')
                                        @slot('mainClass') pb-1  @endslot
                                        @slot('income') {{$currentYearincome}} @endslot
                                        @slot('expense') {{$currentYearExpense}} @endslot
                                        @slot('profit') {{$currentYearprofit}}  @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 dashboard-row-card">
            <div class="card card-hover-pointer">
                <div class="card-body">
                    <h3 class="card-title mb-4">Total</h3>
                    <div>
                        @component('common-components.dashboard-overview')
                            @slot('mainClass') pb-1  @endslot
                            @slot('income') {{$totalincome}} @endslot
                            @slot('expense') {{$totalExpense}} @endslot
                            @slot('profit') {{$totalprofit}}  @endslot
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Gender Chart</h4>

                    <div class="row align-items-center">
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
        <div class="col-xl-6">
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Latest Payments</h4>

                    <div class="table-responsive">
                        <table class="table table-centered datatable">
                            <thead>
                            <tr>

                                <th>Payment Date</th>
                                <th>Payment Time</th>
                                <th>Register Date</th>
                                <th>Member Name</th>
                                <th>Collected By</th>
                                <th>Reg Fees</th>
                                <th>Fees</th>
                                <th>PTF</th>
                                <th>Total Fees</th>
                                <th>Payment</th>
                                <th>Pending</th>
                                <th>Pending PTF</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($latestFees as $fees)

                                @php
                                    $memberFees = $fees->membership ? @$fees->membership->fees : @$fees->member->fee_structure;
                                @endphp

                                <tr>
                                    <td>{{ @$fees->payment_date->format('d M, Y') }}</td>
                                    <td>{{ @$fees->created_at->format('g:i A') }}</td>
                                    <td>{{ @$fees->member->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{route('member.show', @$fees->member->id)}}">{{ @$fees->member->name }}</a>
                                    </td>
                                    <td>{{ @$fees->collectedBy->name }}</td>
                                    <td>{{ $fees->reg_fee }}</td>
                                    <td>{{ $memberFees }}</td>
                                    <td>{{ @$fees->member->personal_training_fees }}</td>
                                    <td class="text-danger">{{ $fees->reg_fee + $memberFees + @$fees->member->personal_training_fees }}</td>
                                    <td class="text-success">{{ $fees->fees + $fees->personal_training_fees }}</td>
                                    <td>{{ $fees->pending_fees }}</td>
                                    <td>{{ $fees->pending_personal_training_fees }}</td>
                                    <td>{{ ucwords(@$fees->payment_method) }}</td>
                                    <td>{{ $fees->status }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-white-50">
                        <h5 class="text-white">+{{$newcustomer}} New Customer's Registered</h5>
                        <p>Click on the below button to view all customers</p>
                        <div>
                            <a href="{{ route('members', ['type' => 'all']) }}" class="btn btn-outline-success btn-sm">View
                                All</a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-8">
                            <div class="mt-4">
                                <img src="images/widget-img.png" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($todayAttendances as $attendance)
                            <tr>
                                <td>{{ $attendance->created_at->format('d M Y') }}</td>
                                <td>{{ $attendance->member->name}}</td>
                                <td>
                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                        <input type="checkbox" class="custom-control-input toggle-status-attendance" id="member-togglstatus-{{ $attendance->id }}" data-id="{{ $attendance->id }}" {{ $attendance->status == 'present' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="member-togglstatus-{{ $attendance->id }}"></label>
                                    </div>
                                </td>
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

@include('backend.dashboard.ajax.index')
