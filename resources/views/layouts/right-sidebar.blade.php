<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">Pending dues Members</h5>
        </div>

        <div class="container">
            <ul class="inbox-wid list-unstyled">
                @php
                $members = \App\Models\Member::all();
             //  $fees = \App\Models\Fee::whereStatus('pending')->firstOrfail();
                @endphp

                @foreach($members as $member)
                    @if($member->fees()->exists())
                    @if($member->fees()->latest()->first()->status == 'pending')
                <li class="inbox-list-item">
                    <a href="{{ route('member.show', @$member->id) }}">
                        <div class="d-flex align-items-start">
                            <div class="me-3 align-self-center">
                                <img src="{{ asset($member->image??'/images/users/noprofile.jfif')}}" alt="" class="avatar-sm rounded-circle">
                            </div>
                            <div class="flex-1 ml-2 overflow-hidden">
                                <h5 class="font-size-16 mb-1">{{$member->name}}</h5>
                                @php
                                  $totalPending=  $member->fees()->latest()->first()->pending_fees +$member->fees()->latest()->first()->pending_personal_training_fees;
                                @endphp
                                <p class="text-truncate mb-0">Total Pending: {{$totalPending}} {{ env('CURRENCY', 'PKR') }}</p>
                            </div>
                            <div class="font-size-12 ms-auto">

                            </div>
                        </div>
                    </a>
                </li>
                    @endif
                    @endif
                @endforeach
            </ul>

            {{--<div class="text-center">
                <a href="#" class="btn btn-primary btn-sm">Load more</a>
            </div>--}}
        </div>
    </div>
    <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
