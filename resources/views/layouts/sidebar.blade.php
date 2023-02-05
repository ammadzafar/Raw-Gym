<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">
        <div class="user-wid text-center py-4">
            <div class="user-img">
                    <img src="{{asset(auth()->user()->image ?? 'images/users/noprofile.jfif')}}" alt=""
                         class="avatar-md profile_image mx-auto rounded-circle">
            </div>
            <div class="mt-3">

                <a href="#" class="text-dark font-weight-medium font-size-16">{{auth()->user()->name}}</a><br>
                <p class="text-body mt-1 mb-0 font-size-13 badge badge-light badge-pill"></p>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu" class="new-sidebar">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                @canany(array('dashboard', 'dashboard_income_expense', 'dashboard_members','attendance_report'))
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-monitor-dashboard"></i><span
                                class="badge badge-pill"></span>
                            <span>Dashboard Analytics</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                            @canany(array('dashboard_members'))
                                <li><a href="{{route('dashboard.members-view')}}">Members</a></li>
                            @endcanany
                            @canany(array('dashboard_income_expense'))
                                <li><a href="{{route('dashboard.income-expense-view')}}">Income/Expense</a></li>
                            @endcanany
                            {{-- @canany(array('attendance_report'))
                                <li><a href="{{route('dashboard.report')}}">Attendance Report</a></li>
                            @endcanany --}}
                        </ul>
                    </li>
                @endcanany
                @canany(array('financial_report'))
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-file"></i><span
                                class="badge badge-pill badge-info float-right"></span>
                            <span>Reports</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('dashboard.payments.report')}}">Payments Report</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('dashboard.report')}}">Attendance Report</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('dashboard.expense.report')}}">Expense Report</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('dashboard.member.report')}}">Member Report</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('dashboard.membership.type.report')}}">Membership Types Report</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('dashboard.expense.income.report')}}">Expenses & Income Report</a></li>
                        </ul>
                    </li>
                @endcanany
                @canany(array('attendance_list', 'attendance_mark'))
                    <li>
                        <a href="{{route('attendances.days')}}" class="waves-effect">
                            <i class="mdi mdi-presentation"></i>
                            <span>Attendance By Days</span></a>
                    </li>
                @endcanany
                @canany(array('member_list', 'member_create', 'member_edit', 'member_delete', 'member_expire_list', 'member_pending_fees_list', 'make_payment', 'member_view'))

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-vpn"></i><span
                                class="badge badge-pill badge-info float-right"></span>
                            <span>Member's Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @canany(array('member_list', 'make_payment', 'member_create', 'member_edit', 'member_delete', 'member_view'))
                                <li class="{{ \Request::get('type')=='all' ? 'mm-active' : '' }}"><a
                                        class="{{ \Request::get('type')=='all' ? 'active' : '' }}"
                                        href="{{ route('members', ['type' => 'all']) }}">All Members</a></li>
                            @endcanany
                            @canany(array('member_expire_list', 'make_payment', 'member_create', 'member_edit', 'member_delete', 'member_view'))
                                <li class="{{ \Request::get('type')=='expire' ? 'mm-active' : '' }}"><a
                                        class="{{ \Request::get('type')=='expire' ? 'active' : '' }}"
                                        href="{{ route('members', ['type' => 'expire']) }}">Expire Members <span
                                            style="color: red">({{@$expireMember}})</span></a></li>
                            @endcanany
                            @canany(array('member_pending_fees_list', 'make_payment', 'member_create', 'member_edit', 'member_delete', 'member_view'))
                                <li class="{{ \Request::get('type')=='guest_member' ? 'mm-active' : '' }}"><a
                                        class="{{ \Request::get('type')=='guest_member' ? 'active' : '' }}"
                                        href="{{ route('members', ['type' => 'guest_member']) }}">Guest </a>
                                </li>
                            @endcanany
                            @canany(array('member_pending_fees_list', 'make_payment', 'member_create', 'member_edit', 'member_delete', 'member_view'))
                                <li class="{{ \Request::get('type')=='membership' ? 'mm-active' : '' }}"><a
                                        class="{{ \Request::get('type')=='membership' ? 'active' : '' }}"
                                        href="{{ route('members', ['type' => 'membership']) }}">With Membership </a>
                                </li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany
                @canany(array('classes_create','classes_list','classes_edit','classes_delete'))
                    <li>
                        <a href="{{ route('classes') }}" class="waves-effect">
                            <i class="mdi mdi-google-classroom "></i>
                            <span>Classes</span>
                        </a>
                    </li>
                @endcanany
                {{--@canany(array('locker_list'))
                    <li>
                        <a href="{{ route('lockers') }}" class="waves-effect">
                            <i class="mdi mdi-cloud-lock"></i>
                            <span>Lockers</span>
                        </a>
                    </li>
                @endcanany--}}

                {{--                @canany(array('tag_list', 'tag_create', 'tag_edit', 'tag_delete', 'brand_list', 'brand_create', 'brand_edit', 'brand_delete', 'category_list', 'category_create', 'category_edit', 'category_delete', 'order_list', 'order_create', 'order_edit', 'order_delete', 'goal_list', 'goal_create', 'goal_edit', 'goal_delete'))

                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="mdi mdi-vpn"></i><span
                                                class="badge badge-pill badge-info float-right"></span>
                                            <span>E-Commerce</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            @canany(array('tag_list', 'tag_create', 'tag_edit', 'tag_delete'))
                                                <li><a href="{{ route('tags') }}">Tags</a></li>
                                            @endcanany
                                            @canany(array('brand_list', 'brand_create', 'brand_edit', 'brand_delete'))
                                                <li><a href="{{ route('brands') }}">Brands</a></li>
                                            @endcanany
                                            @canany(array('category_list', 'category_create', 'category_edit', 'category_delete'))
                                                <li><a href="{{ route('categories') }}">Category</a></li>
                                            @endcanany
                                            @canany(array('attribute_list', 'attribute_create', 'attribute_edit', 'attribute_delete'))
                                                <li><a href="{{ route('attributes') }}">Attribute</a></li>
                                            @endcanany
                                            @canany(array('value_list', 'value_create', 'value_edit', 'value_delete'))
                                                <li><a href="{{ route('values') }}">Attribute Value</a></li>
                                            @endcanany
                                            @canany(array('product_list', 'product_create', 'product_edit', 'product_delete'))
                                                <li><a href="{{ route('listProducts') }}">Product</a></li>
                                            @endcanany
                                            @canany(array('order_list', 'order_create', 'order_edit', 'order_delete'))
                                                <li><a href="{{ route('orders') }}">Orders</a></li>
                                            @endcanany
                                            @canany(array('goal_list', 'goal_create', 'goal_edit', 'goal_delete'))
                                                <li><a href="{{ route('goals') }}">Goals</a></li>
                                            @endcanany
                                        </ul>
                                    </li>
                                @endcanany--}}
                {{-- @canany(array('newsletter_list'))
                     <li>
                         <a href="{{ route('newsletters') }}" class="waves-effect">
                             <i class=" mdi mdi-email-newsletter "></i>
                             <span>Newsletter</span>
                         </a>
                     </li>
                 @endcanany
                 @canany(array('consultation_list'))
                     <li>
                         <a href="{{ route('consultations') }}" class="waves-effect">
                             <i class=" mdi mdi-vpn "></i>
                             <span>Consultation(<b
                                     style="color: #87CEEB">{{ \App\Models\Consultation::where('view',0)->count() }}</b>)</span>
                         </a>
                     </li>
                 @endcanany--}}
                @canany(array('expense_list' , 'expense_create', 'expense_edit', 'expense_delete'))
                    <li>
                        <a href="{{ route('expenses') }}" class="waves-effect">
                            <i class="mdi mdi-currency-usd"></i>
                            <span>Expense<b style="color: #87CEEB"></b></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('expense.category.index') }}" class="waves-effect">
                            <i class="mdi mdi-currency-usd"></i>
                            <span>Expense Category<b style="color: #87CEEB"></b></span>
                        </a>
                    </li>
                @endcanany
                @canany(array('membership_list', 'membership_create', 'membership_edit', 'membership_delete'))
                    <li>
                        <a href="{{route('memberships')}}" class="waves-effect">
                            <i class=" mdi mdi-wallet-membership "></i>
                            <span>Memberships</span></a>
                    </li>
                @endcanany
                @canany(array('role_list', 'role_create', 'role_edit', 'role_delete', 'user_list', 'user_create', 'user_edit', 'user_delete'))
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-account"></i><span
                                class="badge badge-pill badge-info float-right"></span>
                            <span>User Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @canany(array('role_list', 'role_create', 'role_edit', 'role_delete'))
                                <li><a href="{{route('roles')}}">Roles</a></li>
                            @endcanany
                            @canany(array('user_list', 'user_create', 'user_edit', 'user_delete'))
                                <li><a href="{{route('users')}}">Users</a></li>
                            @endcanany

                          {{--  @canany(array('user_attendance'))
                                <li><a href="{{route('userAttendances')}}">User Attendance</a></li>
                            @endcanany--}}
                        </ul>
                    </li>
                @endcanany
                @canany(array('trashed_memberships', 'trashed_roles', 'trashed_users', 'trashed_members'))
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-trash-can-outline"></i><span
                                class="badge badge-pill badge-info float-right"></span>
                            <span>Trashed Items</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @canany(array('trashed_roles'))
                                <li><a href="{{ route('roles.trashed') }}">Roles</a></li>
                            @endcanany
                            @canany(array('trashed_users'))
                                <li><a href="{{ route('users.trashed') }}">Users</a></li>
                            @endcanany
                            @canany(array('trashed_members'))
                                <li><a href="{{ route('members.trashed') }}">Members</a></li>
                            @endcanany
                            @canany(array('trashed_memberships'))
                                <li><a href="{{ route('memberships.trashed') }}">Memberships</a></li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
