@extends('layouts.master')

@section('title', 'Lockers')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/css/custom.css')}}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Lockers @endslot
        @slot('li_1') Sections @endslot
    @endcomponent

    <div class="row locker_list">
        {{--for confirm data-toggle="modal"  data-target="#confirm-payment-modal" id="make_payment_modal_btn" data-size="xs"
        for lock assign data-toggle="modal" data-target="#create-locker-modal" id="create-new-locker"--}}


    @forelse($lockers as $locker)

            <div class="col-md-3 locker-box card-hover-pointer p-2"
                 @if($locker->member()->exists())
                 data-id="{{ $locker->id }}" data-toggle="modal" data-target="#confirm-locker-modal" id="locker_modal_btn" data-size="xs"
                 @else
                 data-id="{{ $locker->id }}" data-toggle="modal" data-target="#create-locker-modal" id="create-new-locker"
                 @endif
                <a href="javascript:void(0)">
                    <div class="flex mt-1 flex-column align-items-center">
                        <h3 class="text-center text-white">{{$locker->number}}</h3>
                        @if($locker->member()->exists())
                            <div class="flex flex-row text-center">

                                <img style="border-radius:50%" src="{{asset($locker->member->image ?? 'images/users/noprofile.jfif')}}"
                                     width="35px" height="35px">
                                <span class="text-white" style="text-transform: capitalize"><b>{{$locker->member->name}}</b></span>
                            </div>
                        @endif
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
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                {{--
                                        {{ $lockers->links('pagination::bootstrap-4') }}
                --}}
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" id="create-locker-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Assign Member to Locker <span id="locker-no"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-locker">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Member's</label>
                                    <select class="select2-selection select2-selection-single"
                                            name="member" data-placeholder="Choose ..."
                                            id="member-locker" data-parsley-required="true"
                                            data-parsley-required-message="select members">
                                        @foreach($members as $member)
                                            <option value="{{$member->id }}" data-image="{{ $member->image }}">{{ $member->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner "
                                            data-size="xs">
                                        Assign Members
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

    <div class="modal fade bs-example-modal-lg" id="confirm-locker-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Confirm Locker number <span id="locker_number"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="alert alert-warning sureText" class="sureText" id="confirm_locker_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_locker_confirmed"  data-size="xs" >
                                   Confirm
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="no_locker_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('backend.locker.ajax.index')
