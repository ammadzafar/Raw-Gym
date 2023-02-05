@extends('layouts.master')

@section('title', $year->format('Y') . ' Report')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{ $year->format('Y') }} @endslot
        @slot('li_1') Dashboard @endslot
    @endcomponent

    <div class="row">
        <div class="col-12 mb-3">
            <div class="row justify-content-between">
                <span>All Income/Expenses are shown in <b>{{ env("CURRENCY", "Ksh") }}</b></span>
                <div class="col-12 col-md-6 col-lg-4">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#byMonth" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">By Month</span>
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
        <div class="tab-pane active" id="byMonth" role="tabpanel">
            <div class="row">
                @forelse($allMonths as $data)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title mb-4">{{ @$data['month']->format('M, Y') }}</h3>
                                    <a href="{{ route('dashboard.report.income-expense.month', ['month' => @$data['month']->format('m-Y')]) }}"
                                       class="text-primary" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div>
                                    <a href="{{ route('dashboard.report.income-expense.month', ['month' => @$data['month']->format('m-Y')]) }}"
                                       data-toggle="modal" data-target="#showMonthIncomeReportModal"
                                       class="card-hover-pointer monthInExReportBtn">
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
                                <h3 class="card-title mb-4">This Year</h3>
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
                                        <td>{{$fee->extra_charges}}</td>
                                        <td>{{$fee->classes_fees}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No income found!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"><b>Total: </b>{{ $allIncomeTotal }} {{ env("CURRENCY", "Ksh") }}</td>
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
                                    <td colspan="3" class="text-right"><b>Total: </b>{{ $allExpenseTotal }} {{ env("CURRENCY", "Ksh") }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="showMonthIncomeReportModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"><span id="month_date"></span> | Income/Expense Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="daysCards">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.dashboard.modals.show-day-income-report-modal')

@endsection

@include('backend.dashboard.ajax.year-income-expense-report')


