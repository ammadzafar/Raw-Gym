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
        @slot('title') Payments   @endslot
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
                                            <label>Payments</label>
                                            <select name="payments" id="payments_type" class="form-control">
                                                <option value="">Select Payments</option>
                                                <option value="personal_training_fees">Personal Training Fee</option>
                                                <option value="in_house_training_fees">In House Training Fee</option>
                                                <option value="classes_fees">Classes Fee</option>
                                                <option value="membership_fees">Membership Fee</option>
                                                <option value="guest">Guest</option>
                                                <option value="all">All</option>
                                            </select>
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
                                        {{--                                        <div class="col-md-4">--}}
                                        {{--                                            <div class="form-control d-flex justify-content-between mt-4">--}}
                                        {{--                                                <p>Total Records</p>--}}
                                        {{--                                                <p id="total-records" style="display: none"></p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive-md" style="overflow: auto; max-height: 325px;">
                                    <table id="report_payment" class="table table-bordered dt-responsive w-100"
                                           style="border-collapse: collapse; border-spacing: 0;">
                                        <thead>
                                        <tr class="headings">
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Collected By</th>
                                            <th>Amount</th>
                                            <th class="discount_hd" style="display: none">Discount</th>
                                        </tr>
                                        </thead>
                                        @php
                                            $amount = 0;
                                        @endphp
                                        <tbody class="payments_data">
                                        @foreach($records as $record)
                                            <tr>
                                                <td>{{$record['date']}}</td>
                                                <td>{{$record['name']}}</td>
                                                <td>{{$record['collected_by']}}</td>
                                                <td>{{$record['payment']}}</td>
                                                <td style="display: none">{{ $amount += $record['payment'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="total-rec">
                                    <p>Total </p>
                                    <p class="total-payments"> {{ $amount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Payment Report Chart</h4>
                                <div id="bar-chart" class="apex-charts">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('backend.dashboard.ajax.payments-report')
