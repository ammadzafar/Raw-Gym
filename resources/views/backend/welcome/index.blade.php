@extends('layouts.master')

@section('title', 'Welcome')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Welcome {{auth()->user()->name}}@endslot
    @endcomponent
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h1> Welcome {{auth()->user()->name}}</h1>

            </div>
        </div>

    </div>
@endsection


