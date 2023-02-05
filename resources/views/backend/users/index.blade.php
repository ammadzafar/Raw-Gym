@extends('layouts.master')

@section('title', 'Users')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection
@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Users @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @can('user_create')
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                                    data-target="#create-user-modal"
                                    id="create-new-member">Create
                                New User
                            </button>
                        </div>
                    @endcan
                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Register</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="create-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-user" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="Name"
                                           data-parsley-minlength="3" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone<span style="color: red"> *</span></label>
                                    <input name="phone" type="text" class="form-control"
                                           placeholder="" data-parsley-required="true" id="phone"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email<span style="color: red"> *</span></label>
                                    <input name="email" type="email" class="form-control" placeholder="Email"
                                           data-parsley-required="true" data-parsley-type="email"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control select2-multiple select2OnCreate"
                                            id="gender"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please select gender type">
                                        @if(getPossibleEnumValues('members', 'gender'))
                                            @foreach(getPossibleEnumValues('members', 'gender') as $gender)
                                                <option class="text-capitalize"
                                                        value="{{ $gender }}">{{ $gender }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth<span style="color: red"> *</span></label>
                                    <input name="dob" type="date" class="form-control" placeholder="Dob"
                                           data-parsley-required="true"
                                           data-parsley-required-message="Please select Date of Birth"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign Roles</label>
                                    <select class="select2 form-control select2-multiple select2OnCreate" name="role"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please assign Role">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Joining Date<span style="color: red"> *</span></label>
                                    <input name="date" type="date" class="form-control" placeholder="Joining Date"
                                           data-parsley-required="true"
                                           data-parsley-required-message="Please assign the joining date"/>
                                </div>
                            </div>
                            {{--<div class="col-md-6" id="total_leave">
                                <div class="form-group">
                                    <label>Annual Leaves</label>
                                    <input name="total_leaves" type="text" class="form-control"
                                           placeholder="Annual Leaves" id="" data-parsley-validation-threshold="1"
                                           data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6" id="job-type">
                                <div class="form-group">
                                    <label>Job Type<span style="color: red"> *</span></label>
                                    <input name="job_type" type="text" class="form-control"
                                           placeholder="e.g Trainer" id="" data-parsley-validation-threshold="1"
                                           data-parsley-trigger="keyup"
                                           data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Is user on Job?</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="employ_type"
                                           class="custom-control-input"
                                           id="is_employee_checkbox" value="1">
                                    <label class="custom-control-label" for="is_employee_checkbox">Assign salary to
                                        user</label>
                                </div>
                            </div>
                            <div class="col-md-12" id="is_employee_div">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Is a Personal Trainer?</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="pt"
                                                   class="custom-control-input"
                                                   id="is_pt_checkbox" value="1">
                                            <label class="custom-control-label" for="is_pt_checkbox"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-9" id="is_pt_div">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Percentage (%) <span class="text-danger">*</span></label>
                                                    <input name="pt_percentage" type="text" class="form-control"
                                                           placeholder="Percentage"
                                                           data-parsley-type="digits"
                                                           data-parsley-validation-threshold="1"
                                                           data-parsley-trigger="keyup"
                                                           data-parsley-max="100"/>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Select Members <span class="text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control select2-multiple select2OnCreate"
                                                        name="members[]"
                                                        data-placeholder="Choose ..."
                                                        data-parsley-required="true"
                                                        data-parsley-required-message="Please select members" multiple>
                                                        @forelse($members as $member)
                                                            <option
                                                                value="{{ $member->id }}">{{ $member->name }}</option>
                                                        @empty
                                                            <option selected disabled>No member!</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>User Salary <span
                                                            class="text-danger">*</span></label>
                                                    <input name="salary" type="text" class="form-control"
                                                           placeholder="Salary" id="salary"
                                                           data-parsley-validation-threshold="1"
                                                           data-parsley-trigger="keyup"
                                                           data-parsley-type="digits"/>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Shift Name <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" class="inner form-control"
                                                                               placeholder="Shift Name"
                                                                               name="shifts[0][name]"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label>From <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select
                                                                                class="select2 form-control select2-multiple appendTime select2OnCreate"
                                                                                name="shifts[0][from]"
                                                                                data-placeholder="Choose ..."
                                                                                data-parsley-required="true"
                                                                                data-parsley-required-message="Please select time">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label>To <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select
                                                                                class="select2 form-control select2-multiple appendTime select2OnCreate"
                                                                                name="shifts[0][to]"
                                                                                data-placeholder="Choose ..."
                                                                                data-parsley-required="true"
                                                                                data-parsley-required-message="Please select time">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="appendShift"></div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="button" class="btn btn-success appendMore"
                                                       value="Add Shift"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="" class="form-control" rows="4"
                                              placeholder="Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                            data-size="xs">
                                        Create
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="edit-user-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-user"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-user">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-user">

                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" id="edit_user_name"
                                           placeholder="Name" data-parsley-minlength="3" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone<span style="color: red"> *</span></label>
                                    <input name="phone" type="text" class="form-control" id="edit_user_phone"
                                           placeholder="" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email<span style="color: red"> *</span></label>
                                    <input name="email" type="email" class="form-control" id="edit_user_email"
                                           placeholder="Email" data-parsley-type="email" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control select2-multiple" id="edit_user_gender"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please select Gender">
                                        @if(getPossibleEnumValues('members', 'gender'))
                                            @foreach(getPossibleEnumValues('members', 'gender') as $gender)
                                                <option class="text-capitalize"
                                                        value="{{ $gender }}">{{ $gender }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth<span style="color: red"> *</span></label>
                                    <input name="dob" type="date" class="form-control" id="edit_user_dob"
                                           placeholder="Dob" data-parsley-required="true"
                                           data-parsley-required-message="Please select date of birth"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign Roles</label>
                                    <select class="select2 form-control select2-multiple" id="edit-user-roles"
                                            name="role"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please assign Role">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Joining Date<span style="color: red"> *</span></label>
                                    <input name="date" type="date" class="form-control" placeholder="Joining Date"
                                           data-parsley-required="true"
                                           data-parsley-required-message="Please assign the joining date"
                                           id="edit-user-date"/>
                                </div>
                            </div>
                         {{--   <div class="col-md-6">
                                <div class="form-group">
                                    <label>Annual Leaves</label>
                                    <input name="total_leaves" type="text" class="form-control"
                                           placeholder="Annual Leaves" readonly id="edit-user-total-leaves"
                                           data-parsley-validation-threshold="1"
                                           data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_job_type">Job Type<span style="color: red"> *</span></label>
                                    <input name="job_type" type="text" class="form-control"
                                           placeholder="e.g Trainer" id="edit_job_type"
                                           data-parsley-validation-threshold="1"
                                           data-parsley-trigger="keyup"
                                           data-parsley-required="true"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Is user on Job?</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="employ_type"
                                           class="custom-control-input"
                                           id="edit_is_employee_checkbox" value="1">
                                    <label class="custom-control-label" for="edit_is_employee_checkbox">Assign salary to
                                        user</label>
                                </div>
                            </div>
                            <div class="col-md-12" id="edit_is_employee_div">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Is a Personal Trainer?</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="pt"
                                                   class="custom-control-input"
                                                   id="edit_is_pt_checkbox" value="1">
                                            <label class="custom-control-label" for="edit_is_pt_checkbox"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-9" id="edit_is_pt_div">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="edit_percentage">Percentage (%) <span
                                                            class="text-danger">*</span></label>
                                                    <input name="pt_percentage" type="text" class="form-control"
                                                           placeholder="Percentage"
                                                           id="edit_percentage"
                                                           data-parsley-type="digits"
                                                           data-parsley-validation-threshold="1"
                                                           data-parsley-trigger="keyup"
                                                           data-parsley-max="100"/>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Select Members <span class="text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control select2-multiple select2OnEdit"
                                                        name="members[]"
                                                        data-placeholder="Choose ..."
                                                        id="edit_members" multiple>
                                                        @forelse($members as $member)
                                                            <option
                                                                value="{{ $member->id }}">{{ $member->name }}</option>
                                                        @empty
                                                            <option selected disabled>No member!</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>User Salary <span
                                                            class="text-danger">*</span></label>
                                                    <input name="salary" type="text" class="form-control"
                                                           placeholder="Salary"
                                                           id="edit_salary"
                                                           data-parsley-validation-threshold="1"
                                                           data-parsley-trigger="keyup"
                                                           data-parsley-type="digits"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="appendShiftOnEdit"></div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="button" class="btn btn-success appendMoreEditBtn"
                                                       value="Add Shift"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="edit_user_address" class="form-control" rows="4"
                                              placeholder="Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                            data-size="xs">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="make-salary-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Pay Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="salary-payment">

                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <table class="table table-dark">
                                        <thead>
                                        <tr>
                                            <th colspan="4" class="text-center"><h4 class="text-white">Personal Training Fees</h4></th>
                                        </tr>
                                        <tr>
                                            <th>Member Name</th>
                                            <th>PTF ({{ env('CURRENCY', 'PKR') }})</th>
                                            <th>Percentage (%)</th>
                                            <th>Amount ({{ env('CURRENCY', 'PKR') }})</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ptf_table">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-dark">
                                        <thead>
                                        <tr>
                                            <th class="text-center"><h4 class="text-white">Absents</h4></th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="absents_table">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Payment Method</label>
                                    <select class="form-control select2-multiple" id="select_payment_method"
                                            name="payment_method" data-placeholder="Choose ..."
                                            data-parsley-required="true">
                                        @foreach(getPossibleEnumValues('fees', 'payment_method') as $method)
                                            <option class="text-capitalize" value="{{ $method }}">{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Payment Date<span style="color: red"> *</span></label>
                                    <input name="payment_date" type="date" class="form-control"
                                           placeholder="Payment Data" id="member_payment_date"
                                           data-parsley-required="true"
                                           data-parsley-required-message="Please select date payment"/>
                                </div>
                            </div>
                            <div class="col-md-6" id="member_fees_div">
                                <div class="form-group">
                                    <label>Salary<span style="color: red"> *</span></label>
                                    <input name="amount" type="number" class="form-control" placeholder="Employ Salary"
                                           id="user_salary" value="" data-parsley-trigger="keyup" data-parsley-required="true"/>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="submit"
                                        class="btn btn-dark waves-effect waves-light mr-1 add-spinner"
                                        id="myButtonID" data-size="xs">

                                    Make Payment
                                </button>
                                <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="payment-history-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member_payment_history_heading">Salary Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr class="text-center">
                                <th>Payment Date</th>
                                <th>Employ Name</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="member_payment_tr">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="user-delete-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Confirm User <span id=""></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="alert alert-warning sureText" class="sureText"
                                   id="confirm_user_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_user_delete_confirmed" data-size="xs">
                                    Confirm
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="no_user_delete_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('backend.users.ajax.index')


