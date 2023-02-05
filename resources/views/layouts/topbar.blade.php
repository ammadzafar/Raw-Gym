<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-right">

                <div class="dropdown d-inline-block d-lg-none ml-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                           aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>
                @php
                  $today = \Carbon\Carbon::today();
                    $currentMonth = $today->month;
                    $birthyDayMemberCount =   \App\Models\Member::whereMonth('dob',$currentMonth)->whereDay('dob',$today)->count();
                    $members =   \App\Models\Member::whereMonth('dob',$currentMonth)->whereDay('dob',$today)->get();

                @endphp

                <div class="dropdown d-inline-block">
                  {{--  <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>
                        <span class="badge badge-danger badge-pill">{{$birthyDayMemberCount}}</span>
                    </button>--}}
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0">Birthday Notifications</h6>
                                </div>
                                <div class="col-auto">
                                    {{--<a href="#!" class="small"> View All</a>--}}
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            @foreach($members as $member)

                                <a href="{{ route('member.show', $member->id) }}" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <img src="{{asset($member->image??"images/users/noprofile.jfif")}}" class="rounded-circle" style="width: 2.5rem;height: 2.5rem;">
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1"
                                                style="left:30px;padding-left: 8px;text-transform: capitalize">{{$member->name}}</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" style="padding-left: 6px; text-transform: capitalize">
                                                    Wish Happy Birthday to <b
                                                        style="color: yellowgreen">{{$member->name}}</b></p>
                                                {{--<p class="mb-0"><i class="mdi mdi-clock-outline"></i></p>--}}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                        {{-- <div class="p-2 border-top">
                             <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                 <i class="mdi mdi-arrow-right-circle mr-1"></i> View More..
                             </a>
                         </div>--}}
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle profile_image  header-profile-user"
                                 src="{{asset(auth()->user()->image??'images/users/noprofile.jfif')}}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1">{{auth()->user()->name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{route('profile')}}"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-dark" href="{{route('logout')}}"><i
                                class="bx bx-power-off font-size-16 align-middle mr-1 text-dark"></i>Logout</a>
                    </div>
                </div>

                {{--<div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="mdi mdi-settings-pending">Pending</i>
                    </button>
                </div>--}}

            </div>
            <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">
{{--                    <a href="{{url('/')}}" class="logo logo-dark text-center">--}}
{{--                        <span class="logo-sm">--}}
{{--                            <img src="{{asset('images/logo-dark-sm.png')}}" alt="">--}}
{{--                        </span>--}}
{{--                        <span class="logo-lg">--}}
{{--                            <img src="{{asset('images/logo-dark-lg.png')}}" alt="">--}}
{{--                        </span>--}}
{{--                    </a>--}}

                    <a href="{{ url('/') }}" class="logo logo-light text-center">
                        <div class="logo-sm">
                            <img src="{{asset('images/logo-light-sm.png')}}" alt="">
                        </div>
                        <div class="logo-lg" style="width:50%; margin: 0 auto">
                            <img src="{{asset('images/logo-light-lg.png')}}"  height="auto" width="100%" alt="">
                        </div>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                        id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-inline-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form>

            </div>

        </div>
    </div>
</header>
