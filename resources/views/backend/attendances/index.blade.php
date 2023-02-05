@extends('layouts.master')

@section('title', 'Attendance')

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Member @endslot
        @slot('li_1') Attendance @endslot
    @endcomponent

  {{--  <div class="row attendance_list">

        @forelse($attendances as $attendance)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">{{ $attendance->member->name }}</h3>
                        <div>
                            <div class="pb-1 text-secondary mt-2">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <table class="w-100">
                                            <tbody>
                                            <tr>
                                                <th>Date</th>
                                                <td>{{$attendance->date->format('d F Y')}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $attendance->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Mark</th>
                                                <td>
                                                    @can('attendance_mark')
                                                        <div class="custom-control custom-switch d-inline-block"
                                                             dir="ltr">
                                                            <input type="checkbox"
                                                                   class="custom-control-input toggle-status-attendance"
                                                                   id="member-togglstatus-{{ $attendance->id }}"
                                                                   data-id="{{ $attendance->id }}" {{ $attendance->status == 'present' ? "checked" : "" }}>
                                                            <label class="custom-control-label"
                                                                   for="member-togglstatus-{{ $attendance->id }}"></label>
                                                        </div>
                                                    @endcan
                                                </td>
                                            </tr>
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
    </div>--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                        @can(array('attendance_list','attendance_mark'))
                            {{--<div class="d-flex justify-content-end mb-2">
                                <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                                        data-target="#create-user-modal"
                                        id="create-new-member">Create
                                    New User
                                </button>
                            </div>--}}
                        <div class="attendance_list">
                            <table class="table datatable table-bordered dt-responsive nowrap w-100"
                                   style="border-collapse: collapse; border-spacing: 0;">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                </tr>
                                </thead>

                                <tbody>

                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td>{{$attendance->date->format('d F Y')}}</td>
                                        <td>{{ $attendance->member->name }}</td>
{{--                                        <td>--}}
{{--                                            @can('attendance_mark')--}}
{{--                                                <div class="custom-control custom-switch d-inline-block"--}}
{{--                                                     dir="ltr">--}}
{{--                                                    <input type="checkbox"--}}
{{--                                                           class="custom-control-input toggle-status-attendance"--}}
{{--                                                           id="member-togglstatus-{{ $attendance->id }}"--}}
{{--                                                           data-id="{{ $attendance->id }}" {{ $attendance->status == 'present' ? "checked" : "" }}>--}}
{{--                                                    <label class="custom-control-label"--}}
{{--                                                           for="member-togglstatus-{{ $attendance->id }}"></label>--}}
{{--                                                </div>--}}
{{--                                            @endcan--}}
{{--                                        </td>--}}
                                        <td>{{ $attendance->clock_in ? $attendance->clock_in : '-' }}</td>
                                        <td>{{$attendance->clock_out  ? $attendance->clock_out : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="6" style="color: red">Sorry No Data Found</td>
                                    </tr>
                                @endforelse

                                </tbody>

                            </table>
                </div>
                        </div>
                        @endcan
                    </div>


                </div>
            </div>
        </div>
    </div>


@endsection
@include('backend.attendances.ajax.index')


