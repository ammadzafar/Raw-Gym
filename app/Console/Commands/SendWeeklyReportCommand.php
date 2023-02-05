<?php

namespace App\Console\Commands;

use App\Jobs\SendWeeklyReportJob;
use App\Models\ExpenseList;
use App\Models\Fee;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

class SendWeeklyReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:weekly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to send the weekly income/expense report to the selected users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $week_s = Carbon::now()->startOfWeek();
        $week_e = Carbon::now()->endOfWeek();

        $allIncome = Fee::whereBetween('payment_date', [$week_s, $week_e])->with('collectedBy', 'member')->get();
        $allIncomeTotal = $allIncome->sum(function ($q) {
            return $q->fees + $q->personal_training_fees;
        });

        $allExpenses = ExpenseList::whereStatus('paid')->whereHas('expense', function ($query) use ($week_s, $week_e) {
            $query->whereBetween('date', [$week_s, $week_e])->latest();
        })->get();
        $allExpenseTotal = $allExpenses->sum('amount');

        $income = [
            'all' => $allIncome,
            'total' => $allIncomeTotal,
        ];

        $expense = [
            'all' => $allExpenses,
            'total' => $allExpenseTotal,
        ];

        dispatch(new SendWeeklyReportJob($income, $expense));

        return 0;
    }
}
