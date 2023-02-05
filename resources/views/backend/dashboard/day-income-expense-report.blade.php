@extends('layouts.master')

@section('title', $date->format('d M, Y') . ' Report')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{ $date->format('d M, Y') }} @endslot
        @slot('li_1') Dashboard @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6>Class Income:{{$classIncome}} {{ env("CURRENCY", "Ksh") }}</h6>
                    <h6>Other Income: {{$totalIncome-$classIncome}} {{ env("CURRENCY", "Ksh") }}</h3>
                    <h6 class="border-bottom">Expense: {{$totalExpense}}  {{ env("CURRENCY", "Ksh") }}</h3>

                    <h6>Profit: {{ $totalIncome - $totalExpense }} {{ env("CURRENCY", "Ksh") }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body height-100vh">
                    <h5>Income</h5>
                    <table class="table datatable table-borderless dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Collected By</th>
                            <th>Member Name</th>
                            <th>Reg Fees </th>
                            <th>Fees</th>
                            <th>PTF</th>
                            <th>IHTF</th>
                            <th>Discount</th>
                            <th>Extra Charges</th>
                            <th>Classes Fees</th>
                            <th>Fees Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($income as $fee)
                            @if(!empty($fee->member->id))
                            <tr>
                                <td>{{ $fee->collectedBy->name }}</td>
                                <td>{{ $fee->member->name }}</td>
                                <td>{{ $fee->reg_fee }}</td>
                                <td>{{ ($fee->fees - $fee->discount) }}</td>
                                <td>{{ $fee->personal_training_fees }}</td>
                                <td>{{ $fee->in_house_training_fees }}</td>
                                <td>{{ $fee->discount }}</td>
                                <td>{{ $fee->extra_charges }}</td>
                                <td>{{ $fee->classes_fees }}</td>
                                <td>{{ $fee->total_payment }}</td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><b>Total: </b>{{ $totalIncome }}</td>
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
                            <th>Label</th>
                            <th>Amount ({{ env("CURRENCY", "Ksh") }})</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                            <tr>
                                <td>{{ $expense->label }}</td>
                                <td>{{ $expense->amount }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><b>Total: </b>{{ $totalExpense }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('backend.dashboard.ajax.day-income-expense-report')


