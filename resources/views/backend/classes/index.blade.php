@extends('layouts.master')

@section('title', 'classess')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') classes @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @can('classes_create')
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                                    data-target="#create-classes-modal"
                                    id="create-new-classes">Create
                                classes
                            </button>
                        </div>
                    @endcan
                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                            <th>Saturday</th>
                            <th>Sunday</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="create-classes-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Create classes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-classes">

                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" placeholder="Name" required
                                           data-parsley-trigger="keyup"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Please select the days</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Monday" value="1"
                                           class="custom-control-input Monday"
                                           id="Monday">
                                    <label class="custom-control-label" for="Monday">
                                        Monday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Tuesday" value="1"
                                           class="custom-control-input Tuseday"
                                           id="Tuesday">
                                    <label class="custom-control-label" for="Tuesday">
                                        Tuesday</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Wednesday" value="1"
                                           class="custom-control-input Wednesday"
                                           id="Wednesday">
                                    <label class="custom-control-label" for="Wednesday">
                                        Wednesday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Thursday" value="1"
                                           class="custom-control-input Thursday"
                                           id="Thursday">
                                    <label class="custom-control-label" for="Thursday">
                                        Thursday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Friday" value="1"
                                           class="custom-control-input Friday"
                                           id="Friday">
                                    <label class="custom-control-label" for="Friday">
                                        Friday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Saturday" value="1"
                                           class="custom-control-input Saturday"
                                           id="Saturday">
                                    <label class="custom-control-label" for="Saturday">
                                        Saturday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Sunday"
                                           class="custom-control-input Sunday" value="1"
                                           id="Sunday">
                                    <label class="custom-control-label" for="Sunday">
                                        Sunday</label>
                                </div>
                            </div>

                            <div class="col-md-10">
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

    <div class="modal fade bs-example-modal-lg" id="edit-classes-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-classes"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-classes">Edit classes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-classes">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" id="edit_classes_name"
                                           placeholder="Name" data-parsley-required="true" data-parsley-trigger="keyup">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Please select the days</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Monday" value="1"
                                           class="custom-control-input edit_Monday"
                                           id="eid_Monday">
                                    <label class="custom-control-label" for="eid_Monday">
                                        Monday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Tuesday" value="1"
                                           class="custom-control-input edit_Tuesday"
                                           id="eid_Tuesday">
                                    <label class="custom-control-label" for="eid_Tuesday">
                                        Tuesday</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Wednesday" value="1"
                                           class="custom-control-input eid_Wednesday"
                                           id="eid_Wednesday">
                                    <label class="custom-control-label" for="eid_Wednesday">
                                        Wednesday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Thursday" value="1"
                                           class="custom-control-input eid_Thursday"
                                           id="eid_Thursday">
                                    <label class="custom-control-label" for="eid_Thursday">
                                        Thursday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Friday" value="1"
                                           class="custom-control-input eid_Friday"
                                           id="eid_Friday">
                                    <label class="custom-control-label" for="eid_Friday">
                                        Friday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Saturday" value="1"
                                           class="custom-control-input eid_Saturday"
                                           id="eid_Saturday">
                                    <label class="custom-control-label" for="eid_Saturday">
                                        Saturday</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="Sunday"
                                           class="custom-control-input eid_Sunday" value="1"
                                           id="eid_Sunday">
                                    <label class="custom-control-label" for="eid_Sunday">
                                        Sunday</label>
                                </div>
                            </div>

                            <div class="col-md-10">
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
@endsection
@include('backend.classes.ajax.index')
