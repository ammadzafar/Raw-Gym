@extends('layouts.master')

@section('title', 'Attendance')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') User @endslot
        @slot('li_1') Attendance @endslot
    @endcomponent

    <div class="row attendance_list">

        @forelse($data as $arr)
            <div class="col-md-3">
                <a href="{{ auth()->user()->can('attendance_mark') ? route('attendancesbydates', [$arr['day']->format('Y-m-d')]) : 'javascript:void(0);' }}"
                   class="card card-hover-pointer">
                    <div class="card-body">
                        <h3 class="card-title mb-4">{{$arr['day']->format('d F Y')}}</h3>
                        <div>
                            <div class="pb-1 text-secondary mt-2">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <table class="w-100">
                                            <tbody>
                                            <tr>
                                                <th>Present</th>
                                                <td>{{ @$arr['present'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Absent</th>
                                                <td>{{ @$arr['absent'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Leave</th>
                                                <td>{{ @$arr['leave'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Public Holiday</th>
                                                <td>{{ @$arr['public_holiday'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Weekend</th>
                                                <td>{{ @$arr['weekend'] }}</td>
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
    </div>

@endsection
@include('backend.userattendances.attendancebydays.ajax.index')


