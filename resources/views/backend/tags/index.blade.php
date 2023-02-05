@extends('layouts.master')

@section('title', 'Tags')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Tags @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @can('tag_create')
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                                    data-target="#create-tag-modal"
                                    id="create-new-tag">Create
                                Tag
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

    <div class="modal fade bs-example-modal-lg" id="create-tag-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Create Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-tag">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" placeholder="Name" required
                                           data-parsley-trigger="keyup"/>
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

    <div class="modal fade bs-example-modal-lg" id="edit-tag-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-tag"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-tag">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-tag">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" id="edit_tag_name"
                                           placeholder="Name" data-parsley-required="true" data-parsley-trigger="keyup">
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
@endsection
@include('backend.tags.ajax.index')
