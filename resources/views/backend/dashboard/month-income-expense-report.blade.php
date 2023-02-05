@extends('layouts.master')

@section('title', $month->format('M, Y') . ' Report')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{ $month->format('M, Y') }} @endslot
        @slot('li_1') Dashboard @endslot
    @endcomponent

    <div class="row">
        <div class="col-12 mb-3">
            <div class="row justify-content-between">
                <span>All Income/Expenses are shown in <b>{{ env("CURRENCY", "Ksh") }}</b></span>
                <div class="col-12 col-md-6 col-lg-4">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#byDays" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">By Days</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#all" role="tab">
                                <span class="d-none d-sm-block">All</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="byDays" role="tabpanel">
            <div class="row">
                @forelse($allDays as $data)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title mb-4">{{ @$data['date']->format('d M, Y') }}</h3>
                                    <a href="{{ route('dashboard.report.income-expense.day', ['date' => @$data['date']->format('Y-m-d')]) }}"
                                       class="text-primary" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div>
                                    <a href="{{ route('dashboard.report.income-expense.day', ['date' => @$data['date']->format('Y-m-d')]) }}"
                                       data-toggle="modal" data-target="#showDayIncomeReportModal"
                                       class="card-hover-pointer todayInExReportBtn">
                                        @component('common-components.dashboard-overview')
                                            @slot('mainClass') pb-1  @endslot
                                            @slot('income') {{ @$data['income'] }} @endslot
                                            @slot('expense') {{ @$data['expense'] }} @endslot
                                            @slot('profit') {{ @$data['profit'] }}  @endslot
                                        @endcomponent
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Today</h3>
                                <div class="pb-1 text-secondary mt-2">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <h2>No record found!</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="tab-pane" id="all" role="tabpanel">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body height-100vh">
                            <h5>Income</h5>
                            <table class="table datatable table-borderless dt-responsive nowrap w-100"
                                   style="border-collapse: collapse; border-spacing: 0;">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Collected By</th>
                                    <th>Member</th>
                                    <th>Reg Fees</th>
                                    <th>Fees</th>
                                    <th>PTF</th>
                                    <th>IHTF</th>
                                    <th>Extra Charges</th>
                                    <th>Classes Fees</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($allIncome as $fee)
                                    <tr>
                                        <td>{{ $fee->payment_date->format('d M, Y') }}</td>
                                        <td>{{ @$fee->collectedBy->name??'---' }}</td>
                                        <td>{{ $fee->member->name }}</td>
                                        <td>{{ $fee->reg_fee }}</td>
                                        <td>{{ $fee->fees }}</td>
                                        <td>{{ $fee->personal_training_fees }}</td>
                                        <td>{{ $fee->in_house_training_fees }}</td>
                                        <td>{{ $fee->extra_charges }}</td>
                                        <td>{{ $fee->classes_fees }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No income found!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"><b>Total: </b>{{ $allIncomeTotal }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body height-100vh">
                            <h5>Expense</h5>
                            <table class="table datatable table-borderless dt-responsive nowrap w-100"
                                   style="border-collapse: collapse; border-spacing: 0;">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Label</th>
                                    <th>Amount ({{ env("CURRENCY", "Ksh") }})</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($allExpenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense->date->format('d M, Y') }}</td>
                                        <td>{{ $expense->label }}</td>
                                        <td>{{ $expense->amount }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No expense found!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><b>Total: </b>{{ $allExpenseTotal }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.dashboard.modals.show-day-income-report-modal')

@endsection

@include('backend.dashboard.ajax.month-income-expense-report')
