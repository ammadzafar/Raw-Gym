@extends('layouts.master')

@section('title', $date->format('d M, Y') . ' | Attendance')

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{ $date->format('d M, Y') }} @endslot
        @slot('li_1') Attendance @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            @can('user_attendance_mark')
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                            data-target="#bulk-user-attendance"
                            id="">
                        Mark Bulk Attendance
                    </button>
                </div>
            @endcan

            <div class="row attendance_list">

                @forelse($attendances as $attendance)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class=" mb-4">{{ $attendance->user->name }}</h3>
                                <div>
                                    <div class="pb-1 text-secondary mt-2">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <table class="w-100">
                                                    <tbody>
                                                    <tr>
                                                        <th>Clock In</th>
                                                        <td>{{ $attendance->clock_in ? $attendance->clock_in->format('g:i A') : '---' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Clock Out</th>
                                                        <td>{{$attendance->clock_out ? $attendance->clock_out->format('g:i A') : '---'}}</td>
                                                    </tr>
                                                    @can('user_attendance_mark')
                                                        <tr>
                                                            <th>Admin Approval</th>
                                                            <td>
                                                                <div class="custom-control custom-switch d-inline-block"
                                                                     dir="ltr">
                                                                    <input type="checkbox"
                                                                           class="custom-control-input toggle-status-attendance"
                                                                           id="member-togglstatus-{{ $attendance->id }}"
                                                                           data-date="{{ $attendance->date }}"
                                                                           data-id="{{ $attendance->id }}" {{ $attendance->admin_approval ? "checked" : "" }}>
                                                                    <label class="custom-control-label"
                                                                           for="member-togglstatus-{{ $attendance->id }}"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Mark</th>
                                                            <td>
                                                                <select
                                                                    class="form-control select2-multiple select_attendance_type"
                                                                    data-placeholder="Choose ..."
                                                                    data-status="{{ $attendance->status }}"
                                                                    data-id="{{ $attendance->id }}"
                                                                    name="user-attendance">
                                                                    @forelse(getPossibleEnumValues('user_attendances', 'status') as $status)
                                                                        <option
                                                                            value="{{ $status }}" {{ $status === $attendance->status ? 'selected' : '' }}>{{ str_replace('_', ' ', ucwords($status, "_")) }}</option>
                                                                    @empty
                                                                        <option selected disabled>No options!</option>
                                                                    @endforelse
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endcan
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        {{ $attendances->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

            <div class="modal fade bs-example-modal-lg" id="bulk-user-attendance" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0">Mark Attendance</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="user-attendance">

                                @csrf
                                <input type="hidden" name="date" value="{{$date}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Leave Reason</label>
                                            <input name="label" type="text" class="form-control"
                                                   placeholder="Leave Reason"
                                                   data-parsley-required="true" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Leave Type</label>
                                            <select
                                                class="select2 form-control select2-multiple select2-hidden-accessible"
                                                name="status" data-placeholder="Choose ..." data-parsley-required="true"
                                                data-parsley-required-message="Please assign Role" data-select2-id="3"
                                                tabindex="-1" aria-hidden="true">
                                                @if(getPossibleEnumValues('user_attendances', 'status'))
                                                    @foreach(getPossibleEnumValues('user_attendances', 'status') as $status)
                                                        <option class="text-capitalize"
                                                                value="{{ $status }}">{{ str_replace('_', ' ', ucwords($status, "_")) }}</option>
                                                    @endforeach
                                                @endif

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                            <button type="submit"
                                                    class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner "
                                                    data-size="xs">
                                                Mark Attendance

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
        </div>
    </div>
@endsection
@include('backend.userattendances.ajax.index')
