@extends('layouts.master')

@section('title') Income/Expense Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Dashboard   @endslot
        @slot('title_li') Income/Expense Dashboard   @endslot
    @endcomponent

  {{--  <button type="button"
            class="dashboard-right-sidebar-btn btn btn-dark btn-sm noti-icon right-bar-toggle waves-effect d-flex align-items-center">
        <i class="mdi mdi-currency-usd" style="font-size: 15px"></i>
        <span>Pending Fees</span>
    </button>--}}

    <div class="row">

        <div class="col-12 d-flex justify-content-between">
            <h3 class="card-title mb-4">Income/Expense</h3>
        </div>
        <div class="col-md-12">
            <div class="row justify-content-between">
                <div class="col-sm-6 col-md-4 col-lg-2 px-0">
                    <div class="card card-hover-pointer rounded-0 shadow-none border-right mb-sm-0">
                        <a href="{{ route('dashboard.report.income-expense.day', ['date' => \Carbon\Carbon::today()->format('Y-m-d')]) }}">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Today</h3>
                                <div>
                                    @component('common-components.dashboard-overview')
                                        @slot('mainClass') pb-1  @endslot
                                        @slot('income') {{$currentDayincome}} @endslot
                                        @slot('expense') {{$currentDayExpense}} @endslot
                                        @slot('profit') {{$currentDayprofit}} @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-2 px-0">
                    <div class="card card-hover-pointer rounded-0 shadow-none border-right mb-sm-0">
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
                <div class="col-sm-6 col-md-4 col-lg-2 px-0">
                    <div class="card card-hover-pointer rounded-0 shadow-none border-right mb-sm-0">
                        <a href="{{ route('dashboard.report.income-expense.week') }}">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Current Week</h3>
                                <div>
                                    @component('common-components.dashboard-overview')
                                        @slot('mainClass') pb-1  @endslot
                                        @slot('income') {{$currentWeekIncome}} @endslot
                                        @slot('expense') {{$currentWeekExpense}} @endslot
                                        @slot('profit') {{$currentWeekProfit}}  @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-2 px-0">
                    <div class="card card-hover-pointer rounded-0 shadow-none border-right mb-sm-0">
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
                <div class="col-sm-6 col-md-4 col-lg-2 px-0">
                    <div class="card card-hover-pointer rounded-0 shadow-none border-right">
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
                <div class="col-sm-6 col-md-4 col-lg-2 px-0">
                    <div class="card card-hover-pointer rounded-0 shadow-none border-right">
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
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-4">Income/Expense</h4>
                                <select name="filter" class="border-0 bg-light rounded" id="incomeExpenseChartFilter">
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="week">Current Week</option>
                                    <option value="month">Current Month</option>
                                    <option value="year">Current Year</option>
                                    <option value="all" selected>All Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <div id="InExDonatChart" class="apex-charts"></div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="py-3">
                                                    <p class="mb-1 text-truncate"><i
                                                            class="mdi mdi-circle mr-1" style="color: #49A5FF"></i>
                                                        Income</p>
                                                    <h5 class="incomeCountChart">{{@$totalincome}} </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="py-3">
                                                    <p class="mb-1 text-truncate"><i
                                                            class="mdi mdi-circle mr-1" style="color: #FFA81E"></i>
                                                        Expense</p>
                                                    <h5 class="expenseCountChart">{{ @$totalExpense }} </h5>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="py-3">
                                                    <p class="mb-1 text-truncate"><i
                                                            class="mdi mdi-circle mr-1" style="color: #27bf00"></i>
                                                        Profit</p>
                                                    <h5 class="profitCountChart">{{ @$totalprofit }}</h5>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Income/Expense Report</h4>
                    <div id="line-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>
        {{--<div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Latest Payments</h4>

                    <div class="table-responsive">
                        <table class="table table-centered datatable">
                            <thead>
                            <tr>

                                <th>Payment Date</th>
                                <th>Member Name</th>
                                <th>Collected By</th>
                                <th>Total Fees </th>
                                <th>Payment </th>
                                <th>Total Pending </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($latestFees as $fees)

                                @php
                                    $memberFees = $fees->membership ? @$fees->membership->fees : @$fees->fees;
                                @endphp
                                @if(@!empty($fees->member->id))

                                <tr>
                                    <td>{{ @$fees->payment_date->format('d M, Y') . ' | ' . $fees->created_at->format('g:i A') }}</td>
                                    <td>
                                        <b class="d-flex align-items-center">
                                            <img src="{{ asset($fees->member->image ?? 'images/users/noprofile.jfif') }}"
                                                 alt=""
                                                 class="rounded-circle" width="35" height="35">
                                            <a class="text-dark ml-2" href="{{route('member.show', $fees->member->id)}}">{{ @$fees->member->name }}</a>
                                        </b>
                                    </td>
                                    <td>{{ @$fees->collectedBy->name }}</td>
                                    <td class="text-danger">{{$fees->pending_fees?($fees->reg_fee + $memberFees + @$fees->personal_training_fees+$fees->pending_fees):$memberFees+$fees->reg_fee + $fees->personal_training_fees +$fees->extra_charges +$fees->classes_fees }}</td>
                                    <td class="text-success">{{ $fees->total_payment }}</td>
                                    <td>{{ $fees->pending_fees + $fees->pending_personal_training_fees }}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>
    <!-- end row -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

@endsection

@include('backend.dashboard.ajax.income-expense-dashboard')
