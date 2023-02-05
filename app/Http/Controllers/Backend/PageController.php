<?php

namespace App\Http\Controllers\Backend;

use App\Jobs\SendDuesEmailToExpireMembers;
use App\Models\Clas;
use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use App\Models\ExpenseList;
use App\Models\Fee;
use App\Models\Locker;
use App\Models\Member;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserAttendance;
use App\Support\CustomPaginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use App\Models\Attendance;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:member_list|member_create|member_edit|member_delete|member_view', ['only' => ['members']]);
        $this->middleware('permission:user_list|user_create|user_edit|user_delete', ['only' => ['users']]);
        $this->middleware('permission:role_list|role_create|role_edit|role_delete', ['only' => ['roles']]);
        $this->middleware('permission:membership_list|membership_create|membership_edit|membership_delete', ['only' => ['memberships']]);
        $this->middleware('permission:attendance_list|attendance_mark', ['only' => ['attendancesByDays']]);
        $this->middleware('permission:attendance_mark', ['only' => ['attendances']]);
        $this->middleware('permission:expense_list|expense_create|expense_edit|expense_delete', ['only' => ['expenses']]);
        $this->middleware('permission:tag_list|tag_create|tag_edit|tag_delete', ['only' => ['tags']]);
        $this->middleware('permission:brand_list|brand_create|brand_edit|brand_delete', ['only' => ['brands']]);

        $this->middleware('permission:user_attendance', ['only' => ['userAttendance']]);
        $this->middleware('permission:category_list|category_create|category_edit|category_delete', ['only' => ['categories']]);
        $this->middleware('permission:attribute_list|attribute_create|attribute_edit|attribute_delete', ['only' => ['attributes']]);
        $this->middleware('permission:value_list|value_create|value_edit|value_delete', ['only' => ['values']]);
        $this->middleware('permission:product_list|product_create|product_edit|product_delete', ['only' => ['products']]);
        $this->middleware('permission:locker_list|locker_create|locker_edit|locker_delete', ['only' => ['lockers']]);
        $this->middleware('permission:trashed_memberships', ['only' => ['trashedMemberships']]);
        $this->middleware('permission:trashed_roles', ['only' => ['trashedRoles']]);
        $this->middleware('permission:trashed_users', ['only' => ['trashedUsers']]);
        $this->middleware('permission:trashed_members', ['only' => ['trashedMembers']]);
        $this->middleware('permission:goal_list|goal_create|goal_edit|goal_delete', ['only' => ['goals']]);
        $this->middleware('permission:order_list|order_create|order_edit|order_delete', ['only' => ['orders']]);
    }

    public function members(Request $request)
    {
        $memberships = Membership::active(true)->get();
        $classes = Clas::all();
        $members = collect();
        if ($request->type == 'expire') {
            $members = Member::where('name', 'LIKE', '%' . $request->get('query') . '%')->expire(true);
            if ($request->get('gender')) {
                $members = $members->where('gender', $request->get('gender'));
            }
            $members = $members->latest()->get();

            $members = $members->sortByDesc('expired_at');

        } elseif ($request->type == 'guest_member') {
            $members = Member::where('name', 'LIKE', '%' . $request->get('query') . '%')->where('guest_member', 1);
            if ($request->get('gender')) {
                $members = $members->where('gender', $request->get('gender'));
            }
            $members = $members->latest()->get();
        } elseif ($request->type == 'membership') {
            $members = Member::where('name', 'LIKE', '%' . $request->get('query') . '%')->where('membership_id', '!=', null);
            if ($request->get('gender')) {
                $members = $members->where('gender', $request->get('gender'));
            }
            $members = $members->latest()->get();
        } else if ($request->type == 'pending_fees') {

            $members_list = Member::where('name', 'LIKE', '%' . $request->get('query') . '%')->expire(true);

            if ($request->get('gender')) {
                $members_list->where('gender', $request->get('gender'));
            }
            $members_list = $members_list->get();

            $temp_collection = collect();
            if ($members_list->count()) {
                foreach ($members_list as $member) {
                    if ($member->fees()->exists()) {
                        if ($member->fees()->latest()->first()->status == 'pending') {
                            $temp_collection->push($member);
                        }
                    }
                }
            }
            $members = $temp_collection;
        } else {
            $members = Member::where('name', 'LIKE', '%' . $request->get('query') . '%');

            if ($request->get('gender')) {
                $members = $members->where('gender', '=', $request->get('gender'));
            }
            $members = $members->latest()->get();
        }


        $members = CustomPaginate::paginate($members, 20);

        return view('backend.members.index', [
            'memberships' => $memberships,
            'members' => $members,
            'type' => $request->type,
            'classes' => $classes,
        ]);
    }

    public function users()
    {
        // $roles = Role::where('name', '!=', 'super-admin')->get();
        $roles = Role::all();
        $members = Member::get();

        return view('backend.users.index', [
            'roles' => $roles,
            'members' => $members
        ]);
    }

    public function roles()
    {
        $permissions = Permission::all();

        return view('backend.roles.index', [
            'permissions' => $permissions,
        ]);
    }

    public function memberships()
    {
        $memberships = Membership::latest()->get();
        return view('backend.memberships.index', [
            'memberships' => $memberships
        ]);
    }

    public function attendancesByDays()
    {
        $start = Carbon::now()->format('Y-m-d');
        $end = Carbon::now()->subDays(31)->format('d F Y');

        $period = CarbonPeriod::create($end, $start);

        $data = [];
        foreach ($period as $date) {

            $temp = [
                'day' => $date,
                'presents' => Attendance::whereDate('date', $date)->where('clock_in', '!=', null)->count(),
                'absents' => Attendance::whereDate('date', $date)->where('clock_in', null)->count(),
            ];

            array_push($data, $temp);
        }

        return view('backend.attendances.attendancebydays.index', ['data' => array_reverse($data)]);
    }

    public function attendances($date)
    {
        $date = Carbon::create($date);
        $attendances = Attendance::whereDate('date', $date)->get();
        return view('backend.attendances.index', [
            'date' => $date,
            'attendances' => $attendances,
        ]);
    }

    public function attendancesByMonths()

    {
        $now = Carbon::now();
        $period = now()->startOfMonth()->subMonths($now->month)->monthsUntil(now());

        $data = [];
        foreach ($period as $date) {

            $temp = [
                'month' => $date,
                'absents' => Attendance::whereMonth('date', $date)->whereYear('date', $date)->whereStatus('absent')->count(),
                'presents' => Attendance::whereMonth('date', $date)->whereYear('date', $date)->whereStatus('present')->count(),
            ];

            array_push($data, $temp);
        }

        return view('backend.attendances.attendancebymonths.index', ['data' => array_reverse($data)]);
    }

    public function attendancesBySingleMonths($month)
    {

        $start = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($month)->endOfMonth()->format('Y-m-d');
        $period = CarbonPeriod::create($start, $end);


        $data = [];
        foreach ($period as $date) {


            $temp = [
                'day' => $date,
                'absents' => Attendance::whereDate('date', $date)->whereStatus('absent')->count(),
                'presents' => Attendance::whereDate('date', $date)->whereStatus('present')->count(),
            ];

            array_push($data, $temp);
        }

        return view('backend.attendances.attendancebydays.index', ['data' => array_reverse($data)]);

    }

    public function userProfile()
    {
        return view('backend.userprofile.index');
    }

    public function newsletter()
    {
        return view('backend.newsletter.index');
    }

    public function consultation()
    {
        return view('backend.consultation.index');
    }

    public function expense()
    {
        $statuses = getPossibleEnumValues('expense_lists', 'status');

        $expenses = Expense::orderBy('date', 'desc')->get();
        $categories = ExpenseCategory::all();

        $dates = collect();
        foreach ($expenses as $expense) {
            $temp = [
                'date' => new Carbon($expense->date),
                'count' => $expense->expenseList->count(),
                'amount' => $expense->expenseList->sum('amount')
            ];
            $dates->push($temp);
        }

        $expenses = CustomPaginate::paginate($dates, 24);

        return view('backend.expense.index', [
            'expensesDates' => $expenses,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }


    public function welcome()
    {
        return view('backend.welcome.index');
    }

    public function tags()
    {
        return view('backend.tags.index');
    }

    public function brands()
    {
        return view('backend.brands.index');
    }

    public function userAttendance($date)
    {
        $date = Carbon::create($date);
        $attendances = UserAttendance::whereDate('shift_time', $date)->paginate(20);

        return view('backend.userattendances.index', [
            'date' => $date,
            'attendances' => $attendances,
        ]);
    }

    public function attendancesInDays()
    {
        $start = Carbon::now()->format('Y-m-d');
        $end = Carbon::now()->subDays(11)->format('d F Y');

        $period = CarbonPeriod::create($end, $start);

        $data = [];
        foreach ($period as $date) {

            $temp = [
                'day' => $date,
                'present' => UserAttendance::whereDate('shift_time', $date)->whereStatus('present')->count(),
                'absent' => UserAttendance::whereDate('shift_time', $date)->whereStatus('absent')->count(),
                'leave' => UserAttendance::whereDate('shift_time', $date)->whereStatus('leave')->count(),
                'public_holiday' => UserAttendance::whereDate('shift_time', $date)->whereStatus('public_holiday')->count(),
                'weekend' => UserAttendance::whereDate('shift_time', $date)->whereStatus('weekend')->count(),
            ];

            array_push($data, $temp);
        }

        return view('backend.userattendances.attendancebydays.index', ['data' => array_reverse($data)]);
    }

    public function category()
    {
        $categories = Category::whereNull('category_id')->get();
        return view('backend.category.index', [
            'categories' => $categories
        ]);
    }

    public function attribute()
    {
        return view('backend.attribute.index');
    }

    public function value()
    {
        $attributes = Attribute::all();
        return view('backend.value.index', [
            'attributes' => $attributes
        ]);
    }

    public function addProduct()
    {
        $tags = Tag::whereStatus(true)->get();
        $brands = Brand::whereStatus(true)->get();
        $categories = Category::whereStatus(true)->whereNull('category_id')->with('subCategories')->get();
        $attributes = Attribute::with('values')->get();
        $statuses = getPossibleEnumValues('variants', 'status');

        return view('backend.product.create', [
            'tags' => $tags,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'statuses' => $statuses
        ]);
    }

    public function listProduct()
    {
        return view('backend.product.index');
    }

    public function lockers()
    {
        $lockers = Locker::all();
        $members = Member::all();
        //$lockermember = Member::with('locker')->get();

        return view('backend.locker.index', ['lockers' => $lockers, 'members' => $members]);
    }

    public function trashedMemberships()
    {
        $memberships = Membership::onlyTrashed()->latest()->get();

        return view('backend.memberships.trashed', [
            'memberships' => $memberships
        ]);
    }

    public function trashedRoles()
    {
        return view('backend.roles.trashed');
    }

    public function trashedUsers()
    {
        return view('backend.users.trashed');
    }

    public function trashedMembers()
    {
        $members = Member::onlyTrashed()->paginate(12);

        return view('backend.members.trashed', [
            'members' => $members,
        ]);
    }

    public function goals()
    {
        $categories = Category::whereNotNull('category_id')->get();

        return view('backend.goals.index', [
            'categories' => $categories,
        ]);
    }

    public function orders()
    {
        return view('backend.orders.index');
    }

    public function classes()
    {
        return view('backend.classes.index');
    }

    public function expenseCategory()
    {
        $categories = ExpenseCategory::paginate(10);
        return view('backend.expense-category.index', compact('categories'));
    }

    public function expenseCategoryStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $category = new ExpenseCategory();
            $category->name = $request->name;
            $category->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => $exception->getMessage()
            ], 501);
        }
        return response()->json([
            'message' => 'Expense Category Successfully Created'
        ], 201);
    }

    public function expenseCategoryEdit(Request $request)
    {
        $category = ExpenseCategory::find($request['id']);
        return response()->json($category);
    }

    public function expenseCategoryUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $category = ExpenseCategory::find($request->category_id);
            $category->name = $request->name;
            $category->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => $exception->getMessage()
            ], 501);
        }
        return response()->json([
            'message' => 'Expense Category Successfully Updated'
        ], 201);
    }

    public function expenseCategoryDelete(Request $request)
    {
        $category = ExpenseCategory::find($request['id']);
        $category->delete();
        return response()->json([
            'success' => 'Expense Category Successfully Deleted'
        ], 201);
    }

    public function financialReport(Request $request)
    {
        $date = explode('-', $request->filter_date);
        $from = Carbon::parse($date[0])->format('Y-m-d');
        $to = Carbon::parse($date[1])->format('Y-m-d');
        if ($request->filter_name == 'personal_training_fees') {
            $record = Fee::where('member_id', $request->member_id)
                ->select('personal_training_fees as amount', 'payment_date as date')
                ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)
                ->get();
//            dd($record[0]['payment_date']->toDateString());

        }
        if ($request->filter_name == 'in_house_training_fees') {
            $record = Fee::where('member_id', $request->member_id)
                ->select('in_house_training_fees as amount', 'payment_date as date')
                ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)
                ->get();
//            dd($record[0]['payment_date']->toDateString());

        }
        if ($request->filter_name == 'classes_fees') {
            $record = Fee::where('member_id', $request->member_id)
                ->select('classes_fees as amount', 'payment_date as date')
                ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)
                ->get();
        }
        if ($request->filter_name == 'membership_fees') {
            $record = DB::table('fees as fee')
                ->join('memberships as membership','membership.id','=','fee.membership_id')
                ->select('fee.payment_date as date','membership.fees as amount')
                ->where('fee.member_id', $request->member_id)
                ->whereDate('fee.created_at', '>=', $from)->whereDate('fee.created_at', '<=', $to)
                ->get();
        }
        return response()->json($record);
    }

    public function attendanceRecord(Request $request)
    {
        $date = explode('-', $request->filter_date);
        $from = Carbon::parse($date[0])->format('Y-m-d');
        $to = new Carbon(Carbon::parse($date[1])->format('Y-m-d'));
        $to = $to->addDay(1)->toDateString();
        $records = Attendance::select(DB::raw('DATE_FORMAT(date, "%d-%b-%Y") as date'),'status','clock_in','clock_out')
            ->where('member_id', $request->filter_member_id)
            ->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)
            ->get();
//        dd($records);
        return \datatables()->of($records)->make(true);
    }
}
