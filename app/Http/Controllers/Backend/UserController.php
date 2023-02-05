<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Users\StoreRequest;
use App\Http\Requests\Backend\Users\UpdateRequest;
use App\Jobs\sendPasswordJob;
use App\Models\Fee;
use App\Models\Member;
use App\Models\Salary;
use App\Models\Shift;
use App\Notifications\passwordEmail;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Backend\Salary\StoreRequest as SalaryStoreRequest;
use Carbon\Carbon;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user_list|user_create|user_edit|user_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user_delete', ['only' => ['destroy']]);
        $this->middleware('permission:make_salary', ['only' => ['paySalary']]);
        $this->middleware('permission:make_history', ['only' => ['salaryHistory']]);
        $this->middleware('permission:trashed_users', ['only' => ['trashedUsers', 'restore', 'hardDelete']]);
    }

    public function index()
    {
        // $users = User::all();

        $adminid = auth()->id();
        $users = User::where('id', '!=', $adminid)->with('salaries')->get();
        return DataTables::of($users)
            ->addColumn('created', function ($user) {
                return $user->created_at->format('d F Y');
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('action', function ($user) {

                $paid = $user->salaries()->exists() ? $user->salaries()
                    ->whereMonth('payment_date', Carbon::now()->month)
                    ->whereYear('payment_date', Carbon::now()->year)->first()
                    : null;


//                if ($paid) {
//                    $data = '<span class="action-payment btn btn-link btn-sm text-info"><i class="mdi mdi-currency-usd"></i>Paid</span>';
//                } else {
/*                $data = '<span class="action-payment btn btn-link btn-sm text-info" data-id="' . $user->id . '" data-salary="' . $user->salary . '" data-toggle="modal" data-target="#make-salary-modal"><i class="fab fa-cc-amazon-pay"> ' . ($paid ? 'Paid' : 'Salary') . '</i></span>';*/
//                }

                return (auth()->user()->can('user_edit') ? '<span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $user->id . '" data-target="#edit-user-modal"><i class="far fa-edit"></i> Edit</span>' : '')
                    . (auth()->user()->can('user_delete') ? '<span class="action-user-delete btn btn-link btn-sm text-danger btn-sm" data-toggle="modal" data-target="#user-delete-modal" data-name="' . $user->name . '" data-id="' . $user->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '')
                    . (auth()->user()->can('make_salary') ? ($user->employ_type ? $data : '') : '');
/*                    . (auth()->user()->can('make_history') ? '<span class="action-payment-history btn btn-link btn-sm text-primary" data-id="' . $user->id . '" data-toggle="modal" data-target="#payment-history-modal"><i class="fas fa-history"></i> History</span>' : '');*/

            })
            ->rawColumns(['created', 'name', 'email', 'action'])
            ->make(true);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $password = Str::random(8);
            $request['password'] = Hash::make($password);

            if (!$request['total_leaves']) {
                $request['total_leaves'] = env('TOTAL_LEAVES', 24);
            }

            $user = User::create($request->all());

            $user->assignRole($request->role);
            $this->storeEmployeeType($request, $user);
            DB::commit();

            $this->dispatch(new sendPasswordJob($user, $password));

            return response()->json([
                "user" => $user,
                "message" => $user->name . " successfully created."
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = User::whereId($id)->firstOrFail();

        $userRoles = $user->roles->pluck('id');
        $shifts = $user->shifts()->get();
        $ptMembers = $user->ptMembers->pluck('id')->toArray();

        return response()->json([
            "user" => $user,
            "userRoles" => $userRoles,
            "shifts" => $shifts,
            "ptMembers" => $ptMembers,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::whereId($id)->firstOrFail();
            $user->update($request->all());
            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $user->assignRole($request->input('role'));

            if ($user->shifts) {
                foreach ($user->shifts as $shift) {
                    $shift->delete();
                }
            }

            $all_members = Member::whereTrainerId($user->id)->get();
            foreach ($all_members as $member) {
                $member->trainer_id = null;
                $member->save();
            }

            $this->storeEmployeeType($request, $user);

            DB::commit();

            return response()->json([
                'message' => $user->name . " successfully updated.",
                "user" => $user
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->firstOrFail();
            $userRole = $user->roles->pluck('name')->first();
            $adminRole = auth()->user()->roles->pluck('name')->first();
            if ($adminRole != 'super-admin' && $userRole == 'super-admin') {
                return response()->json([
                    'message' => $adminRole . " role cannot delete Super Admin"
                ], 401);
            }
            $user->delete();
            DB::commit();

            return response()->json([
                'message' => $user->name . " successfully deleted."
            ], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function getrole()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return response()->json([
            'message' => $roles
        ]);

    }

    public function onSalaryData($id)
    {
        $user = User::whereId($id)->with('ptMembers')->firstOrFail();

        $registerDate = Carbon::create($user->date);
        $monthStartDate = Carbon::now()->subMonth()->startOfMonth();
        $monthEndDate = Carbon::now()->subMonth()->endOfMonth();

        if (!$user->salaries()->exists()) {
            $monthStartDate = Carbon::createFromFormat('d', $user->date->format('d'))->subMonth();
        }

        $weekends = $user->userAttendances()->whereAdminApproval(true)->whereBetween('shift_time', [$monthStartDate, $monthEndDate])->where('status', 'public_holiday')->orWhere('status', 'weekend')->get();

        $absents = $user->userAttendances->whereBetween('shift_time', [$monthStartDate, $monthEndDate])->where('admin_approval', true)->where('status', 'absent')->groupBy(function ($date) {
            return $date->shift_time->format('d');
        });

        $dates = [];
        foreach ($absents as $key => $day) {
            array_push($dates, $day->first()->shift_time);
        }

        $monthTotalDays = CarbonPeriod::create($monthStartDate, $monthEndDate)->count();

        $solidAbsents = count($dates) ? abs(2 - count($dates)) : 0;
        $salaryDays = $monthTotalDays - $weekends->count();
        $userTotalSalary = $user->salary;
        $oneDaySalary = $userTotalSalary / $salaryDays;

//        if ($solidAbsents >= 1) {
//            $userTotalSalary = $userTotalSalary - ($oneDaySalary * $solidAbsents);
//        }

        return response()->json([
            "monthStartDate" => $monthStartDate,
            "monthEndDate" => $monthEndDate,
            "user" => $user,
            "absents" => $dates,
            "monthTotalDays" => $monthTotalDays,
            "solidAbsents" => $solidAbsents,
            "salaryDays" => $salaryDays,
            "userTotalSalary" => $userTotalSalary,
            "oneDaySalary" => $oneDaySalary,
        ]);
    }

    public function paySalary(SalaryStoreRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $request['status'] = "paid";
            $user = User::whereId($id)->firstOrFail();
            $user->salaries()->create($request->all());

            DB::commit();
            return response()->json(['message' => "Salary successfully paid"], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function salaryHistory(Request $request)
    {
        $users = User::whereId($request->id)->with('salaries.user')->first();
        return response()->json(['salaries' => $users->salaries], 200);
    }

    public function verifyAuth(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string'],
            'member_id' => ['required', 'exists:members,id', 'integer'],
        ]);

        $auth = User::whereId(auth()->id())->first();

        if (!Hash::check($request->password, $auth->password)) {
            return response()->json([
                'message' => 'Password does not match'
            ], 422);
        }

        $member = Member::whereId($request->member_id)->firstOrFail();
        $memberFee = $member->feeLogs()->exists()?$member->feeLogs()->latest()->first()->fees:0;

        return response()->json([
            'fees' => $member->membership ? $member->membership->fees : $memberFee,
            'message' => 'Auth successfully verified'
        ], 200);
    }

    public function trashedUsers()
    {
        $users = User::onlyTrashed()->where('id', '!=', auth()->id())->with('salaries')->get();

        return DataTables::of($users)
            ->addColumn('created', function ($user) {
                return $user->created_at->format('d F Y');
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('action', function ($user) {
                return (auth()->user()->can('trashed_users') ? '<span class="action-restore btn btn-link btn-sm text-dark" data-id="' . $user->id . '"><i class="far fa-edit"></i> Restore</span>' : '')
                    . (auth()->user()->can('trashed_users') ? '<span class="action-user-delete btn btn-link btn-sm text-danger btn-sm" data-toggle="modal" data-target="#user-delete-modal" data-name="' . $user->name . '" data-id="' . $user->id . '"><i class="far fa-trash-alt"></i> Permanently Delete</span>' : '');
            })
            ->rawColumns(['created', 'name', 'email', 'action'])
            ->make(true);
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {

            $user = User::onlyTrashed()->whereId($id)->firstOrFail();
            $user->restore();

            DB::commit();
            return response()->json([
                'message' => 'User successfully restored.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function hardDelete($id)
    {
        DB::beginTransaction();
        try {

            $user = User::withTrashed()->whereId($id)->firstOrFail();
            $user->forceDelete();

            DB::commit();
            return response()->json([
                'message' => 'User permanently deleted.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $user
     * @return void
     */
    public function storeEmployeeType(Request $request, $user): void
    {
        if (isset($request->employ_type)) {
            $user->salary = $request->salary;
            $user->employ_type = true;

            $shifts = $request->shifts;
            if ($shifts && is_array($shifts)) {
                foreach ($shifts as $shift) {
                    $shift = Shift::create($shift);
                    $user->shifts()->attach($shift->id);
                }
            }

            if (isset($request->pt)) {
                $user->pt = true;
                $user->pt_percentage = $request->pt_percentage;

                $members = $request->members;

                if ($members && is_array($members)) {
                    foreach ($members as $member) {
                        $temp_member = Member::whereId($member)->first();
                        $temp_member->trainer_id = $user->id;
                        $temp_member->save();
                    }
                }
            } else {
                $user->pt = false;
                $user->pt_percentage = 0;
            }

        } else {
            $user->salary = 0;
            $user->employ_type = false;
            $user->pt = false;
            $user->pt_percentage = 0;
        }

        $user->save();
    }
}
