@extends('layouts.master')

@section('title', 'Members')

@section('css')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet"/>
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .expired {
            color: #fff;
            font-size: 16px;
            animation: expired 1s ease-in-out infinite alternate;
        }

        @-webkit-keyframes expired {
            from {
                text-shadow: 0 0 1px #fff, 0 0 2px #fff, 0 0 3px red, 0 0 4px red, 0 0 5px red, 0 0 6px red, 0 0 7px red;
            }
            to {
                text-shadow: 0 0 2px #fff, 0 0 3px #ff4da6, 0 0 4px #ff4da6, 0 0 5px #ff4da6, 0 0 6px #ff4da6, 0 0 7px #ff4da6, 0 0 8px #ff4da6;
            }
        }

        .paid {
            color: #fff;
            font-size: 16px;

            animation: paid 1s ease-in-out infinite alternate;
        }

        @-webkit-keyframes paid {
            from {
                text-shadow: 0 0 3px #fff, 0 0 4px #fff, 0 0 5px darkgreen, 0 0 6px darkgreen, 0 0 7px darkgreen, 0 0 8px darkgreen, 0 0 9px darkgreen;
            }
            to {
                text-shadow: 0 0 2px #fff, 0 0 3px lightgreen, 0 0 4px lightgreen, 0 0 5px lightgreen, 0 0 6px lightgreen, 0 0 7px lightgreen, 0 0 8px lightgreen;
            }
        }
    </style>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Members @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    @can('member_create')
        <div class="row justify-content-end mt-5 mt-md-0 mb-3">
            <div class="col-6">
                <form id="searchForm">
                    <div class="input-group mb-3">
                        <input name="query" id="search_query" type="text" class="form-control"
                               value="{{ request()->get('query') }}" placeholder="Search name..." autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-4">

                <div class="form-group">
                    <select name="gender" class="form-control select2-multiple select2-hidden-accessible"
                            id="mebergender" data-placeholder="Choose ..." data-parsley-required="true"
                            data-parsley-required-message="Please select gender type" data-select2-id="gender"
                            tabindex="-1" aria-hidden="true">
                        <option class="text-capitalize" value="" data-select2-id="2">Select by Gender</option>
                        <option class="text-capitalize" value="male" data-select2-id="2">Male</option>
                        <option class="text-capitalize" value="female" data-select2-id="33">Female</option>
{{--                        <option class="text-capitalize" value="trans" data-select2-id="34">Trans</option>--}}
{{--                        <option class="text-capitalize" value="other" data-select2-id="35">Other</option>--}}

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                        data-target="#create-member-modal"
                        id="create-new-member">Create New Member
                </button>
            </div>
        </div>
    @endcan

    @include('backend.members.member-card')


    <div class="modal fade bs-example-modal-lg" id="create-member-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">New Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body custom-class">
                    <form id="create-member" enctype="multipart/form-data">
                        @csrf
                        <div class="row create-member-div">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="Name"
                                        data-parsley-minlength="3" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input name="phone" id="phone" type="text" class="form-control"
                                           placeholder="" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" type="email" class="form-control" placeholder="Email"
                                           data-parsley-type="email"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control select2-multiple" id="gender"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please select gender type">
{{--                                        @foreach(getPossibleEnumValues('members', 'gender') as $gender)--}}
{{--                                            <option class="text-capitalize"--}}
{{--                                                    value="{{ $gender }}">{{ ucwords($gender) }}</option>--}}
{{--                                        @endforeach--}}
                                        <option class="text-capitalize"
                                                value="male">Male</option>
                                        <option class="text-capitalize"
                                                value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input name="dob" type="date" class="form-control" placeholder="Dob"/>
                                </div>
                            </div>

                            {{--  <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Exercise Type</label>
                                      <select name="exercise_type"
                                              class="form-control select2-multiple select_excercise_type" id="exercise"
                                              data-placeholder="Choose ..." data-parsley-required="true"
                                              data-parsley-required-message="Please select exercise type">
                                          --}}{{--                                        <option class="text-capitalize" value="">Select Exercise</option>--}}{{--
                                          @foreach(getPossibleEnumValues('members', 'exercise_type') as $exercise)
                                              <option class="text-capitalize"
                                                      value="{{ $exercise }}">{{ ucwords($exercise) }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>--}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Member Type</label>
                                    <select class="form-control select2-multiple select_member_type" name="member_type"
                                            data-placeholder="Choose ..." data-parsley-required="true">
                                        <option value="guest-member-value" selected>Guest</option>
                                        <option value="membership">Membership</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 select_membership_div">
                                <div class="form-group">
                                    <label>Select Membership</label>
                                    <select name="membership_id" class="form-control select2-multiple select_membership"
                                            data-placeholder="Choose ...">
                                        <option selected value="">Select Membership</option>
                                        @foreach($memberships as $membership)
                                            <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 reg_fee_div">
                                <div class="form-group">
                                    <label>Registration Fee </label>
                                    <input name="reg_fee" type="text" class="form-control"
                                           placeholder="Registration Fee" id="reg_fee" value="0"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6 fee_structure_div">
                                <div class="form-group">
                                    <label>Fee Structure <span
                                            style="color: red"> *</span></label>
                                    <input name="fee_structure" type="text" class="form-control"
                                           placeholder="Fee Structure" id="fee_structure"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Provide Personal Training</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="personal_training"
                                           class="custom-control-input personal_training_checkbox"
                                           id="personal_training_checkbox">
                                    <label class="custom-control-label" for="personal_training_checkbox">Personal
                                        Training</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="personal_training_fees_div">
                                <div class="form-group">
                                    <label>Personal Training Fees </label>
                                    <input name="personal_training_fees" type="number" class="form-control"
                                           placeholder="Personal Training Fees" id="personal_training_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div><br>

                            {{-- ===================== in house training fees ============================= --}}

                            <div class="col-md-6">
                                <label>Provide In House Training</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="in_house_training"
                                           class="custom-control-input in_house_training_checkbox"
                                           id="in_house_training_checkbox">
                                    <label class="custom-control-label" for="in_house_training_checkbox">In House
                                        Training</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="in_house_training_fees_div">
                                <div class="form-group">
                                    <label>In House Training Fees </label>
                                    <input name="in_house_training_fees" type="number" class="form-control"
                                           placeholder="In House Training Fees" id="in_house_training_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>

                            {{-- ============================================== --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Member Created Date<span style="color: red"> *</span></label>
                                    <input name="reg_date" type="date" class="form-control"
                                           placeholder="Member Created date" id="member_create_date"/>
                                </div>
                            </div>
                            <div class="wrap-custom-file">
                                <input type="file" name="image" id="image1" accept=".gif, .jpg, .png"/>
                                <label for="image1">
                                    <span class="file_text">Change Profile Picture</span>
                                </label>
                            </div>


                            <div class="col-md-12" id="is_member_guest">
                                <label>Create Guest</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="guest_member"
                                           class="custom-control-input guest_member_checkbox"
                                           id="guest_member_checkbox">
                                    <label class="custom-control-label" for="guest_member_checkbox">Guest</label>
                                </div>
                            </div>
                            {{--<div class="col-md-12">
                                <label>Attend Classes</label>
                                <div class="custom-control custom-checkbox custom-classes-box">
                                    <input type="checkbox" name="adttend_classes"
                                           class="custom-control-input classes_checkbox"
                                           id="classes_checkbox">
                                    <label class="custom-control-label" for="classes_checkbox">Select Classes</label>
                                </div>
                            </div>
                            <div class="col-md-6 select_classes_div">
                                <div class="form-group">
                                    <label>Select Classes</label>
                                    <select name="classes[]" class="form-control select2-multiple select_classes " multiple
                                            data-placeholder="Choose ...">
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ ucwords($class->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 select_classes_fees_div">
                                    <div class="form-group">
                                        <label>Class Fee Structure <span
                                                style="color: red"> *</span></label>
                                        <input name="classes_fees" type="text" class="form-control"
                                               placeholder="Fee Structure" id="classes_fees_structure"
                                               data-parsley-validation-threshold="1" data-parsley-trigger="keyup" value="0"
                                               data-parsley-type="digits"/>
                                    </div>


                            </div>--}}

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="" class="form-control" rows="1"
                                              placeholder="Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                            data-size="xs">
                                        Create
                                    </button>
                                    <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="edit-member-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-member"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-member">Edit Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-member">

                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red"> *</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="Name"
                                           id="edit_member_name" data-parsley-minlength="3"
                                           data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone<span style="color: red"> *</span></label>
                                    <input name="phone" type="text" class="form-control" placeholder=""
                                           id="edit_member_phone" data-parsley-required="true" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email<span style="color: red"> *</span></label>
                                    <input name="email" type="email" class="form-control" placeholder="Email"
                                           id="edit_member_email" data-parsley-required="true"
                                           data-parsley-type="email"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control select2-multiple" id="edit_member_gender"
                                            data-placeholder="Choose ..." data-parsley-required="true"
                                            data-parsley-required-message="Please select gender type">
{{--                                        @foreach(getPossibleEnumValues('members', 'gender') as $gender)--}}
{{--                                            <option class="text-capitalize" value="{{ $gender }}">{{ $gender }}</option>--}}
{{--                                        @endforeach--}}
                                            <option class="text-capitalize"
                                                    value="male">Male</option>
                                            <option class="text-capitalize"
                                                    value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input name="dob" type="date" class="form-control" placeholder="Dob"
                                           id="edit_member_dob"
                                           data-parsley-required-message="Please select Date of Birth"/>
                                </div>
                            </div>

                            {{--    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Exercise Type</label>
                                        <select name="exercise_type" class="form-control select2-multiple"
                                                id="edit_member_exercise"
                                                data-placeholder="Choose ..."
                                        >
                                            <option class="text-capitalize" value="">Select Exercise</option>
                                            @foreach(getPossibleEnumValues('members', 'exercise_type') as $exercise)
                                                <option class="text-capitalize"
                                                        value="{{ $exercise }}">{{ $exercise }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>--}}

                               <div class="col-md-6 update-guest-member-div">
                                    <div class="form-group">
                                        <label>Member Type</label>
                                        <select class="form-control select2-multiple edit_select_member_type"
                                                data-placeholder="Choose ..." id="edit_select_member_type" name="member_type">
                                            <option value="">Monthly Basis Fees</option>
                                            <option class="edit_guest_member" value="guest-member-value">Guest</option>
                                            <option value="membership">Membership</option>
                                        </select>
                                    </div>
                                </div>

                            {{--<div class="col-md-6 edit_reg_fee_div">
                                <div class="form-group">
                                    <label>Registration Fee </label>
                                    <input name="reg_fee" type="text" class="form-control"
                                           placeholder="Registration Fee" id="edit_reg_fee"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>--}}

                                                        <div class="col-md-6 edit_select_membership_div">
                                                            <div class="form-group">
                                                                <label>Select Membership</label>
                                                                <select name="membership_id" class="form-control select2-multiple select_membership"
                                                                        id="edit_member_membership"
                                                                        data-placeholder="Choose ...">
                                                                    <option selected value="">Select Membership</option>
                                                                    @foreach($memberships as $membership)
                                                                        <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                            {{--<div class="col-md-6 edit_fee_structure_div">
                                <div class="form-group">
                                    <label>Fee Structure <span style="color: red"> *</span></label>
                                    <input name="fee_structure" type="text" class="form-control"
                                           placeholder="Fee Structure" id="edit_member_fee_structure"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>--}}


                            <div class="col-md-6">
                                <label>Provide Personal Training</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="personal_training"
                                           class="custom-control-input personal_training_checkbox"
                                           id="edit_personal_training_checkbox">
                                    <label class="custom-control-label" for="edit_personal_training_checkbox">Personal
                                        Training</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="edit_personal_training_fees_div">
                                <div class="form-group">
                                    <label>Personal Training Fees </label>
                                    <input name="personal_training_fees" type="text" class="form-control"
                                           placeholder="Personal Training Fees" id="edit_personal_training_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>

                            {{-- ===================== edit in house training fees ============================= --}}

                            <div class="col-md-6">
                                <label>Provide In House Training</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="in_house_training"
                                           class="custom-control-input in_house_training_checkbox"
                                           id="edit_in_house_training_checkbox">
                                    <label class="custom-control-label" for="edit_in_house_training_checkbox">In House
                                        Training</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="edit_in_house_training_fees_div">
                                <div class="form-group">
                                    <label>In House Training Fees </label>
                                    <input name="in_house_training_fees" type="number" class="form-control"
                                           placeholder="In House Training Fees" id="edit_in_house_training_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>

                            {{-- ============================================== --}}




                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Member Created Date<span style="color: red"> *</span></label>
                                    <input name="reg_date" type="date" class="form-control"
                                           placeholder="Member Created date" id="edit_member_create_date"/>
                                </div>

                            </div>


                            <div class="wrap-custom-file">
                                <input type="file" name="image" id="edit-image1" accept=".gif, .jpg, .png"/>
                                <label for="edit-image1" class="edit-member-profile-image">
                                    <span>Change Profile Picture</span>
                                </label>
                            </div>

                            {{--   <div class="col-md-12">
                                   <label>Attend Classes</label>
                                   <div class="custom-control custom-checkbox edit_custom-classes-box">
                                       <input type="checkbox" name="adttend_classes"
                                              class="custom-control-input edit_classes_checkbox"
                                              id="edit_classes_checkbox">
                                       <label class="custom-control-label" for="edit_classes_checkbox">Select Classes</label>
                                   </div>
                               </div>
                               <div class="col-md-6 edit_select_classes_div">
                                   <div class="form-group">
                                       <label>Select Classes</label>
                                       <select name="classes[]" class="form-control select2-multiple edit_select_classes " multiple
                                               data-placeholder="Choose ...">
                                          --}}{{-- @foreach($classes as $class)
                                               <option value="{{ $class->id }}">{{ ucwords($class->name) }}</option>
                                           @endforeach--}}{{--
                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-6 edit_select_classes_fees_div">
                                   <div class="form-group">
                                       <label>Class Fee Structure <span
                                               style="color: red"> *</span></label>
                                       <input name="classes_fees" type="text" class="form-control"
                                              placeholder="Fee Structure" id="edit_classes_fees_structure"
                                              data-parsley-validation-threshold="1" data-parsley-trigger="keyup" value="0"
                                              data-parsley-type="digits"/>
                                   </div>


                               </div>--}}

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="edit_member_address" class="form-control" rows="1"
                                              placeholder="Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                            data-size="xs">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg " id="make-payment-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg paymentModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Make Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="make-payment">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control" id="make_payment_name"> <b
                                            id="make_p_membership_name"></b></label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <p class="custom_ribbon">
                                    <span class="custom_ribbon_text">Pending</span>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-dark">
                                        <thead>

                                        <tr>
                                            <th scope="col">Registration Fees</th>
                                            <th scope="col">Fees</th>
                                            <th scope="col">Pending Fees</th>
                                            <th scope="col">Personal Training Fees</th>
                                            <th scope="col">In House Training Fees</th>
                                            <th scope="col">Pending Personal Training Fees
                                            </th>
                                            {{-- <th>Classes Fees</th>--}}
                                            <th scope="col">Total Payment</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr id="on_payment_description">

                                        </tr>
                                        </tbody>


                                    </table>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Payment Method</label>
                                    <select class="form-control select2-multiple" id="select_payment_method"
                                            name="payment_method" data-placeholder="Choose ...">
                                        @foreach(getPossibleEnumValues('fees', 'payment_method') as $method)
                                            <option class="text-capitalize"
                                                    value="{{ $method }}" {{ ($method === 'cash') ? 'selected' : '' }}>{{ ucwords($method) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Payment Date<span style="color: red"> *</span></label>
                                    <input name="payment_date" type="date" class="form-control"
                                           placeholder="Payment Data" id="member_payment_date"/>
                                </div>
                            </div>
                            <div class="col-md-6" id="pay_month" style="display: none">
                                <div class="form-group">
                                    <label>Payment Month<span style="color: red"> *</span></label>
                                    <select id="member_payment_month" name="payment_month" class="form-control">
                                        <option value='0'>Select Payment Month</option>
                                        <option value='1'>Janaury</option>
                                        <option value='2'>February</option>
                                        <option value='3'>March</option>
                                        <option value='4'>April</option>
                                        <option value='5'>May</option>
                                        <option value='6'>June</option>
                                        <option value='7'>July</option>
                                        <option value='8'>August</option>
                                        <option value='9'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="member_total_payment_div">
                                <div class="form-group">
                                    <label>Total Fee (Gym fee + Registration Fee {{--+Classes Fees--}}) <span
                                            style="color: red"> *</span></label>
                                    <input name="total_payment" type="text" class="form-control"
                                           placeholder="Member Fees"
                                           id="member_total_payment" data-parsley-validation-threshold="1"
                                           data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: green">Extra Charges (e.g AC Charges) </label>
                                    <input name="extra_charges" type="text" class="form-control"
                                           placeholder="Extra Charges"
                                           id="member_extra_charges" data-parsley-validation-threshold="1" value="0"
                                           data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notes<span style="color: red"></span></label>
                                    <input id="mem_notes" name="notes" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Discount<span style="color: red"> *</span></label>
                                    <input id="discount" name="discount" type="number" class="form-control" value="0" />
                                </div>
                            </div>

                            <div class="col-md-6" id="member_pending_fees_div">
                                <div class="form-group">
                                    <label>Pending fees </label>
                                    <h4 id="pendingFees"></h4>
                                    <input name="pending_fees" type="hidden" class="form-control"
                                           placeholder="Pending Fees" value="0" id="member_pending_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6" id="member_fees_div">
                                <div class="form-group">
                                    <label>Member Fees </label>
                                    <h4 id="pendingFees"></h4>
                                    <input name="fees" type="hidden" class="form-control"
                                           placeholder="Pending Fees" id="member_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                    <input name="classes_fees" type="hidden" class="form-control"
                                           placeholder="Pending Fees" id="member_classes_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits" value="0"/>
                                </div>
                            </div>
                            <div class="col-md-6" id="mp_member_per_tra_fees_div">
                                <div class="form-group">
                                    <label>Personal Training Fees </label>
                                    <input name="personal_training_fees" type="text" class="form-control"
                                           placeholder="Personal Training Fees" value="0" id="mp_member_per_tra_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                            <div class="col-md-6" id="mp_in_house_fees_div">
                                <div class="form-group">
                                    <label>In House Training Fees </label>
                                    <input name="in_house_training_fees" type="text" class="form-control"
                                           placeholder="Personal Training Fees" value="0" id="in_house_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6" id="mp_member_per_tra_pen_fees_div">
                                <div class="form-group">
                                    <label>Personal Training Pending Fees </label>
                                    <h4 id="PTPF"></h4>
                                    <input name="pending_personal_training_fees" type="hidden" class="form-control"
                                           placeholder="Personal Training Pending Fees" value="0"
                                           id="mp_member_per_tra_pen_fees" data-parsley-validation-threshold="1"
                                           data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark waves-effect waves-light mr-1 add-spinner"
                                        data-toggle="modal" data-target="#confirm-payment-modal"
                                        id="make_payment_modal_btn" data-size="xs">
                                    Make Payment
                                </button>
                                <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="confirm-payment-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0">Confirm Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="alert alert-warning sureText" class="sureText" id="confirm_p_modal_desc"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="button"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        id="yes_payment_confirmed" data-size="xs">
                                    Yes, Pay
                                </button>
                                <button type="button" class="btn btn-outline-dark waves-effect"
                                        id="payment_not_confirmed" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="payment-history-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member_payment_history_heading"></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <table class="table table-dark">
                    <thead>

                    <tr>
                        <th scope="col">Registration Date</th>
                        <th scope="col">Expire Date</th>
                        <th scope="col">Registration Fee</th>
                        <th scope="col">Current Gym Fee</th>
                        <th scope="col">Current PTF Fee</th>
                        <th scope="col">IHTF Fee</th>
                        <th scope="col">Classes Fees</th>
                        <th scope="col">Discount</th>
                        <th><strong>Current Total Fees</strong><small> (excluded registration fees)</small></th>



                    </tr>
                    </thead>
                    <tbody id="fee_str">


                    </tbody>


                </table>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table mb-0">

                            <thead>

                            <tr class="text-center">
                                <!-- <th>Register Date</th> -->
                                <th>Payment Date</th>
                                <th>Payment time</th>
                                <!-- <th>Expire Date</th> -->
                                <th>Collected By</th>
                                <!-- <th>Registration Fees </th> -->
                                <!-- <th>Fees </th> -->
                                <!-- <th>PTF </th> -->
                                <th>Extra Charges</th>

                                <!-- <th>Total Fees </th> -->
                                <th>Payment</th>
                                <th>Discount</th>
                                <th>Pending Gym Fee</th>
                                <th>Pending PTF</th>
                                <th>IHTF Fee</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Download Receipt</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody class="table-striped" id="member_payment_tr">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-md" style="max-width:635px;position:absolute; top: 0" id="pdf-download">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" style="text-align: left !important;">Payment Receipt</h5>
                </div>
                <div class="modal-body px-5">
                    <div class="row rounded" id="target_payment_receipt">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center mb-5">
                                <img src="{{ asset('/logo.png') }}" height="120" width="120">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_member_name"></label>
                                <label>Member Name</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_member_phone"></label>
                                <label>Member Phone</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_registration_fees"></label>
                                <label>Registration Fees</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_paid_extra_charges"></label>
                                <label>Extra Charges Paid</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_classes_fees"></label>
                                <label>Classes Fees</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_paid_fees"></label>
                                <label>Fees Paid</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_ptf"></label>
                                <label>PTF Paid</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_ihtf"></label>
                                <label>IHTF Paid</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_discount"></label>
                                <label>Discount</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_pending_fees"></label>
                                <label>Fees Pending</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_ptf_pending"></label>
                                <label>PTF Pending</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_total_payment"></label>
                                <label>Total Fees Paid</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_total_pending_fees"></label>
                                <label>Total Pending Fees</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label id="receipt_payment_method"></label>
                                <label>Payment Method</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <label id="receipt_payment_date"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="payment-receipt-pdf" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Payment Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row rounded" id="target_payment_receipt">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('/logo.png') }}" height="120" width="120">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Member Name</label>
                                <label id="receipt_member_name"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Member Phone</label>
                                <label id="receipt_member_phone"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Registration Fees</label>
                                <label id="receipt_registration_fees"></label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Extra Charges Paid</label>
                                <label id="receipt_paid_extra_charges"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Classes Fees</label>
                                <label id="receipt_classes_fees"></label>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Fees Paid</label>
                                <label id="receipt_paid_fees"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>PTF Paid</label>
                                <label id="receipt_ptf"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>IHTF Paid</label>
                                <label id="receipt_ihtf"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Discount</label>
                                <label id="receipt_discount"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Fees Pending</label>
                                <label id="receipt_pending_fees"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>PTF Pending</label>
                                <label id="receipt_ptf_pending"></label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Total Fees Paid</label>
                                <label id="receipt_total_payment"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Total Pending Fees</label>
                                <label id="receipt_total_pending_fees"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <label>Payment Method</label>
                                <label id="receipt_payment_method"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <label id="receipt_payment_date"></label>
                            </div>
                        </div>
                    </div>
{{--                    <div class="modal-footer">--}}
{{--                        <button type="submit"--}}
{{--                                class="btn btn-block btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"--}}
{{--                                id="export_tooo" data-size="xs">--}}
{{--                            Export to JPG--}}
{{--                        </button>--}}
{{--                    </div>--}}

                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-block btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                data-size="xs" id="download_pdf">
                            Export to PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="confirm-pending-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0"><span id="member_name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row">
                    <div class="modal-body">
                        <form id="pending-payments">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table class="table table-dark">
                                            <thead>
                                            <tr>
                                                <th>Pending Fees</th>
                                                <th>Pending Personal Training Fees</th>
                                                <th>Total Payment</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr id="on_pending_payment_description">

                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select Payment Method</label>
                                        <select class="form-control select2-multiple" id="select_payment_method"
                                                name="payment_method" data-placeholder="Choose ...">
                                            @foreach(getPossibleEnumValues('fees', 'payment_method') as $method)
                                                <option class="text-capitalize"
                                                        value="{{ $method }}" {{ ($method === 'cash') ? 'selected' : '' }}>{{ ucwords($method) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p id="pending-fee-notice"></p>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit"
                                                class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                                id="yes_pending_payment_confirmed" data-size="xs">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-outline-dark waves-effect"
                                                id="no_pending_payment_confirmed" data-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
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


    <div class="modal fade bs-example-modal-sm" id="member-fee-update-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member-already-fee"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="modal-body">
                        <form id="member-fee">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Member fees </label>
                                    <input name="fees" type="text" class="form-control"
                                           placeholder="Fees" value="0" id="member_already_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit"
                                                class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                                id="yes_fee_update_confirmed" data-size="xs">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-outline-dark waves-effect"
                                                id="no_fee_update_confirmed" data-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" id="member-ptf-update-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member-already-ptf-fee"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="modal-body">
                        <form id="member-ptf-fee">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Member PTF </label>
                                    <input name="personal_training_fees" type="text" class="form-control"
                                           placeholder="Fees" value="0" id="member_already_ptf_fees"
                                           data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                           data-parsley-type="digits"/>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit"
                                                class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                                id="yes_ptf_update_confirmed" data-size="xs">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-outline-dark waves-effect"
                                                id="no_ptf_update_confirmed" data-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" id="member-reg-update-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member-already-reg-date"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="modal-body">
                        <form id="member-regForm">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>update Register Date<span style="color: red"> *</span></label>
                                    <input name="reg_date" type="date" class="form-control"
                                           placeholder="Member Register date" id="update-member-reg-date"/>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit"
                                                class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                                id="yes_reg_date_update_confirmed" data-size="xs">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-outline-dark waves-effect"
                                                id="no_reg_date_update_confirmed" data-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" id="select-member-classes-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member-classes-notic"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="modal-body">
                        <form id="select-member-class">
                            @csrf

                                <div class="col-md-12 select_classes_div">
                                    <div class="form-group">
                                        <label>Select Classes</label>
                                        <select name="classes[]" class="form-control select2-multiple select_classes "
                                                multiple
                                                data-placeholder="Choose ...">
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">{{ ucwords($class->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 select_classes_fees_div">
                                    <div class="form-group">
                                        <label>Class Fee Structure <span
                                                style="color: red"> *</span></label>
                                        <input name="classes_fees" type="text" class="form-control"
                                               placeholder="Fee Structure" id="classes_fees_structure"
                                               data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                               value="0"
                                               data-parsley-type="digits"/>
                                    </div>


                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit"
                                                class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                                id="yes_reg_date_update_confirmed" data-size="xs">
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-outline-dark waves-effect"
                                                id="no_reg_date_update_confirmed" data-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" id="edit-member-classes-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-user"
         aria-hidden="true">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="member-classes-notic"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="modal-body">
                        <form id="update-member-class">
                            @csrf

                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label>Select Classes</label>
                                    <select name="classes[]" class="form-control select2-multiple edit_select_classes " multiple
                                            data-placeholder="Choose ...">

                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-12 ">
                                   <div class="form-group">
                                       <label>Class Fee Structure <span
                                               style="color: red"> *</span></label>
                                       <input name="classes_fees" type="text" class="form-control"
                                              placeholder="Fee Structure" id="edit_classes_fees_structure"
                                              data-parsley-validation-threshold="1" data-parsley-trigger="keyup" value="0"
                                              data-parsley-type="digits"/>
                                   </div>


                               </div>

                            <div class="col-md-12">
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                            id="yes_reg_date_update_confirmed" data-size="xs">
                                        Submit
                                    </button>
                                    <button type="button" class="btn btn-outline-dark waves-effect"
                                            id="no_reg_date_update_confirmed" data-dismiss="modal">Close
                                    </button>

                                </div>
                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="classes-fees-modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0"><span id="class-member_name" style="color: black"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-size="xs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row">
                    <div class="modal-body">
                        <form id="payment-classes">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table class="table table-white">
                                            <thead>

                                            <tbody>
                                            <tr id="on_classes_payment_description">

                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <input type="hidden" name="classes_fees" value="" id="member-classes-fees-payment">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Payment Date<span style="color: red"> *</span></label>
                                        <input name="payment_date" type="date" class="form-control"
                                               placeholder="Member Created date" id="member_payment_date" data-parsley-required />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select Payment Method</label>
                                        <select class="form-control select2-multiple" id="select_payment_method"
                                                name="payment_method" data-placeholder="Choose ...">
                                            @foreach(getPossibleEnumValues('fees', 'payment_method') as $method)
                                                <option class="text-capitalize"
                                                        value="{{ $method }}" {{ ($method === 'cash') ? 'selected' : '' }}>{{ ucwords($method) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p id="pending-fee-notice"></p>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit"
                                                class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                                id="yes_pending_payment_confirmed" data-size="xs">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-outline-dark waves-effect"
                                                id="no_pending_payment_confirmed" data-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@include('backend.members.ajax.index')

