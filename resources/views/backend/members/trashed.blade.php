@extends('layouts.master')

@section('title', 'Trashed Members')

@section('css')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet"/>
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Trashed Members @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row justify-content-end mt-5 mt-md-0 mb-3">
        <div class="col-12">
            <form id="searchForm">
                <div class="input-group mb-3">
                    <input name="query" id="search_query" type="text" class="form-control"
                           value="{{ request()->get('query') }}" placeholder="Search name...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-dark" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row members_list">
        @forelse($members as $member)
            <div class="col-md-3">
                <div class="card">
                    <div class="member-card">
                        <div class="ribbon ribbon-top-left">
                            @php
                                $status = '';
                                $color = '';
                                if($member->fees()->exists()) {
                                        $status = $member->fees()->latest()->first()->status;
                                        $color = '';
                                        if($status === 'pending') {
                                            $color = '#EEB902';
                                        } else {
                                            $color = '#45CB85';
                                        }
                                        if($member->is_expired)
                                    {
                                        $status = 'Due Fee';
                                        $color = 'red';
                                    }
                                } else {
                                        $status = 'New';
                                        $color = '#wqweee';
                                }

                            @endphp
                            <span style="background-color: {{ $color }}">{{ $status }}</span>
                        </div>
                    </div>
                    <div class="card-body pb-1">
                        <div class="profile-widgets">

                            <div class="text-center">
                                <div class="">
                                    <a class="member-profile-image"
                                       href="{{ asset($member->image ?? 'images/users/noprofile.jfif') }}">
                                        <img src="{{ asset($member->image ?? 'images/users/noprofile.jfif') }}" alt=""
                                             class="avatar-lg mx-auto img-thumbnail rounded-circle">
                                    </a>
                                    <div class="online-circle"><i class="fas fa-circle text-success"></i></div>
                                </div>

                                <div class="mt-3 ">
                                    <a href="{{ route('member.show', ['id' => $member->id]) }}"
                                       class="text-dark font-weight-medium font-size-16">{{ $member->name }}</a>
                                    <p class="text-body mt-1 mb-1"><small><b>Roll No: </b>{{ $member->roll_number }}
                                        </small>
                                    </p>
                                    <p class="text-body mt-1 mb-1">{{ $member->phone }}</p>
                                    <span
                                        class="badge badge-{{ $member->is_expired ? 'danger' : 'success' }}">{{ $member->is_expired ? 'Expired' : 'Not Expired' }}</span>
                                </div>

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
                                                <span class="action-restore btn btn-link text-dark btn-sm"
                                                      data-id="{{ $member->id }}"><i
                                                        class="far fa-edit"></i> Restore</span>
                                                </div>
                                        </span>
                                                    <span class="dropdown-item">
                                                            <div class="col-4 text-center">
                                                <span class="action-member-delete btn btn-link text-danger btn-sm"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#confirm-member-delete-modal"
                                                      data-name="{{ $member->name }}"><i
                                                        class="far fa-trash-alt"></i> Permanently Delete</span>
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
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>No record found!</h5>
                    </div>
                </div>
            </div>
        @endforelse
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                @php
                    $params = array('query' => request()->get('query'), 'page' => request()->get('page'));
                @endphp
                {{ $members->appends($params)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>


    <div class="modal fade bs-example-modal-lg" id="confirm-member-delete-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="alert alert-warning sureText" class="sureText"
                                   id="confirm_member_delete_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_member_delete_confirmed" data-size="xs">
                                    Yes, Delete
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="no_member_delete_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@include('backend.members.ajax.trashed')

