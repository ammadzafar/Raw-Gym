@extends('layouts.master')

@section('title', 'Expense')

@section('css')
    <link href="{{ URL::asset('/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Expense @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            @include('backend.expense.modals.create-expense')
        </div>
    </div>

    <div class="row expenses_list">

        @forelse($expensesDates as $expense)
            <div class="col-md-3">
                <a href="{{ route('expense.report.day', ['date' => @$expense['date']->format('Y-m-d')]) }}"
                   class="card card-hover-pointer">
                    <div class="card-body">
                        <h3 class="card-title mb-4">{{ @$expense['date']->format('d M, Y') }}</h3>
                        <div>
                            <div class="pb-1 text-secondary mt-2">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <table class="w-100">
                                            <tbody>
                                            <tr>
                                                <th>Total Expenses</th>
                                                <td>{{ @$expense['count'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Amount</th>
                                                <td>{{ @$expense['amount'] }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="pb-1 text-secondary mt-2">
                            <div class="row align-items-center">
                                <div class="col-12 text-center">
                                    <h2>No record found!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                {{ $expensesDates->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
@include('backend.expense.ajax.index')
