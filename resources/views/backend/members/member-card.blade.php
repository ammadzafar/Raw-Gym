<div class="row members_list">
    @forelse($members as $member)
        <div class="col-md-3 filtered filter-{{$member->gender}}">
            <div class="card">
                <div class="member-card">
                    <div class="ribbon ribbon-top-left">
                        @php
                            $expired = '';
                            $status = '';
                            $color = '';
                            $gender ='';
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
                        <span style="background-color: {{ $color }}">
                            {{ $status }}
                            @if($member->guest_member)
                                {{'Guest'}}
                            @endif

                        </span>
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
                                <p class="text-body mt-1 mb-1"><small><b>Roll No: </b>{{ $member->roll_number }}</small>
                                <p class="text-body mt-1 mb-1"><small><b>{{ $member->membership ? "Membership:" : '' }} </b>{{ $member->membership ? $member->membership->name : '' }}</small>
                                @if($member->fees()->latest()->first() != null)
                                <p class="text-body mt-1 mb-1"><small><b>Expiry Date: </b>{{ $member->fees()->latest()->first()->expire_date->format('j-M-Y') }}</small>
                                @endif
                                </p>
                            {{--<p class="text-body mt-1 mb-1">{{ $member->phone }}</p>--}}

{{--                            <span class="badge badge-{{ $member->is_expired ? 'danger' : 'success' }}">{{ $member->is_expired ? 'Expired' : 'Not Expired' }}</span>--}}


                                @if(!$member->guest_member)
                                    @if($member->fees()->latest()->first() != null)
                                        <span class="badge badge-{{ $member->fees()->latest()->first()->expire_date < \Carbon\Carbon::now()->toDateString() ? 'danger' : 'success' }}">{{ $member->fees()->latest()->first()->expire_date < \Carbon\Carbon::now()->toDateString() ? 'Expired' : '' }}</span>
                                        @php
                                            $expired =  $member->fees()->latest()->first()->expire_date < \Carbon\Carbon::now()->toDateString();
                                        @endphp
                                    @endif
                                @endif





{{--                            @php--}}

{{--                                $memberExpire = $member->fees()->latest()->first()->expire_date->toDateString();--}}
{{--                                $diff = now()->diffInDays($memberExpire);--}}

{{--                            @endphp--}}

                            @php

                                $memberExpire = $member->fees()->latest()->first()->expire_date ?? $diff = $member->created_at;
                                $diff = Carbon\Carbon::parse($memberExpire)->diffInDays(Carbon\Carbon::now());
                                $today = \Carbon\Carbon::now();

                            @endphp

                                @if(!$member->guest_member)
                                    @if(!$expired)
                                    <!-- EXPIRE MEMMBER -->
                                        @if( $diff < 6)
                                            <span class="expired">Expires in {{ $diff }} days</span>
                                        @endif
                                    @endif
                                @endif

                            </div>

                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="dropdown text-left">
                                            <button class="btn btn-link text-dark dropdown-toggle btn-lg p-1"
                                                    type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"><i class="mdi mdi-menu-open"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <span class="dropdown-item">
                                            @if(auth()->user()->can('member_edit'))
                                                            <div class="col-4 text-center">
                                                <span class="action-edit btn btn-link text-dark btn-sm"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#edit-member-modal"><i
                                                        class="far fa-edit"></i> Edit</span>
                                                </div>
                                                        @endif
                                        </span>
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('member_view'))
                                                        <div class="col-4 text-center">
                                            <a href="{{ route('member.show', $member->id) }}"
                                               class="action-view btn btn-link text-success btn-sm"><i
                                                    class="far fa-eye"></i> View</a>
                                        </div>
                                                    @endif
                                        </span>
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('member_delete'))
                                                        <div class="col-4 text-center">
                                                <span class="action-member-delete btn btn-link text-danger btn-sm"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#confirm-member-delete-modal"><i
                                                        class="far fa-trash-alt"></i> Delete</span>
                                        </div>
                                                    @endif
                                        </span>
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('make_payment'))
                                                        <div class="col-4 text-center">
                                                <span class="action-payment-history btn btn-link btn-sm text-primary"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#payment-history-modal"><i
                                                        class="fas fa-history"></i> History</span>
                                        </div>
                                                    @endif
                                        </span>
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('make_payment'))
                                                        <div class="col-4 text-center">
                                            @if($member->fees()->exists() && ($member->fees()->latest()->first()->pending_fees || $member->fees()->latest()->first()->pending_personal_training_fees))
                                                                <span
                                                                    class="pending-payment btn btn-link btn-sm text-info"
                                                                    data-id="{{ $member->id }}" data-toggle="modal"
                                                                    data-target="#confirm-pending-modal"
                                                                ><i class=" fab fa-amazon-pay "></i> Pending Fee</span>
                                                            @else
                                                                <span
                                                                    class="action-payment btn btn-link btn-sm text-info {{ $member->membership()->exists() ? $member->membership->membership_type == "weekly" ? "weekly" : "no-weekly" : '' }}"
                                                                    data-id="{{ $member->id }}" data-toggle="modal"
                                                                    data-target="#make-payment-modal"
                                                                ><i class=" fab fa-amazon-pay "></i> Make Payment</span>
                                                            @endif
                                        </div>
                                                    @endif
                                        </span>
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('member_edit'))
                                                        <div class="col-4 text-center">
                                            <div class="custom-control custom-switch d-inline-block" dir="ltr">
                                                <input type="checkbox"
                                                       class="custom-control-input toggle-status-member"
                                                       id="member-togglstatus-{{ $member->id }}"
                                                       data-id="{{ $member->id }}" {{ $member->status ? "checked" : "" }}>
                                                <label class="custom-control-label"
                                                       for="member-togglstatus-{{ $member->id }}">Status</label>
                                            </div>
                                        </div>
                                                    @endif
                                        </span>

                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('update_member_fee'))
                                                        <div class="col-4 text-center">
                                                <span class="action-member-fees-update btn btn-link btn-sm text-primary"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#member-fee-update-modal"><i
                                                        class="fas fa-history"></i> Update Fees</span>
                                        </div>
                                                    @endif
                                        </span>
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('update_member_ptf'))
                                                        <div class="col-4 text-center">
                                                <span
                                                    class="action-member-ptf-update btn btn-link btn-sm text-danger"
                                                    data-id="{{ $member->id }}" data-toggle="modal"
                                                    data-target="#member-ptf-update-modal"><i
                                                        class="fas fa-mars-stroke"></i> update PTF</span>
                                        </div>
                                                    @endif
                                        </span>
                                                <span class="dropdown-item">

                                            @if(auth()->user()->can('update_member_reg_date'))
                                                        <div class="col-4 text-center">
                                                <span
                                                    class="action-member-reg-date-update btn btn-link btn-sm text-danger"
                                                    data-id="{{ $member->id }}" data-toggle="modal"
                                                    data-target="#member-reg-update-modal"><i
                                                        class="fab fa-hornbill "></i> Change Fee Cycle</span>
                                        </div>
                                                    @endif

                                        </span>

                                            </div>
                                        </div>

                                    </div>
                                    {{--// classes selection for members  tab--}}
                                    <div class="col-4">
                                        <div class="dropdown text-right">
                                            <button class="btn btn-link text-dark dropdown-toggle btn-lg p-1"
                                                    type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"><i class="mdi mdi-menu-open"></i>
                                            </button>
                                            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                                {{--    <span
                                                        class="dropdown-item select-classes-formember-{{ $member->id }}">
                                            @if(auth()->user()->can('member_create'))
                                                            <div class="col-4 text-center">
                                                <span class="action-edit btn btn-link text-dark btn-sm"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#select-member-classes-modal"><i
                                                        class="far fa-edit"></i> Select Classes</span>
                                                </div>
                                                        @endif
                                        </span>--}}
                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('member_edit'))
                                                        <div class="col-4 text-center">
                                                <span class="action-edit-classes btn btn-link text-dark btn-sm"
                                                      data-id="{{ $member->id }}" data-toggle="modal"
                                                      data-target="#edit-member-classes-modal"><i
                                                        class="far fa-edit"></i>Classes</span>
                                                </div>
                                                    @endif
                                        </span>


                                                <span class="dropdown-item">
                                            @if(auth()->user()->can('make_payment'))
                                                        <div class="col-4 text-center">

                                                                <span
                                                                    class="action-payment-classes btn btn-link btn-sm text-info"
                                                                    data-id="{{ $member->id }}" data-toggle="modal"
                                                                    data-target="#classes-fees-modal"
                                                                ><i class=" fab fa-amazon-pay "></i>Classes Payment</span>

                                                         </div>
                                                    @endif
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
                $params = array('type' => request()->get('type'), 'gender'=>request()->get('gender'),'query' => request()->get('query'), 'page' => request()->get('page'));
            @endphp
            {{ $members->appends($params)->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
