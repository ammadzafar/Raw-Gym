@extends('layouts.master')

@section('title', auth()->user()->name . "'s Profile")

@section('css')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Profile @endslot
        @slot('li_1') User @endslot
    @endcomponent

    <div class="row">

        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title font-weight-bold">Update Profile</h4>
                </div>

                <div class="card-body">

                    <form id="update-user-profile">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" placeholder="Name" value="{{ auth()->user()->name }}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input name="phone" type="tel" class="form-control" placeholder="Phone" value="{{ auth()->user()->phone }}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" type="text" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}" />
                                </div>
                            </div>
                            <div class="wrap-custom-file">
                                  <input type="file" name="image" id="image1" accept=".gif, .jpg, .png" />
                                  <label  for="image1">
                                    <span>Change Profile Picture</span>
                                  </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner" data-size="xs">Update</button>
                                <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title font-weight-bold">Change Password</h4>
                </div>

                <div class="card-body">

                    <form id="update-user-password">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input name="old_password" type="password" class="form-control" placeholder="Old Password" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="New Password" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Repeat Password</label>
                                    <input name="confirm_password" type="password" class="form-control" placeholder="Repeat Password" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner" data-size="xs">Update</button>
                                <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection

@include('backend.userprofile.ajax.index')

