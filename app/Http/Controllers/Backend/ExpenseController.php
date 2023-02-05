<?php

namespace App\Http\Controllers\Backend;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseList;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Expense\StoreRequest;
use App\Http\Requests\Backend\Expense\UpdateRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:expense_list|expense_create|expense_edit|expense_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:expense_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:expense_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:expense_delete', ['only' => ['destroy']]);
    }

    public function expenseByDays($date)
    {
        $statuses = getPossibleEnumValues('expense_lists', 'status');
        $categories = ExpenseCategory::all();
        return view('backend.expense.day-expense-report', [
            'date' => $date,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }

    public function index(Request $request)
    {
        $date = new Carbon($request->date);

        $expense = Expense::whereDate('date', $date)->first();

        return DataTables::of($expense ? $expense->expenseList : [])
            ->addColumn('created', function ($expense_list) {
                return $expense_list->expense->date->format('d M, Y');
            })
            ->addColumn('amount', function ($expense_list) {
                return $expense_list->amount;
            })
            ->addColumn('label', function ($expense_list) {
                return $expense_list->label;
            })
            ->addColumn('status', function ($expense_list) {
                return $expense_list->status;
            })
            ->addColumn('action', function ($expense_list) {
                return (auth()->user()->can('expense_list_edit') ? '<span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $expense_list->id . '" data-target="#Edit-expense-modal"><i class="far fa-edit"></i> Edit</span>' : '')
                    . (auth()->user()->can('expense_list_delete') ? '<span class="action-expense-delete btn btn-link btn-sm text-danger btn-sm" data-toggle="modal" data-target="#delete-expense-modal" id="expense-confirmation-delete" data-label="' . $expense_list->label . '" data-id="' . $expense_list->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'amount', 'label', 'status', 'action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
//        dd($request->all());
        DB::beginTransaction();
        try {
            $expense = new Expense();
            $expense->date = $request->date;
            $expense->category_id = $request->expense_category;
            $expense->save();

//            $expense = Expense::updateOrCreate([
//                'date' => $request->date,
//            ], [
//                'date' => $request->date,
//            ]);

            $expense->expenseList()->createMany($request->expenses);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => $exception->getMessage()
            ], 501);
        }
        return response()->json([
            'message' => 'Expense Successfully Created'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Expense $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $expense_list = ExpenseList::with('expense')->whereId($id)->firstOrFail();
        return response()->json([
            "expense_list" => $expense_list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $expense_list = ExpenseList::whereId($id)->firstOrFail();
            $expense_list->update($request->except('_token'));
            $expense_list->expense->update([
                'date' => $request->date,
                'status' => $request->status]);
            DB::commit();
            return response()->json([
                'message' => 'Expense successfully updated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $expense_list = ExpenseList::whereId($id)->firstOrFail();
            $expense_list->delete();
            $expense = Expense::whereId($expense_list->expense->id)->firstOrFail();
            if ($expense->expenseList->isEmpty()) {
                $expense->delete();
            }
            DB::commit();
            return response()->json([
                'message' => 'Expense successfully deleted.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

}
