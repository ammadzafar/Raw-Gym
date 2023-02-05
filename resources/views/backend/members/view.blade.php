@extends('layouts.master')

@section('title') Profile @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Profile  @endslot
        @slot('li_1') Pages  @endslot
    @endcomponent

    <!-- start row -->
    <div class="row">
        <div class="col-md-12 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="profile-widgets py-3">

                        <div class="text-center">
                            <div class="">
                                <a class="member-profile-image"
                                   href="{{ asset($member->image ?? 'images/users/noprofile.jfif') }}">
                                    <img src="{{ asset($member->image ?? 'images/users/noprofile.jfif') }}" alt=""
                                         class="avatar-lg mx-auto img-thumbnail rounded-circle">
                                    <div class="online-circle"><i class="fas fa-circle text-success"></i></div>
                                </a>
                            </div>

                            <div class="mt-3 ">
                                <a href="#" class="text-dark font-weight-medium font-size-16">{{ $member->name }}</a>
                                <p class="text-body mt-1 mb-1"><small><b>Roll No: </b>{{ $member->roll_number }}</small>
                                </p>
                                <p class="text-body mt-1 mb-1">{{ ucwords($member->gender) }}</p>
                                <span class="badge badge-{{ $member->guest_member == false ?  $member->is_expired ? 'danger' : 'success' : ''}}">
                                    {{ $member->guest_member == false ? $member->is_expired ? 'Expired' : 'Not Expired' : '' }}
                                </span>
                            </div>

                            <div class="mt-4">

                                <ui class="list-inline social-source-list">
                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle">
                                                                    <i class="mdi mdi-facebook"></i>
                                                                </span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-info">
                                                                    <i class="mdi mdi-twitter"></i>
                                                                </span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-danger">
                                                                <i class="mdi mdi-google-plus"></i>
                                                            </span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-pink">
                                                                <i class="mdi mdi-instagram"></i>
                                                            </span>
                                        </div>
                                    </li>
                                </ui>

                            </div>
                            @if($member->createdBy()->exists())
                                <div class="mt-4">

                                    <b>Created By:</b> <span
                                        class="text-success ">{{$member->createdBy->name??'---'}}</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Personal Information</h5>

                    {{--                    <p class="card-title-desc">--}}
                    {{--                        Hi I'm Patrick Becker, been industry's standard dummy ultrices Cambridge.--}}
                    {{--                    </p>--}}

                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Email Address</p>
                        <h6 class="">{{ $member->email }}</h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Phone number</p>
                        <h6 class="">{{ $member->phone }}</h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Date of Birth</p>
                        <h6 class="">{{ $member->dob?$member->dob->format('d F Y'):'---' }}</h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Register Date</p>
                        <h6 class="">{{ $memberRedDate->format('d F Y') }}</h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Status</p>
                        <h6 class="{{ $member->status ? 'text-success' : 'text-danger' }}">{{ $member->status ? 'Active' : 'Inctive' }}</h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Address</p>
                        <h6 class="">{{ $member->address }}</h6>
                    </div>

                </div>
            </div>

            {{--            <div class="card">--}}
            {{--                <div class="card-body">--}}
            {{--                    <h5 class="card-title mb-2">My Top Skills</h5>--}}
            {{--                    <p class="text-muted">Suspendisse mattis rutrum orci eu pellentesque. </p>--}}
            {{--                    <ul class="list-unstyled list-inline language-skill mb-0">--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>java</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>Javascript</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>laravel</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>HTML5</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>android</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>zengo</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>python</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>react</span></li>--}}
            {{--                        <li class="list-inline-item badge badge-primary"><span>php</span></li>--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}

        </div>

        <div class="col-md-12 col-xl-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <p class="mb-2">Membership</p>
                                            <h4 class="mb-0">{{ $member->membership ? $member->membership->name : 'No Membership' }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <p class="mb-2">Reg Fees ({{ env('CURRENCY', 'Ksh') }})</p>
                                            <h4 class="mb-0">{{ $member->membership ? @$member->membership->reg_fee : @$member->reg_fee }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <p class="mb-2">Fees ({{ env('CURRENCY', 'Ksh') }}) <small
                                                    class="fees-show-hide-btn"><a href="#"
                                                                                  class="show_fees_btn"
                                                                                  data-toggle="modal"
                                                                                  data-target="#verify-user-modal">(show)</a></small>
                                            </p>
                                            <h4 class="mb-0 show_member_fees">* * * * *</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <p class="mb-2">PTF ({{ env('CURRENCY', 'Ksh') }})</p>
                                            <h4 class="mb-0">{{ $member->personal_training_fees }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <label class="m-2">Date</label>
                        <input class="form-control col-md-4 daterange" type="text" name="daterange"
                               id="filter_attend" data-id="{{$member->id}}" value="" placeholder="Select Date Range"/>
                        <button type="button" name="filter" id="filter_attendce" class="btn btn-info ml-3">
                            Filter
                        </button>

                        <button type="button" name="reset" id="reset"
                                class="btn btn-secondary ml-3">Reset
                        </button>

                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#attendance" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Attendance</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#revenue" role="tab">
                                <span class="d-none d-sm-block">Visuals</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#hours_spent" role="tab">
                                <span class="d-none d-sm-block">Hours Spent</span>
                            </a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="attendance" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 attendance_datatable w-100" id="attendance_table">
                                    <thead>
                                    <tr class="col-md-24">
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                    </tr>
                                    </thead>
{{--                                    <tbody>--}}
{{--                                    @if($member->attendances()->exists())--}}
{{--                                        @foreach($member->attendances as $attendance)--}}
{{--                                            <tr>--}}
{{--                                                <td>{{ $attendance->date->format('d M, Y') }}</td>--}}
{{--                                                <td>{{ ucwords($attendance->status) }}</td>--}}
{{--                                                <td>--}}
{{--                                                    {!! auth()->user()->can('attendance_mark') ? '<div class="custom-control custom-switch d-inline-block" dir="ltr">--}}
{{--                                                        <input type="checkbox" class="custom-control-input toggle-status-attendance" id="member-togglstatus-' . $attendance->id . '" data-id="' . $attendance->id . '" ' . ($attendance->status == 'present' ? "checked" : "") . '>--}}
{{--                                                        <label class="custom-control-label" for="member-togglstatus-' . $attendance->id . '"></label>--}}
{{--                                                    </div>':'' !!}--}}
{{--                                                </td>--}}
{{--                                                <td>{{ $attendance->clock_in ? $attendance->clock_in : '-' }}</td>--}}
{{--                                                <td>{{ $attendance->clock_out ? $attendance->clock_out : '-' }}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                    </tbody>--}}
                                </table>
                            </div>
                        </div>

{{--                    =========================  Visuals Pie Chart ========================== --}}
                        <div class="tab-pane" id="revenue" role="tabpanel">
                            <div class="row align-items-center">

                                <div class="col-md-6 m-auto">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Attendance Chart</h4>
                                        <div id="attendancePie" class="apex-charts">

                                        </div>
                                    </div>
                                </div>


{{--                                <div class="col-sm-6">--}}
{{--                                    <div id="attendanceDonat" class="apex-charts">--}}

{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-sm-6">--}}
{{--                                    <div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-6">--}}
{{--                                                <div class="py-3">--}}
{{--                                                    <p class="mb-1 text-truncate"><i--}}
{{--                                                            class="mdi mdi-circle text-success mr-1"></i> Present</p>--}}
{{--                                                    <h5>{{ json_decode($attendanceDonat)[0] }}</h5>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-6">--}}
{{--                                                <div class="py-3">--}}
{{--                                                    <p class="mb-1 text-truncate"><i--}}
{{--                                                            class="mdi mdi-circle text-warning mr-1"></i> Absent</p>--}}
{{--                                                    <h5>{{ json_decode($attendanceDonat)[1] }}</h5>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            </div>
                        </div>

{{--                    =========================  Hours Spent Inside Gym Chart ========================== --}}

                        <div class="tab-pane" id="hours_spent" role="tabpanel">
                            <div class="row align-items-center">

                                <div class="col-md-8 m-auto">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Member Hours Spent Chart</h4>
                                        <div id="hours-spent-chart" class="apex-charts">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="d-flex mt-4 mb-4">
                        <label class="m-2">Payments</label>
                        <select name="payments" id="payments_type" class="form-control col-md-4">
                            <option value="">Select Payments</option>
                            <option value="personal_training_fees">Personal Training Fee</option>
                            <option value="in_house_training_fees">In House Training Fee</option>
                            <option value="classes_fees">Classes Fee</option>
                            <option value="membership_fees">Membership Fee</option>
                            {{--                        <option value="all">All</option>--}}
                        </select>
                        <label class="m-2">Date</label>
                        <input class="form-control col-md-4 daterange" type="text" name="daterange"
                               id="filter_date" data-id="{{$member->id}}" value="" placeholder="Select Date Range"/>

                        <button type="button" name="filter" id="filter" class="btn btn-info ml-3">
                            Filter
                        </button>

                        <button type="button" name="reset" id="reset"
                                class="btn btn-secondary ml-3">Reset
                        </button>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title mb-4 income-expense">Member Financial Report</h4>
                        <div id="financial-report-chart" class="apex-charts">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Payments</h4>

                    <div class="table-responsive">
                        <table class="table table-centered mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Payment Date</th>
                                <th>Payment Time</th>
                                <th>Payment Month</th>
                                <th>Collected By</th>
                                <th>Reg Fees </th>
                                <th>Fees</th>
                                <th>PTF</th>
                                <th>IHTF</th>
                                <th>Discount</th>
                                <th>Extra Charges</th>
                                <th>Classes Fees</th>
                                <th>Total Fees</th>
                                <th>Payment</th>
                                <th>Pending Fees</th>
                                <th>Pending PTF</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($member->fees()->exists())
                                @foreach($member->fees()->latest()->get() as $fee)

                                    @php
                                        $memberFees = $fee->membership ? $fee->membership->fees : $fee->fees;
                                    @endphp

                                    <tr>
                                        <td>{{ $fee->payment_date->format('d M, Y') }}</td>
                                        <td>{{ $fee->created_at->format('g:i A') }}</td>
                                        <td>{{ $fee->payment_date->format('M') }}</td>
                                        <td>{{ @$fee->collectedBy->name }}</td>
                                        <td>{{ $fee->reg_fee }}</td>
                                        <td>{{ $memberFees }}</td>
                                        <td>{{ $fee->personal_training_fees??0  }}</td>
                                        <td>{{ $fee->in_house_training_fees??0  }}</td>
                                        <td>{{ $fee->discount ?? 0  }}</td>
                                        <td>{{ $fee->extra_charges??0  }}</td>
                                        <td>{{ $fee->classes_fees??0  }}</td>
                                        <td class="text-danger">{{ $fee->pending_fees || $fee->pending_personal_training_fees > 0 ? ($fee->reg_fee + $memberFees + $fee->pending_fees + $fee->personal_training_fees + $fee->pending_personal_training_fees + $fee->in_house_training_fees) : $fee->fees + $fee->reg_fee + $fee->personal_training_fees + $fee->extra_charges +$fee->classes_fees + $fee->in_house_training_fees }}</td>
                                        <td class="text-success">{{ $fee->total_payment }}</td>
                                        <td>{{ $fee->pending_fees }}</td>
                                        <td>{{ $fee->pending_personal_training_fees }}</td>
                                        <td>{{ ucwords($fee->payment_method) }}</td>
                                        <td>{{ $fee->status }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-3">
                        <ul class="pagination pagination-rounded justify-content-center mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>



    </div>

    <div class="modal fade bs-example-modal-lg" id="verify-user-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Verify</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="submit-verify-user-form">

                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Your Password</label>
                                    <input name="password" type="password" class="form-control"
                                           placeholder="Enter your password to continue..."/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1"
                                            data-size="xs">
                                        Confirm
                                    </button>
                                    <button type="button" class="btn btn-outline-dark waves-effect"
                                            data-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- end row -->
@endsection
@include('backend.members.ajax.view')

