<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseList;
use App\Models\Fee;
use App\Models\Member;
use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard_income_expense', ['only' => ['dashboardIncomeExpenseView', 'incomeExpenseDay', 'incomeExpenseMonth', 'incomeExpenseYear']]);
        // $this->middleware('permission:dashboard_employee', ['only' => ['dashboardEmployee']]);
        $this->middleware('permission:dashboard_members', ['only' => ['dashboardMembersView']]);
    }

    public function dashboard1()
    {

        $customer = Member::all()->count();
        $user = User::all()->count();
        $role = Role::all()->count();

        $currentMonthfee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('fees');
        $currentMonthreg_fee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('reg_fee');
        $currentMonthClassesFees = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('classes_fees');

        $currentMonthPersonal_fee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('personal_training_fees');
        $currentMonthExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereMonth('date', Carbon::now()->month);
        })->sum('amount');

        $currentMonthincome = $currentMonthfee + $currentMonthPersonal_fee + $currentMonthreg_fee + $currentMonthClassesFees;
        $currentMonthprofit = $currentMonthincome - $currentMonthExpense;

        $currentYearfee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('fees');
        $currentYearReg_fee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('reg_fee');
        $currentYearClassesFees = Fee::whereYear('payment_date', Carbon::now()->year)->sum('classes_fees');

        $currentYearPersonal_fee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('personal_training_fees');
        $currentYearExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereYear('date', Carbon::now()->year);
        })->sum('amount');

        $currentYearincome = $currentYearfee + $currentYearPersonal_fee + $currentYearReg_fee + $currentYearClassesFees;
        $currentYearprofit = $currentYearincome - $currentYearExpense;

        $totalMonthfeeses = Fee::sum('fees');
        $totalMonthRegfee = Fee::sum('reg_fee');

        $personal_training_fees = Fee::sum('personal_training_fees');
        $totalExpense = ExpenseList::whereStatus('paid')->sum('amount');

        $totalincome = $totalMonthfeeses + $personal_training_fees + $totalMonthRegfee;
        $totalprofit = $totalincome - $totalExpense;

        $currentDayfee = Fee::whereDate('payment_date', Carbon::today())->sum('fees');
        $currentDayExtraCharges = Fee::whereDate('payment_date', Carbon::today())->sum('extra_charges');
        $currentDayreg_fee = Fee::whereDate('payment_date', Carbon::today())->sum('reg_fee');
        $currentDayPersonal_fee = Fee::whereDate('payment_date', Carbon::today())->sum('personal_training_fees');

        $currentDayExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereDate('date', Carbon::today());
        })->sum('amount');

        $currentDayincome = $currentDayfee + $currentDayPersonal_fee + $currentDayreg_fee + $currentDayExtraCharges;
        $currentDayprofit = $currentDayfee + $currentDayPersonal_fee - $currentDayExpense;

        $yesterdayfee = Fee::whereDate('payment_date', Carbon::yesterday())->sum('fees');
        $yesterdayRegFees = Fee::whereDate('payment_date', Carbon::yesterday())->sum('reg_fee');
        $yesterdayPersonal_fee = Fee::whereDate('payment_date', Carbon::yesterday())->sum('personal_training_fees');
        $yesterdayIncome = $yesterdayfee + $yesterdayPersonal_fee + $yesterdayRegFees;

        $yesterdayExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereDate('date', Carbon::yesterday());
        })->sum('amount');
        $yesterdayProfit = $yesterdayIncome - $yesterdayExpense;

        // $members = Member::whereNotNull('membership_id')->get();
        $membershipName = Membership::all();
        $CurrentMonthMembership = Fee::whereNotNull('membership_id')
            ->whereMonth('payment_date', Carbon::now()->month)->get();
        $newcustomer = Member::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();

        $maleGenderCount = Member::whereGender('male')->count();
        $femaleGenderCount = Member::whereGender('female')->count();
        $transgenderCount = Member::whereGender('trans')->count();
        $otherGenderCount = Member::whereGender('other')->count();

        $genderDonat = [$maleGenderCount, $femaleGenderCount, $transgenderCount, $otherGenderCount];

        $memberWithMembershipsCount = Member::whereNotNull('membership_id')->count();
        $memberWithoutMembershipsCount = Member::whereNull('membership_id')->count();

        $customersDonatChart = [$memberWithMembershipsCount, $memberWithoutMembershipsCount];

//        $memberships = Membership::get();

        $latestFees = Fee::latest()->limit(20)->get();

        $currentDayMembersCount = Member::whereDate('created_at', Carbon::today())->count();
        $yesterdayMembersCount = Member::whereDate('created_at', Carbon::yesterday())->count();
        $currentMonthMembersCount = Member::whereMonth('created_at', Carbon::now()->month)->count();
        $currentYearMembersCount = Member::whereYear('created_at', Carbon::now()->year)->count();
        $totalMembersCount = Member::count();

        $currentDayRegFees = Fee::whereDate('payment_date', Carbon::today())->sum('reg_fee');
        $yesterdayRegFees = Fee::whereDate('payment_date', Carbon::yesterday())->sum('reg_fee');
        $currentMonthRegFees = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('reg_fee');
        $currentYearRegFees = Fee::whereYear('payment_date', Carbon::now()->year)->sum('reg_fee');
        $totalRegFees = Fee::sum('reg_fee');

        $membersStats = [
            'currentDay' => [
                'members' => $currentDayMembersCount,
                'reg_fees' => $currentDayRegFees,
            ],
            'yesterday' => [
                'members' => $yesterdayMembersCount,
                'reg_fees' => $yesterdayRegFees,
            ],
            'currentMonth' => [
                'members' => $currentMonthMembersCount,
                'reg_fees' => $currentMonthRegFees,
            ],
            'currentYear' => [
                'members' => $currentYearMembersCount,
                'reg_fees' => $currentYearRegFees,
            ],
            'currentTotal' => [
                'members' => $totalMembersCount,
                'reg_fees' => $totalRegFees,
            ],
        ];

        $date = Carbon::today();
        $todayAttendances = Attendance::whereDate('date', $date)->get();

        return view('backend.dashboard.index',
            [
                'customer' => $customer,
                'user' => $user,
                'role' => $role,
                'newcustomer' => $newcustomer,
                'currentmonthincome' => $currentMonthincome,
                'currentDayincome' => $currentDayincome,
                'totalincome' => $totalincome,
                'totalmemberships' => $CurrentMonthMembership,
                'currentYearincome' => $currentYearincome,
                'membershipName' => $membershipName,
                'currentDayExpense' => $currentDayExpense,
                'currentMonthExpense' => $currentMonthExpense,
                'currentYearExpense' => $currentYearExpense,
                'totalExpense' => $totalExpense,
                'currentDayprofit' => $currentDayprofit,
                'currentMonthprofit' => $currentMonthprofit,
                'currentYearprofit' => $currentYearprofit,
                'totalprofit' => $totalprofit,
                'yesterdayIncome' => $yesterdayIncome,
                'yesterdayExpense' => $yesterdayExpense,
                'yesterdayProfit' => $yesterdayProfit,
                'genderDonat' => json_encode($genderDonat),
                'latestFees' => $latestFees,
                'customersDonatChart' => json_encode($customersDonatChart),
//                'membershipMembers' => json_encode($membershipMembers),
                'membersStats' => $membersStats,
                'todayAttendances' => $todayAttendances,
            ]
        );
    }

    public function incomeExpenseDay($date)
    {
        $date = new Carbon($date);

        $income = Fee::whereDate('payment_date', $date)->with('collectedBy', 'member')->get();
        $classIncome = $totalIncome = $income->sum(function ($q) {
            return $q->classes_fees;
        });
//        $totalIncome = $income->sum(function ($q) {
//            return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges+$q->classes_fees;
//        });
        $totalIncome = $income->sum(function ($q) {
            return $q->total_payment;
        });

        $expenses = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($date) {
            $query->whereDate('date', $date)->latest();
        })->get();

        $totalExpense = $expenses->sum('amount');

        if (request()->ajax()) {
            return response()->json([
                'date' => $date,
                'income' => $income,
                'expenses' => $expenses,
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
            ]);
        }

        return view('backend.dashboard.day-income-expense-report', [
            'date' => $date,
            'classIncome' => $classIncome,
            'income' => $income,
            'expenses' => $expenses,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ]);
    }

    public function incomeExpenseWeek()
    {
        $week_s = Carbon::now()->startOfWeek();
        $week_e = Carbon::now()->endOfWeek();

        $days = CarbonPeriod::create($week_s, $week_e);

        $allDays = [];
        foreach ($days as $day) {

            $income = Fee::whereDate('payment_date', $day)->get();
            $totalIncome = $income->sum(function ($q) {
                return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges + $q->classes_fees;
            });

            $expenses = (int)ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($day) {
                $query->whereDate('date', $day)->latest();
            })->sum('amount');

            $temp = [
                'date' => $day,
                'income' => $totalIncome,
                'expense' => $expenses,
                'profit' => $totalIncome - $expenses
            ];

            array_push($allDays, $temp);
        }

        $allIncome = Fee::whereBetween('payment_date', [$week_s, $week_e])->with('collectedBy', 'member')->get();
        $allIncomeTotal = $allIncome->sum(function ($q) {
            return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges + $q->classes_fees;
        });
        $allClassIncome = $allIncome->sum(function ($q) {
            return $q->classes_fees;
        });

        $allExpenses = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($week_s, $week_e) {
            $query->whereBetween('date', [$week_s, $week_e])->latest();
        })->get();
        $allExpenseTotal = $allExpenses->sum('amount');

        if (request()->ajax()) {
            return response()->json([
                'week_start' => $week_s,
                'week_end' => $week_e,
                'allDays' => $allDays
            ]);
        }

        return view('backend.dashboard.week-income-expense-report', [
            'week_start' => $week_s,
            'week_end' => $week_e,
            'allDays' => $allDays,
            'allClassIncome' => $allClassIncome,
            'allIncome' => $allIncome,
            'allIncomeTotal' => $allIncomeTotal,
            'allExpenses' => $allExpenses,
            'allExpenseTotal' => $allExpenseTotal,
        ]);
    }

    public function incomeExpenseMonth($month)
    {
        $date1 = Carbon::createFromFormat('m-Y', $month);
        $date2 = Carbon::createFromFormat('m-Y', $month);

        $endDate = $date1->month == Carbon::today()->month ? Carbon::today() : $date1->endOfMonth();
        $startDate = $date2->startOfMonth();

        $days = CarbonPeriod::create($startDate, $endDate);

        $allDays = [];
        foreach ($days as $day) {

            $income = Fee::whereDate('payment_date', $day)->get();
            $totalIncome = $income->sum(function ($q) {
                return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges + $q->classes_fees;
            });

            $expenses = (int)ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($day) {
                $query->whereDate('date', $day)->latest();
            })->sum('amount');

            $temp = [
                'date' => $day,
                'income' => $totalIncome,
                'expense' => $expenses,
                'profit' => $totalIncome - $expenses
            ];

            array_push($allDays, $temp);
        }

        $allIncome = Fee::whereMonth('payment_date', $date1->month)->with('collectedBy', 'member')->get();
        $allIncomeTotal = $allIncome->sum(function ($q) {
            return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges + $q->classes_fees;
        });

        $allExpenses = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($date1) {
            $query->whereMonth('date', $date1->month)->latest();
        })->get();
        $allExpenseTotal = $allExpenses->sum('amount');

        if (request()->ajax()) {
            return response()->json([
                'month' => $date1,
                'allDays' => array_reverse($allDays)
            ]);
        }

        return view('backend.dashboard.month-income-expense-report', [
            'month' => $date1,
            'allDays' => array_reverse($allDays),
            'allIncome' => $allIncome,
            'allIncomeTotal' => $allIncomeTotal,
            'allExpenses' => $allExpenses,
            'allExpenseTotal' => $allExpenseTotal,
        ]);
    }

    public function incomeExpenseYear($year)
    {
        $currentDate = Carbon::createFromFormat('Y', $year);
        $yearStart = Carbon::createFromFormat('d m Y', '01 01 ' . $year);

        $months = CarbonPeriod::create($yearStart, '1 month', $currentDate);

        $allMonths = [];
        foreach ($months as $month) {
            $income = Fee::whereMonth('payment_date', $month)->get();
            $totalIncome = $income->sum(function ($q) {
                return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges + $q->classes_fees;
            });

            $expenses = (int)ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($month) {
                $query->whereMonth('date', $month)->latest();
            })->sum('amount');

            $temp = [
                'month' => $month,
                'income' => $totalIncome,
                'expense' => $expenses,
                'profit' => $totalIncome - $expenses
            ];

            array_push($allMonths, $temp);
        }

        $allIncome = Fee::whereYear('payment_date', $currentDate->year)->get();
        $allIncomeTotal = $allIncome->sum(function ($q) {
            return $q->fees + $q->reg_fee + $q->personal_training_fees + $q->extra_charges + $q->classes_fees;
        });

        $allExpenses = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($currentDate) {
            $query->whereYear('date', $currentDate->year)->latest();
        })->get();
        $allExpenseTotal = $allExpenses->sum('amount');

        return view('backend.dashboard.year-income-expense-report', [
            'year' => $currentDate,
            'allMonths' => array_reverse($allMonths),
            'allIncome' => $allIncome,
            'allIncomeTotal' => $allIncomeTotal,
            'allExpenses' => $allExpenses,
            'allExpenseTotal' => $allExpenseTotal,
        ]);
    }

    public function dashboardIncomeExpenseView()
    {
        $currentMonthfee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('fees');
        $currentMonthRegfee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('reg_fee');
        $currentMonthExtraCharges = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('extra_charges');
        $currentMonthClassesfee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('classes_fees');
        $currentMonthPersonal_fee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('personal_training_fees');
        $currentMonthIn_House_fee = Fee::whereMonth('payment_date', Carbon::now()->month)->sum('in_house_training_fees');
        $currentMonthExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereMonth('date', Carbon::now()->month);
        })->sum('amount');

        $currentMonthincome = $currentMonthfee + $currentMonthPersonal_fee + $currentMonthIn_House_fee + $currentMonthRegfee + $currentMonthExtraCharges + $currentMonthClassesfee;
        $currentMonthprofit = $currentMonthincome - $currentMonthExpense;

        $currentYearfee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('fees');
        $currentYearRegfee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('reg_fee');
        $currentYearExtraCharges = Fee::whereYear('payment_date', Carbon::now()->year)->sum('extra_charges');
        $currentYearClassesFees = Fee::whereYear('payment_date', Carbon::now()->year)->sum('classes_fees');

        $currentYearPersonal_fee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('personal_training_fees');
        $currentYearIn_House_fee = Fee::whereYear('payment_date', Carbon::now()->year)->sum('in_house_training_fees');
        $currentYearExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereYear('date', Carbon::now()->year);
        })->sum('amount');

        $currentYearincome = $currentYearfee + $currentYearPersonal_fee + $currentYearIn_House_fee + $currentYearRegfee + $currentYearExtraCharges + $currentYearClassesFees;
        $currentYearprofit = $currentYearincome - $currentYearExpense;

        $totalMonthfeeses = Fee::sum('fees');
        $totalMonthRegfeeses = Fee::sum('reg_fee');
        $totalMonthExtraCharges = Fee::sum('extra_charges');
        $totalMonthClassesFees = Fee::sum('classes_fees');
        $personal_training_fees = Fee::sum('personal_training_fees');
        $in_house_training_fees = Fee::sum('in_house_training_fees');
        $totalExpense = ExpenseList::whereStatus('paid')->sum('amount');

        $totalincome = $totalMonthfeeses + $personal_training_fees + $in_house_training_fees + $totalMonthRegfeeses + $totalMonthExtraCharges + $totalMonthClassesFees;
        $totalprofit = $totalincome - $totalExpense;

//        $currentDayfee = Fee::whereDate('payment_date', Carbon::today())->sum('fees');
        $currentDayfee = Fee::whereDate('payment_date', Carbon::today())->sum('total_payment');
        $currentDayDiscount = Fee::whereDate('payment_date', Carbon::today())->sum('discount');

        $currentDaytotal_payment = Fee::whereDate('payment_date', Carbon::today())->sum('total_payment');
        $currentDayreg_fee = Fee::whereDate('payment_date', Carbon::today())->sum('reg_fee');
        $currentDayExtraCharges = Fee::whereDate('payment_date', Carbon::today())->sum('extra_charges');
        $currentDayClassesFees = Fee::whereDate('payment_date', Carbon::today())->sum('classes_fees');
        $currentDayPersonal_fee = Fee::whereDate('payment_date', Carbon::today())->sum('personal_training_fees');
        $currentDayIn_House_fee = Fee::whereDate('payment_date', Carbon::today())->sum('in_house_training_fees');
        $currentDayExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereDate('date', Carbon::today());
        })->sum('amount');

        $currentDayincome = $currentDaytotal_payment;
        $currentDayprofit = $currentDayincome - $currentDayExpense;

        $yesterdayfee = Fee::whereDate('payment_date', Carbon::yesterday())->sum('fees');
        $yesterdayExtraCharges = Fee::whereDate('payment_date', Carbon::yesterday())->sum('extra_charges');
        $yesterdayClassesFees = Fee::whereDate('payment_date', Carbon::yesterday())->sum('classes_fees');
        $yesterdayRegfee = Fee::whereDate('payment_date', Carbon::yesterday())->sum('reg_fee');
        $yesterdayPersonal_fee = Fee::whereDate('payment_date', Carbon::yesterday())->sum('personal_training_fees');
        $yesterdayIn_House_fee = Fee::whereDate('payment_date', Carbon::yesterday())->sum('in_house_training_fees');
        $yesterdayIncome = $yesterdayfee + $yesterdayPersonal_fee + $yesterdayIn_House_fee + $yesterdayRegfee + $yesterdayExtraCharges + $yesterdayClassesFees;

        $yesterdayExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereDate('date', Carbon::yesterday());
        })->sum('amount');

        $yesterdayProfit = $yesterdayIncome - $yesterdayExpense;

        $currentWeekFees = Fee::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('fees');
        $currentWeekClassesFees = Fee::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('classes_fees');
        $currentWeekExtraCharges = Fee::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('extra_charges');
        $currentWeekRegFees = Fee::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('reg_fee');
        $currentWeekPersonalFees = Fee::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('personal_training_fees');
        $currentWeekIn_House_fees = Fee::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('in_house_training_fees');
        $currentWeekExpense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) {
            $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()]);
        })->sum('amount');

        $currentWeekIncome = $currentWeekFees + $currentWeekPersonalFees + $currentWeekIn_House_fees + $currentWeekRegFees + $currentWeekExtraCharges + $currentWeekClassesFees;
        $currentWeekProfit = $currentWeekIncome - $currentWeekExpense;

        $latestFees = Fee::latest()->limit(20)->get();

        $last12MonthsFromNow = now()->subMonths(12)->monthsUntil(now());
        $last12Months = [];
        $last12MonthsIncome = [];
        $last12MonthsExpense = [];
        $last12MonthsProfit = [];

        foreach ($last12MonthsFromNow as $date) {
            $fees = Fee::whereYear('payment_date', $date->year)->whereMonth('payment_date', $date->month)->sum('fees');
            $regfees = Fee::whereYear('payment_date', $date->year)->whereMonth('payment_date', $date->month)->sum('reg_fee');
            $extraCharges = Fee::whereYear('payment_date', $date->year)->whereMonth('payment_date', $date->month)->sum('extra_charges');
            $ClassesFees = Fee::whereYear('payment_date', $date->year)->whereMonth('payment_date', $date->month)->sum('classes_fees');
            $personalFees = Fee::whereYear('payment_date', $date->year)->whereMonth('payment_date', $date->month)->sum('personal_training_fees');
            $inhouse_fee = Fee::whereYear('payment_date', $date->year)->whereMonth('payment_date', $date->month)->sum('in_house_training_fees');
            $expense = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($date) {
                $query->whereYear('date', $date->year)->whereMonth('date', $date->month);
            })->sum('amount');

            $tempIncome = $fees + $personalFees + $inhouse_fee + $regfees + $extraCharges + $ClassesFees;
            $tempProfit = $tempIncome - $expense;

            array_push($last12Months, $date->format('M, Y'));
            array_push($last12MonthsIncome, $tempIncome);
            array_push($last12MonthsExpense, $expense);
            array_push($last12MonthsProfit, $tempProfit);
        }

        $last12MonthsChart = [
            'last12Months' => $last12Months,
            'last12MonthsIncome' => $last12MonthsIncome,
            'last12MonthsExpense' => $last12MonthsExpense,
            'last12MonthsProfit' => $last12MonthsProfit,
        ];

        return view('backend.dashboard.income-expense-dashboard', [
                'currentmonthincome' => $currentMonthincome,
                'currentDayincome' => $currentDayincome,
                'totalincome' => $totalincome,
                'currentYearincome' => $currentYearincome,
                'currentDayExpense' => $currentDayExpense,
                'currentMonthExpense' => $currentMonthExpense,
                'currentYearExpense' => $currentYearExpense,
                'totalExpense' => $totalExpense,
                'currentDayprofit' => $currentDayprofit,
                'currentMonthprofit' => $currentMonthprofit,
                'currentYearprofit' => $currentYearprofit,
                'totalprofit' => $totalprofit,
                'yesterdayIncome' => $yesterdayIncome,
                'yesterdayExpense' => $yesterdayExpense,
                'yesterdayProfit' => $yesterdayProfit,
                'latestFees' => $latestFees,
                'currentWeekIncome' => $currentWeekIncome,
                'currentWeekExpense' => $currentWeekExpense,
                'currentWeekProfit' => $currentWeekProfit,
                'last12MonthsChart' => json_encode($last12MonthsChart),
            ]
        );
    }

    public function dashboardMembersView()
    {
        $customer = Member::all()->count();

        $membershipName = Membership::all();
        $CurrentMonthMembership = Fee::whereNotNull('membership_id')->whereMonth('payment_date', Carbon::now()->month)->get();
        $newcustomer = Member::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();

        $maleGenderCount = Member::whereGender('male')->count();
        $femaleGenderCount = Member::whereGender('female')->count();
        $transgenderCount = Member::whereGender('trans')->count();
        $otherGenderCount = Member::whereGender('other')->count();

        $genderDonat = [$maleGenderCount, $femaleGenderCount, $transgenderCount, $otherGenderCount];

        $memberWithMembershipsCount = Member::whereNotNull('membership_id')->count();
        $memberWithoutMembershipsCount = Member::whereNull('membership_id')->count();

        $customersDonatChart = [$memberWithMembershipsCount, $memberWithoutMembershipsCount];
        $currentDayMembersCount = Member::whereDate('created_at', Carbon::today())->count();
        $yesterdayMembersCount = Member::whereDate('created_at', Carbon::yesterday())->count();
        $currentWeekMembersCount = Member::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
        $currentMonthMembersCount = Member::whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonthMembersCount = Member::whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->startOfMonth()])->count();
        $lastMonthMembersCount = Member::where('created_at', '<=', Carbon::now()->startOfMonth())->where('created_at', '>', Carbon::now()->subMonth(1)->startOfMonth())->count();
        $last6MonthsMembersCount = Member::whereBetween('created_at', [Carbon::now()->subMonth(6), Carbon::now()])->count();
        $last6MonthsMembersCount = Member::where('created_at', '<=', Carbon::now())->where('created_at', '>', Carbon::now()->subMonth(6))->count();
        $currentYearMembersCount = Member::whereYear('created_at', Carbon::now()->year)->count();
        $totalMembersCount = Member::count();

        $last6MonthsFromNow = now()->subMonths(5)->monthsUntil(now());

        $last6MonthsMembersChartCount = [];
        $last6MonthsMembersChart = [];

        foreach ($last6MonthsFromNow as $month) {
            $tempMembersCount = Member::whereMonth('created_at', $month->month)->count();
            array_push($last6MonthsMembersChartCount, $month->format('M, Y'));
            array_push($last6MonthsMembersChart, $tempMembersCount);
        }

        $last6MonthsChart = [
            'last6Months' => $last6MonthsMembersChartCount,
            'last6MonthsCount' => $last6MonthsMembersChart,
        ];

        $membersStats = [
            'currentDay' => [
                'members' => $currentDayMembersCount,
            ],
            'yesterday' => [
                'members' => $yesterdayMembersCount,
            ],
            'currentWeek' => [
                'members' => $currentWeekMembersCount,
            ],
            'currentMonth' => [
                'members' => $currentMonthMembersCount,
            ],
            'lastMonth' => [
                'members' => $lastMonthMembersCount,
            ],
            'last6Months' => [
                'members' => $last6MonthsMembersCount,
            ],
            'currentYear' => [
                'members' => $currentYearMembersCount,
            ],
            'currentTotal' => [
                'members' => $totalMembersCount,
            ],
        ];

        $date = Carbon::today();
        $todayAttendances = Attendance::whereDate('date', $date)->get();

        return view('backend.dashboard.members-dashboard', [
                'customer' => $customer,
                'newcustomer' => $newcustomer,
                'totalmemberships' => $CurrentMonthMembership,
                'membershipName' => $membershipName,
                'genderDonat' => json_encode($genderDonat),
                'customersDonatChart' => json_encode($customersDonatChart),
                'membersStats' => $membersStats,
                'todayAttendances' => $todayAttendances,
                'last6MonthsChart' => json_encode($last6MonthsChart),
            ]
        );
    }

    public function dashboard()
    {
        $users = User::where('employ_type', true)->with('ptMembers')->get();

        $salariesData = [];
        foreach ($users as $user) {
            $monthStartDate = Carbon::now()->subMonth()->startOfMonth();
            $monthEndDate = Carbon::now()->subMonth()->endOfMonth();


            if (!$user->salaries()->exists()) {
                //$monthStartDate = Carbon::createFromFormat('d', $user->date->format('d'))->subMonth();
            }
            if (!$user->salaries()->whereMonth('payment_date', $monthStartDate->month)->first()) {

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

                if ($solidAbsents >= 1) {
                    $userTotalSalary = $userTotalSalary - ($oneDaySalary * $solidAbsents);
                }

                $total = 0;
                if ($user->pt) {
                    foreach ($user->ptMembers as $pt) {
                        $amount = (((int)$user->pt_percentage / 100) * (int)$pt->personal_training_fees);
                        $total += (int)$amount;
                    }
                }

                $temp = [
                    'user' => $user,
                    'monthStartDate' => $monthStartDate,
                    'solidAbsents' => $solidAbsents,
                    'salaryDays' => $salaryDays,
                    'oneDaySalary' => $oneDaySalary,
                    'userTotalSalary' => $userTotalSalary + $total,
                ];
                array_push($salariesData, $temp);
            }
        }

        $user = auth()->user();
        $salaries = $user->salaries()->orderBy('id', 'desc')->get();
        $shifts = $user->shifts;

        $date = Carbon::today();
        $todayAttendances = Attendance::whereDate('date', $date)->get();
        return view('backend.dashboard.employee-dashboard', [
            'user' => $user,
            'salaries' => $salaries,
            'shifts' => $shifts,
            'salariesData' => $salariesData,
            'todayAttendances' => $todayAttendances
        ]);
    }

    public function markAttendance(Request $request)
    {
        try {
            $user = auth()->user();
            $shiftFrom = Carbon::createFromFormat('g A', $request->shiftFrom);

            $attendance = $user->userAttendances()->where('shift_time', $shiftFrom)->firstOrFail();

            $attendance->ip = $request->ip();
            $attendance->device = $request->userAgent();

            $text = '';
            if ($request->type === 'clock-in') {
                $attendance->clock_in = now();
                $attendance->clock_out = null;
                $text = 'Clocked In';
            } else {
                $attendance->clock_out = now();
                $text = 'Clocked Out';
            }
            $attendance->status = 'present';
            $attendance->save();

            return response()->json([
                'message' => $text . ' at ' . now()->format('g:i A d M, Y')
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function report(Request $request)
    {
//        $present = 0;
//        $absent = 0;
//        $example = DB::table('attendances as attend')
//                            ->join('members as member' ,'member.id' ,'=' , 'attend.member_id')
//                            ->select('member.name','attend.status','attend.clock_in','attend.clock_out','attend.date')
//                            ->whereDate('attend.date','>=', '2022-06-01')
//                            ->whereDate('attend.date','<=', '2022-06-16')
//                            ->where('member.name','like', '%' . 'Talha Rwp' . '%')
//                            ->where('member.guest_member','=', '1')
//                            ->get();
//
//        foreach ($example as $exm){
//            $exm->status == "present" ? $present++ : $absent++;
//        }
//        dd($example,$present,$absent);

        if ($request->ajax()) {
            if ($request->filter_name != null) {
                $builder = Attendance::query();
                if (!empty($request->filter_name)) {
                    $builder->whereHas('member', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->filter_name . '%');
                    });
                }
                if (!empty($request->filter_membership)) {
                    $builder->whereHas('member', function ($q) use ($request) {
                        if ($request->filter_membership == 'guest') {
                            $q->where('guest_member', '=', 1);
                        } else {
                            $q->where('guest_member', '=', 0);
                        }
                    });
                }

                if (!empty($request->filter_date)) {
                    $date = explode('-', $request->filter_date);
                    $from = Carbon::parse($date[0])->format('Y-m-d');
                    $to = new Carbon(Carbon::parse($date[1])->format('Y-m-d'));
                    $to = $to->addDay(1)->toDateString();
                    $builder->whereBetween('date', [$from, $to]);
                }

                $result = $builder->get();
                $data_arr = $this->reportData($result);
            } else if ($request->filter_name == null) {
                if ($request->filter_date) {
                    $date = explode('-', $request->filter_date);
                    $from = Carbon::parse($date[0])->format('Y-m-d');
                    $to = new Carbon(Carbon::parse($date[1])->format('Y-m-d'));
                    $to = $to->addDay(1)->toDateString();
                    $attendances = Attendance::whereBetween('date', [$from, $to])->get();
                    $data_arr = $this->reportData($attendances);
                } else {
                    $date = Carbon::today();
                    $attendances = Attendance::whereDate('date', $date)->get();
                    $data_arr = $this->reportData($attendances);
                }
            } else {
                $date = Carbon::today();
                $attendances = Attendance::whereDate('date', $date)->get();
                $data_arr = $this->reportData($attendances);
            }
            return \datatables()->of($data_arr)->make(true);
        }
        return view('backend.dashboard.report');
    }

    public function reportData($attendances)
    {
//        dd($attendances);
        $data_arr = array();
        foreach ($attendances as $record) {
            $only_date = $record->date;
            $date = $only_date->toDateString();
            $name = $record->member->name;
            $clock_in = $record->clock_in;
            $clock_out = $record->clock_out;

            $data_arr[] = array(
                "date" => $date,
                "name" => $name,
                "clock_in" => $clock_in ? $clock_in : '-',
                "clock_out" => $clock_out ? $clock_out : '-'
            );
        }
        return $data_arr;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function attendancePercentage(Request $request)
    {
        if ($request->filter_name == 'nothing') {
            $mark_attendance = array();
            $members = Member::all();

            foreach ($members as $key => $member) {
//                $present = Attendance::where('member_id', $member->id)
//                    ->select(DB::raw('SUM(status = "present ") as present'))->get();
//
//                $absent = Attendance::where('member_id', $member->id)
//                    ->select(DB::raw('SUM(status = "absent") as absent'))->get();

                $present = Attendance::where('member_id', $member->id)
                    ->select(DB::raw('count(clock_in) as present'))
                    ->whereNotNull('clock_in')
                    ->get();

                $absent = Attendance::where('member_id', $member->id)
                    ->select(DB::raw('count(clock_in) as absent'))
                    ->whereNull('clock_in')
                    ->get();

                $mark_attendance[] = array(
                    "name" => $member->name,
                    "present" => $present[0]['present'],
                    "absent" => $absent[0]['absent'],
                );
            }

        } else {

            $mark_attendance = array();
            $date = explode('-', $request->filter_date);
            $from = Carbon::parse($date[0])->format('Y-m-d');
            $to = new Carbon(Carbon::parse($date[1])->format('Y-m-d'));
            $to = $to->addDay(1)->toDateString();
            $guest = $request->filter_membership == 'guest' ? 1 : 0;

            if ($guest == 1) {
                $members = Member::where('name', 'like', '%' . $request->filter_name . '%')
                    ->where('guest_member', 1)->get();
            } else if ($guest == 0) {
                $members = Member::where('name', 'like', '%' . $request->filter_name . '%')
                    ->where('guest_member', 0)->get();
            } else {
                $members = Member::where('name', 'like', '%' . $request->filter_name . '%')->get();
            }

            foreach ($members as $key => $member) {
                $present = Attendance::where('member_id', $member->id)
                    ->select(DB::raw('count(clock_in) as present'))
                    ->whereNotNull('clock_in')
                    ->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->get();

                $absent = Attendance::where('member_id', $member->id)
                    ->whereNull('clock_in')
                    ->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->get();

                $mark_attendance[] = array(
                    "name" => $member->name,
                    "present" => $present[0]['present'],
                    "absent" => count($absent),
                );
                // dd($mark_attendance);
            }
            $attendance_records = DB::table('attendances as attend')
                ->join('members as mem', 'mem.id', '=', 'attend.member_id')
                ->select(DB::raw('DATE_FORMAT(attend.date, "%Y-%m-%d") as date'), 'attend.clock_in as presents')
                ->where('mem.name', 'like', '%' . $request->filter_name . '%')
//                ->where('attend.clock_in', '!=', null)
                ->where('mem.membership_id', '!=', null)
                ->whereDate('attend.date', '>=', $from)->whereDate('attend.date', '<=', $to)
                ->groupBy('attend.created_at')
                ->get();


            $total_attend_data = [];
            $index = 0;
            $count = 0;
            foreach ($attendance_records as $key => $records) {

                if (count($total_attend_data) == 0) {
                    $total_attend_data[$index] = $records;
                } else {
                    if ($total_attend_data[$index]) {
                        if ($total_attend_data[$index]->date == $records->date) {
                            $count = $count + 1;
                            $total_attend_data[$index]->presents = $count;
                        } else {
                            $index = $index + 1;
                            $count = 1;
                            $total_attend_data[$index] = $records;
                        }
                    } else {
                        // dd("false");
                        // dd("values-are",$total_attend_data);
                    }
                }
            }
//            dd($total_attend_data);
            $mark_attendance['record'] = $total_attend_data;
            // dd("recordsssssss",$total_attend_data);

        }


//        $attendance = Attendance::where('member_id', $members->id)
//            ->select(DB::raw('SUM(status = "absent") as absent,SUM(status = "present ") as present'))
//            ->whereBetween('date', [$from, $to])->get();
        return response()->json($mark_attendance);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function paymentsReport(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filter_name && $request->filter_date) {
                $date = explode('-', $request->filter_date);
                $from = Carbon::parse($date[0])->format('Y-m-d');
                $to = Carbon::parse($date[1])->format('Y-m-d');

                /* $query = Fee::whereDate('created_at', '>=', $from)
                                ->whereDate('created_at', '<=', $to)
                                ->where('personal_training_fees','!=','')
                                ->select('id','collected_by','member_id','created_at','personal_training_fees',
                                 DB::raw('sum(personal_training_fees) as pt_fees'))
                                ->orderBy('created_at','asc')
                                ->groupBy('expire_date')
                                ->get();

                                dd($query); */


                $query = Fee::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);

                if ($request->filter_name == "personal_training_fees") {
                    $query->where('personal_training_fees', '!=', '')
                        ->select('id', 'collected_by', 'member_id', 'created_at', 'personal_training_fees',
                            DB::raw('sum(personal_training_fees) as pt_fees'))
                        ->groupBy('member_id');
                }

                if ($request->filter_name == "in_house_training_fees") {
                    $query->where('in_house_training_fees', '!=', '')
                        ->select('id', 'collected_by', 'member_id', 'created_at', 'in_house_training_fees',
                            DB::raw('sum(in_house_training_fees) as intf_fees'))
                        ->groupBy('member_id');
                }

                if ($request->filter_name == "classes_fees") {
                    $query->where('classes_fees', '!=', '')
                        ->select('id', 'collected_by', 'member_id', 'created_at', 'classes_fees',
                            DB::raw('sum(classes_fees) as cl_fees'))
                        ->groupBy('member_id');
                }

                if ($request->filter_name == "membership_fees") {

                    // $query = DB::table('fees as fee')
                    //         ->join('memberships as m', 'm.id', '=', 'fee.membership_id')
                    //         ->select('fee.id','fee.collected_by','fee.member_id','fee.membership_id','fee.created_at','fee.discount','m.fees as membership_fee',
                    //             DB::raw('sum(m.fees) as total_membership_fee'),
                    //             DB::raw('sum(fee.discount) as total_discount'))
                    //         ->whereDate('fee.created_at', '>=', $from)->whereDate('fee.created_at', '<=', $to)
                    //         ->groupBy('fee.expire_date')
                    //         ->get();

                    $data_arr = array();
                    //    $query = Fee::query()
                    //        ->whereHas('membership' , function ($query) {
                    //            $query->select('id','fees');
                    //        })->select('id','collected_by','member_id','membership_id','created_at','discount')
                    //             ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();

                    $query = DB::table('fees as fee')
                        ->join('memberships as m', 'm.id', '=', 'fee.membership_id')
                        ->join('members as mem', 'mem.id', '=', 'fee.member_id')
                        ->join('users as user', 'user.id', '=', 'fee.collected_by')
                        ->select('fee.id', 'fee.collected_by', 'fee.member_id', 'fee.membership_id',
                            'fee.created_at', 'fee.discount', 'm.fees as membership_fee', 'mem.name as name', 'user.name as collec_name',
                            DB::raw('sum(m.fees) as total_membership_fee'),
                            DB::raw('sum(fee.discount) as total_discount'))
                        ->whereDate('fee.created_at', '>=', $from)->whereDate('fee.created_at', '<=', $to)
                        ->groupBy('fee.payment_date')
                        ->get();
                    // dd($query);

                    foreach ($query as $record) {
                        // dd($record);
                        $only_date = $record->created_at;
                        $date = \Carbon\Carbon::parse($only_date)->format('Y-m-d');
                        //    $date = $only_date->toDateString();
                        //    $name = $record->member->name;
                        $name = $record->name;
                        //    $collected_by = $record->collectedBy ? $record->collectedBy->name : 'Not-Exist';
                        $collected_by = $record->collec_name ? $record->collec_name : 'Not-Exist';
                        $payment = $record->total_membership_fee - $record->total_discount;
                        //    $payment = $record->membership->fees - $record->discount;

                        $data_arr[] = array(
                            "date" => $date,
                            "name" => $name,
                            "collected_by" => $collected_by,
                            "payment" => $payment,
                            "discount" => $record->discount,
                        );
                    }
                    return response()->json($records = $data_arr);
                }

                if ($request->filter_name == "guest") {
                    $query->where('membership_id', '=', null)
                        ->select('id', 'collected_by', 'member_id', 'created_at',
                            DB::raw('sum(total_payment) as total_payment'))
                        ->groupBy('member_id');
                }

                if ($request->filter_name == "all") {

                    $query->where(function ($q) {
                        $q->where('personal_training_fees', '!=', '')
                            ->orWhere('classes_fees', '!=', '')
                            ->orWhere('fees', '!=', '')
                            ->orWhere('in_house_training_fees', '!=', '');
                    })->select('id', 'collected_by', 'member_id', 'created_at',
                        DB::raw('sum(total_payment) as total_payment'))
                        ->orderBy('created_at', 'asc')
                        ->groupBy('member_id');
                }

                $result = $query->get();
                $records = $this->paymentsReportData($result);
                return response()->json($records);
            }
        } else {
            $result = Fee::select('id', 'collected_by', 'member_id', 'total_payment', 'created_at')
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->where('fees', '!=', '')
                ->where('classes_fees', '!=', '')
                ->where('personal_training_fees', '!=', '')
                ->where('in_house_training_fees', '!=', '')
                ->get();
            $records = $this->paymentsReportData($result);
            return view('backend.dashboard.payments-report', compact('records'));
        }
    }
    /**
     * @param $payments
     * @return array
     */
    public function paymentsReportData($payments)
    {
//            dd($payments);
        $data_arr = array();
        foreach ($payments as $record) {
            // dd($record);
            $only_date = $record->created_at;
            $date = $only_date->toDateString();
            $name = $record->member->name;
            $collected_by = $record->collectedBy ? $record->collectedBy->name : 'Not-Exist';
            if ($record->total_payment) {
                $payment = $record->total_payment;
            }
            if ($record->personal_training_fees) {
                $payment = $record->pt_fees;
            }
            if ($record->in_house_training_fees) {
                $payment = (int)$record->intf_fees;
            }
            if ($record->classes_fees) {
                $payment = $record->classes_fees;
            }
            $data_arr[] = array(
                "date" => $date,
                "name" => $name,
                "collected_by" => $collected_by,
                "payment" => $payment,
            );
        }
        return $data_arr;
    }

    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Member::where('name', 'LIKE', '%'. $query. '%')->get();
        return response()->json($filterResult);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function expenseReport(Request $request)
    {
//        dd($request->all());
        $expense_categories = ExpenseCategory::all();
        if ($request->ajax()) {

            $date = explode('-', $request->filter_date);
            $from = Carbon::parse($date[0])->format('Y-m-d');
            $to = Carbon::parse($date[1])->format('Y-m-d');

            $query = Expense::with('expenseCategory', 'expenseList')
                ->whereDate('date', '>=', $from)
                ->whereDate('date', '<=', $to)
                ->where('category_id', $request->filter_name)
                ->get();
//            dd($query);
            $records = $this->expenseReportData($query);
//                dd($records);
            return response()->json($records);

        } else {
            $query = Expense::with('expenseCategory', 'expenseList')
                ->whereDate('date', Carbon::now()->toDateString())
                ->get();
            $records = $this->expenseReportData($query);
            return view('backend.dashboard.expense-report', compact('expense_categories', 'records'));
        }
    }

    public function dailyExpenditure(Request $request)
    {
        $date = explode('-', $request->filter_date);
        $from = Carbon::parse($date[0])->format('Y-m-d');
        $to = Carbon::parse($date[1])->format('Y-m-d');
        $record = DB::table('expenses as exp')
            ->join('expense_lists as expenses', 'exp.id', '=', 'expenses.expense_id')
            ->select('exp.date as date', DB::raw('sum(expenses.amount) as amount'))
            ->whereDate('exp.date', '>=', $from)->whereDate('exp.date', '<=', $to)
            ->orderBy('exp.date', 'asc')
            ->groupBy('expenses.expense_id')
            ->get();
        return response()->json($record);
    }

    public function memberReport(Request $request)
    {
        if ($request->ajax()) {
            $date = explode('-', $request->filter_date);
            $from = Carbon::parse($date[0])->format('Y-m-d');
            $to = Carbon::parse($date[1])->format('Y-m-d');
            $active = Member::where('is_expired', 0)
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get();
            $expired = Member::where('is_expired', 1)
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get();
            $members = [
                'active' => count($active),
                'expired' => count($expired)
            ];
            return response()->json($members);
        } else {
            return view('backend.dashboard.member-report');
        }
    }

    public function membershipTypeReport(Request $request)
    {
        if ($request->ajax()) {
            $date = explode('-', $request->filter_date);
            $from = Carbon::parse($date[0])->format('Y-m-d');
            $to = Carbon::parse($date[1])->format('Y-m-d');
            $members = DB::table('members as member')
                ->join('memberships as membership', 'membership.id', '=', 'member.membership_id')
                ->select('membership.name', DB::raw('count(member.name) as total_members'))
                ->where('member.membership_id', '!=', null)
                ->whereDate('member.created_at', '>=', $from)->whereDate('member.created_at', '<=', $to)
                ->groupBy('member.membership_id')
                ->get();
            return response()->json($members);
        } else {
            return view('backend.dashboard.membership-types-report');
        }
    }

    public function expenseIncomeReport(Request $request)
    {
        if ($request->ajax()) {
            $date = explode('-', $request->filter_date);
            $from = Carbon::parse($date[0])->format('Y-m-d');
            $to = Carbon::parse($date[1])->format('Y-m-d');
            if ($request->filter_name == 'income') {
                $income = Fee::select('date as date',
                    DB::raw('sum(fees) as total_fees'),
                    DB::raw('sum(reg_fee) as total_reg_fees'),
                    DB::raw('sum(discount) as total_discount'),
                    DB::raw('sum(classes_fees) as total_classes_fees'),
                    DB::raw('sum(personal_training_fees) as total_personal_training_fees'),
                    DB::raw('sum(in_house_training_fees) as total_in_house_training_fees'))
                    ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)
                    ->groupBy('date')
                    ->orderBy('created_at', 'asc')
                    ->get();
                return response()->json($income);
            } else {
                $record = DB::table('expenses as exp')
                    ->join('expense_lists as expenses', 'exp.id', '=', 'expenses.expense_id')
                    ->select('exp.date as date', DB::raw('sum(expenses.amount) as amount'))
                    ->whereDate('exp.date', '>=', $from)->whereDate('exp.date', '<=', $to)
                    ->orderBy('exp.date', 'asc')
                    ->groupBy('expenses.expense_id')
                    ->get();
                return response()->json($record);
            }
        } else {
            return view('backend.dashboard.expense-income-report');
        }
    }

    public function hoursSpentReport(Request $request)
    {
        $date = explode('-', $request->filter_date);
        $from = Carbon::parse($date[0])->format('Y-m-d');
        $to = Carbon::parse($date[1])->format('Y-m-d');
        $records = DB::table('attendances as attend')
            ->join('members as member', 'member.id', '=', 'attend.member_id')
            ->select('member.name', 'attend.clock_in', 'attend.clock_out',
                DB::raw('DATE_FORMAT(attend.date, "%Y-%m-%d") as date'))
            ->where('member.id', $request->filter_member_id)
            ->where('attend.clock_in', '!=', null)
            ->whereDate('attend.date', '>=', $from)->whereDate('attend.date', '<=', $to)
//            ->where('member.guest_member','=', '1')
            ->get();
        $calculateTime = [];
        foreach ($records as $record) {
            $start_time = Carbon::parse($record->clock_in);
            $end_time = $record->clock_out != null ? Carbon::parse($record->clock_out) : '';
            $total_time = $record->clock_out != null ? $start_time->diff($end_time)->format('%H') : '02';
            $data = [
                'date' => $record->date,
                'time' => $total_time == '00' ? '01' : $total_time,
            ];
            array_push($calculateTime, $data);
        }
        return response()->json($calculateTime);
//        dd($calculateTime);
    }

    public function expenseReportData($records)
    {
        $data_arr = array();
        foreach ($records as $key => $record) {
            $data_arr[] = array(
                "date" => $record->created_at->toDateString(),
                "category" => $record->expenseCategory->name,
                "amount" => $record->expenseList,

            );
        }
        return $data_arr;
    }
}
