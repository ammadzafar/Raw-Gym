@extends('layouts.master')

@section('title', 'Roles')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Roles @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @can('role_create')
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                                    data-target="#create-role-modal"
                                    id="create-new-role">Create
                                User Role
                            </button>
                        </div>
                    @endcan
                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Register</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="create-role-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Create Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-role">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="Name" required data-parsley-trigger="keyup"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Permission's<span style="color: red"> *</span></label>
                                    <select class="form-control select2-multiple"
                                            name="permissions[]" data-placeholder="Choose ..." multiple
                                            id="role_permissions" data-parsley-required="true"
                                            data-parsley-required-message="Please assign Permissions">
                                        @foreach($permissions as $permission)
                                            <option class="text-capitalize" value="{{ $permission->id }}">
                                                @php
                                                    $role=  str_replace('_', ' ', ucwords($permission->name, "_"))
                                                @endphp
                                                {{$role}}

                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner " data-size="xs">
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

    <div class="modal fade bs-example-modal-lg" id="edit-role-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-role"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-role">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-role">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" id="edit_role_name"
                                           placeholder="Name" data-parsley-required="true" data-parsley-trigger="keyup">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Permission's<span style="color: red"> *</span></label>
                                    <select class="form-control select2-multiple"
                                            name="permissions[]" data-placeholder="Choose ..." multiple
                                            id="edit_role_permissions" data-parsley-required="true"
                                            data-parsley-required-message="Please assign Permissions">
                                        @foreach($permissions as $permission)
                                            <option class="text-capitalize" value="{{ $permission->id }}">
                                                @php
                                                    $role=  str_replace('_', ' ', ucwords($permission->name, "_"))
                                                @endphp
                                                {{$role}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner" data-size="xs">
                                        Update
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
    <div class="modal fade bs-example-modal-lg" id="role-modal" tabindex="-1" role="dialog"
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
                                   id="confirm_role_delete_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_role_delete_confirmed" data-size="xs">
                                    Yes, Delete
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="no_role_delete_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('backend.roles.ajax.index')


