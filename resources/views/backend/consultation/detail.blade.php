@extends('layouts.master')

@section('title', 'Consultation')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Consultation @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @foreach($consultations as $consultation)
                        <h1>Subject: {{$consultation->subject}}</h1>
                        <hr>
                        <h5>Consultation By: {{$consultation->consultant->name}} |
                            Published: {{$consultation->created_at->format('d F y')}}</h5>
                        <p>{{$consultation->message}}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">

            </div>

        </div>
    </div>


@endsection

@include('backend.consultation.ajax.index')


