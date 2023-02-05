@extends('layouts.master')

@section('title', 'Trashed Memberships')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Trashed Memberships @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="memberships_list mt-4">
        <div class="row justify-content-center">
            @forelse($memberships as $membership)
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
                                        class="font-size-13">{{ $membership->duration }} month's</span></h1>
                            </div>

                            <div class="mt-2">
                                <h5 class="text-muted"><b>Reg Fee: </b>{{ $membership->reg_fee }}</h5>
                            </div>

                            <div class="mt-2">
                                <p class="text-muted">{{ $membership->description }}</p>
                            </div>

                           {{-- <div class="row">
                                <div class="col-md-6">
                                    <span class="action-restore btn btn-block btn-success waves-effect waves-light"
                                          data-id="{{ $membership->id }}" data-target="#edit-membership-modal"
                                          data-toggle="modal"><i class="far fa-edit"></i> Restore</span>
                                </div>
                                <div class="col-md-6">
                                    <span
                                        class="action-membership-delete btn btn-block btn-danger waves-effect waves-light"
                                        data-id="{{ $membership->id }}" data-target="#membership-del-modal"
                                        id="membership-del-btn" data-toggle="modal"
                                        data-name="{{ $membership->name }}"><i
                                            class="far fa-trash-alt"></i> Delete</span>
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
                                                <span class="action-restore btn btn-link text-success btn-sm waves-effect waves-light"
                                                      data-id="{{ $membership->id }}" data-target="#edit-membership-modal"
                                                      data-toggle="modal"><i
                                                        class="mdi mdi-restore-alert"></i> Restore</span>
                                                </div>
                                        </span>
                                                    <span class="dropdown-item">

                                                            <div class="col-4 text-center">
                                                <span class="action-membership-delete btn btn-link text-danger btn-sm waves-effect waves-light"
                                        data-id="{{ $membership->id }}" data-target="#membership-del-modal"
                                        id="membership-del-btn" data-toggle="modal"
                                        data-name="{{ $membership->name }}"><i
                                                        class="far fa-trash-alt"> Delete</i></span>
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

@include('backend.memberships.ajax.trashed')
