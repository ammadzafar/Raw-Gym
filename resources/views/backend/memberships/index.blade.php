@extends('layouts.master')

@section('title', 'Memberships')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Memberships @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            @can('membership_create')
                <div class="d-flex justify-content-end mb-2">
{{--                    <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"--}}
{{--                            data-target="#create-membership-modal"--}}
{{--                            id="create-new-membership">Create New MemberShip--}}
{{--                    </button>--}}

                    <div class="dropdown">
                        <button class="btn btn-dark bg-dark-red btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Create New MemberShip
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" data-toggle="modal"  data-target="#create-membership-modal" id="create-new-membership">Monthly</a>
                            <a class="dropdown-item" data-toggle="modal"  data-target="#create-membership-modal" id="create-new-membership">Weekly</a>
                        </div>
                    </div>

                </div>
            @endcan
        </div>
    </div>

    <div class="memberships_list mt-4">
        <div class="row justify-content-center">
            @forelse ($memberships as $membership)
                <div class="col-xl-4 col-md-6">
                    <div class="card plan-box">
                        <div class="card-body p-4">
                            <div class="media">
                                <div class="media-body">
                                    <h4>{{ $membership->name }}</h4>
                                </div>
                            </div>
                            <div class="py-4 mt-4 text-center bg-soft-light">
                                <h1 class="m-0"><sup><small>Ksh</small></sup> {{ $membership->fees }}/<span
                                        class="font-size-13">{{ $membership->membership_type == 'monthly' ? $membership->duration." month's" : $membership->duration." week's" }}</span></h1>
                            </div>

                            <div class="mt-2">
                                <h5 class="text-muted"><b>Reg Fee: </b>{{ $membership->reg_fee }} {{ env('CURRENCY', 'Ksh') }}</h5>
                            </div>

                            <div class="mt-2">
                                <p class="text-muted">{{ $membership->description }}</p>
                            </div>

                            {{--<div class="d-flex justify-content-between">
                                <span class="action-edit btn btn-dark waves-effect waves-light"
                                      data-id="{{ $membership->id }}" data-target="#edit-membership-modal"
                                      data-toggle="modal"><i class="far fa-edit"></i> Edit</span>
                                <span class="action-membership-delete btn btn-danger waves-effect waves-light"
                                      data-id="{{ $membership->id }}" data-target="#membership-del-modal"
                                      id="membership-del-btn" data-toggle="modal" data-name="{{ $membership->name }}"><i
                                        class="far fa-trash-alt"></i> Delete</span>
                                <div class="d-flex flex-column">
                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                        <input type="checkbox" class="custom-control-input toggle-featured-membership"
                                               id="membership-togglfeatured-{{ $membership->id }}"
                                               data-id="{{ $membership->id }}" {{ $membership->featured ? "checked" : "" }}>
                                        <label class="custom-control-label"
                                               for="membership-togglfeatured-{{ $membership->id }}">Featured</label>
                                    </div>
                                    <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                        <input type="checkbox" class="custom-control-input toggle-status-membership"
                                               id="membership-togglstatus-{{ $membership->id }}"
                                               data-id="{{ $membership->id }}" {{ $membership->status ? "checked" : "" }}>
                                        <label class="custom-control-label"
                                               for="membership-togglstatus-{{ $membership->id }}">Status</label>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="dropdown text-right">
                                            <button class="btn btn-link text-dark dropdown-toggle btn-lg p-1"
                                                    type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"><i class="mdi mdi-menu-open"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <span class="dropdown-item">

                                                            <div class="col-4 text-center">
                                                <span class="action-edit btn btn-link text-dark btn-sm"
                                                      data-id="{{ $membership->id }}" data-toggle="modal"
                                                      data-target="#edit-membership-modal"><i
                                                        class="far fa-edit"></i> Edit</span>
                                                </div>
                                        </span>
                                                <span class="dropdown-item">
                                                        <div class="col-4 text-center">
                                            <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                        <input type="checkbox" class="custom-control-input toggle-status-membership"
                                               id="membership-togglstatus-{{ $membership->id }}"
                                               data-id="{{ $membership->id }}" {{ $membership->status ? "checked" : "" }}>
                                        <label class="custom-control-label"
                                               for="membership-togglstatus-{{ $membership->id }}">Status</label>
                                    </div>
                                        </div>

                                        </span>
                                                <span class="dropdown-item">

                                                        <div class="col-4 text-center">
                                                <span class="action-membership-delete btn btn-link text-danger btn-sm"
                                                     data-toggle="modal"
                                                      data-id="{{ $membership->id }}" data-target="#membership-del-modal"
                                                      id="membership-del-btn" data-toggle="modal" data-name="{{ $membership->name }}"><i
                                                        class="far fa-trash-alt"></i> Delete</span>
                                        </div>
                                        </span>
                                                <span class="dropdown-item">
                                                        <div class="col-4 text-center">
                                              <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                        <input type="checkbox" class="custom-control-input toggle-featured-membership"
                                               id="membership-togglfeatured-{{ $membership->id }}"
                                               data-id="{{ $membership->id }}" {{ $membership->featured ? "checked" : "" }}>
                                        <label class="custom-control-label"
                                               for="membership-togglfeatured-{{ $membership->id }}">Featured</label>
                                    </div>
                                        </div>

                                        </span>

                                            </div>
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
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="create-membership-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Create MemberShip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-membership">
                        @csrf
                        <input id="membership_type" type="hidden" name="membership_type" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="Name"
                                           data-parsley-minlength="3" data-parsley-required="true"/>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                                <div class="form-group">
                                    <label>Registration Fees ({{ env('CURRENCY', 'Ksh') }})</label>
                                    <input name="reg_fee" type="number" class="form-control"
                                           placeholder="Registration Fees"/>
                                </div>
                            </div>--}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fees ({{ env('CURRENCY', 'Ksh') }})<span style="color: red"> *</span></label>
                                    <input name="fees" type="text" class="form-control" placeholder="Fees"
                                           data-parsley-type="digits" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="month_week"></label>
                                    <input name="duration" type="text" class="form-control" placeholder="Duration"
                                           data-parsley-required="true" data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description<span style="color: red"> *</span></label>
                                    <textarea name="description" class="form-control" rows="1" placeholder="description"
                                              data-parsley-required="true"
                                              data-parsley-required-message="Please write description about the membership"
                                    ></textarea>
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


    <div class="modal fade bs-example-modal-lg" id="edit-membership-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-membership"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-membership">Edit Membership</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-membership">

                        @csrf
                        <input id="edit_membership_type" type="hidden" name="membership_type" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="Name"
                                           id="edit-membership-name" data-parsley-minlength="3"
                                           data-parsley-required="true"/>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                                <div class="form-group">
                                    <label>Registration Fees ({{ env('CURRENCY', 'Ksh') }})</label>
                                    <input name="reg_fee" type="number" class="form-control"
                                           placeholder="Registration Fees"
                                           id="edit-membership-signup-fee"/>
                                </div>
                            </div>--}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fees ({{ env('CURRENCY', 'Ksh') }})<span style="color: red"> *</span></label>
                                    <input name="fees" type="text" class="form-control" placeholder="Fees"
                                           id="edit-membership-amount" data-parsley-required="true"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="duration-mw"></label>
                                    <input name="duration" type="text" class="form-control" placeholder="Duration"
                                           id="edit-membership-period" data-parsley-required="true"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description<span style="color: red"> *</span></label>
                                <textarea name="description" class="form-control" rows="1" placeholder="description"
                                          data-parsley-required="true"
                                          data-parsley-required-message="Please write description about the membership"
                                          id="edit-membership-description"></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit"
                                    class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                    data-size="xs">
                                Update
                            </button>
                            <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade bs-example-modal-lg" id="membership-del-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Confirm Membership <span id=""></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="alert alert-warning sureText" class="sureText"
                                   id="confirm_membership_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_membership_delete_confirmed" data-size="xs">
                                    Confirm
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="no_membership_delete_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@include('backend.memberships.ajax.index')
