@extends('layouts.master')

@section('title') Report @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{ URL::asset('/libs/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>--}}

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <style>
        .checked-out {
            padding: 0 !important;
        }
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .total-rec{
            display: flex;
            justify-content: space-between;
            padding: 10px;
            width: 14%;
            border: 1px solid #ced4da;
            border-radius: 5px;
            float: right;
            margin-top: 18px;
        }
        .total-rec p{
            margin: 0px;
        }

    </style>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Members   @endslot
        @slot('title_li') Report  @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            @php
                                                $today = \Carbon\Carbon::today()->format("l,d F Y");
                                            @endphp
                                            <h1> {{$today}}</h1>
                                            <p>Welcome {{ auth()->user()->name }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date</label>
                                            <input class="form-control daterange" type="text" name="daterange"
                                                   id="filter_date" value="" placeholder="Select Date Range"/>
                                        </div>
                                        <div class="mt-4" align="center">
                                            <button type="button" name="filter" id="filter" class="btn btn-info ml-3">
                                                Filter
                                            </button>

                                            <button type="button" name="reset" id="reset"
                                                    class="btn btn-secondary ml-3">Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Members Report Chart</h4>
                                <div id="pie-chart" class="apex-charts">

                                </div>
                            </div>
                        </div>
                    </div>

{{--                    =========================  Hours Spent Inside Gym  ========================== --}}

{{--                    <div class="col-md-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-body">--}}

{{--                                <div class="d-flex mb-3">--}}
{{--                                    <label class="m-2">Name</label>--}}
{{--                                    <input type="text" id="filter_name" name="name" class="form-control col-md-3" placeholder="name">--}}

{{--                                    <label class="m-2">Date</label>--}}
{{--                                    <input class="form-control daterange col-md-3" type="text" name="daterange" id="filter_date_hours" value="" placeholder="Select Date Range"/>--}}

{{--                                    <button type="button" name="filter" id="filter-hours" class="btn btn-info ml-3">Filter</button>--}}

{{--                                    <button type="button" name="reset" id="reset-hours" class="btn btn-secondary ml-3">Reset</button>--}}
{{--                                </div>--}}

{{--                                <h4 class="card-title mb-4">Member Hours Spent Chart</h4>--}}
{{--                                <div id="hours-spent-chart" class="apex-charts">--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
            </div>
        </div>
    </div>

@endsection

@include('backend.dashboard.ajax.members-report')
