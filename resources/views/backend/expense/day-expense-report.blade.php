@extends('layouts.master')

@section('title', $date . ' | Expense Report')

@section('css')
    <link href="{{ URL::asset('/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{$date}} @endslot
        @slot('li_1') Expense @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @include('backend.expense.modals.create-expense')

                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount ({{ env('CURRENCY', 'Ksh') }})</th>
                            <th>Label</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-------------- Edit Expense Modal ----------------}}

    <div class="modal fade bs-example-modal-lg" id="Edit-expense-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-expense">

                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date<span style="color: red"> *</span></label>
                                    <input name="date" id="edit-expense-date" type="date" class="form-control"
                                           placeholder="Name" data-parsley-minlength="4" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Label<span style="color: red"> *</span></label>
                                    <input id="edit-expense-label" name="label" type="text" class="form-control"
                                           placeholder="Label" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount ({{ env("CURRENCY", "Ksh") }})<span style="color: red"> *</span></label>
                                    <input id="edit-expense-amount" name="amount" type="number" class="form-control"
                                           placeholder="amount" data-parsley-type="digits"
                                           data-parsley-required="true" data-parsley-required="true" data-parsley-required-message="Amount should be in digit"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" id="edit-expense-status" class="form-control select2-multiple"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please select expense type">
                                        @if ($statuses)
                                            @foreach ($statuses as $status)
                                                <option class="text-capitalize" value="{{ $status }}">
                                                    {{ $status }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                            data-size="xs">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="delete-expense-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Confirm Delete <span id="locker_number"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="alert alert-warning sureText" class="sureText" id="confirm_expense_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_expense_delete_confirmed"  data-size="xs" >
                                    Confirm
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="no_expense_delete_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('backend.expense.ajax.day-expense-report')
