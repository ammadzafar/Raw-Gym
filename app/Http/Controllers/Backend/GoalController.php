<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:goal_list|goal_create|goal_edit|goal_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:goal_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:goal_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:goal_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = Goal::all();
        return DataTables::of($goals)
            ->addColumn('created', function ($goal) {
                return $goal->created_at->format('d F Y');
            })
            ->addColumn('image', function ($goal) {
                return '<div class="d-flex align-items-center">
                            <img src="' . ($goal->image && (\File::exists(public_path($goal->image))) ? asset($goal->image) : asset('images/image-placeholder.jpg')) . '" class="rounded-circle mr-2" width="40" height="40">
                        </div>';
            })
            ->addColumn('category', function ($goal) {
                return $goal->category->name;
            })
            ->addColumn('name', function ($goal) {
                return $goal->name;
            })
            ->addColumn('action', function ($goal) {
                return
                    (auth()->user()->can('goal_edit') ? '<span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $goal->id . '" data-target="#edit-goal-modal"><i class="far fa-edit"></i> Edit</span>' : '')
                    . (auth()->user()->can('goal_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $goal->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'image', 'category', 'name', 'action'])
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('image')) {
                $image_path = 'backend/goals';
                $image = $request->file('image');
                $image_name = time() . '-' . $image->getClientOriginalExtension();
                $path = $image->storeAs($image_path, $image_name, 'public');
                $request->image = '/storage/' . $path;
            }

            $goal = Goal::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'image' => $request->image,
            ]);

            DB::commit();

            return response()->json([
                'message' => $goal->name . " successfully created."
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $goal = Goal::findOrFail($id);

        return response()->json([
            'goal' => $goal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $goal = Goal::where('id', $id)->firstOrFail();
            $goal->update($request->all());

            if ($request->has('image')) {
                $image_path = 'backend/goals';
                $image = $request->file('image');
                $image_name = time() . '-' . $image->getClientOriginalExtension();
                $path = $image->storeAs($image_path, $image_name, 'public');
                $goal->image = '/storage/' . $path;
                $goal->save();
            }

            DB::commit();

            return response()->json([
                "message" => $goal->name . " successfully updated.",
            ]);
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $goal = Goal::whereId($id)->firstOrFail();
            $goal->delete();

            DB::commit();
            return response()->json([
                'message' => $goal->name . " successfully deleted."
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
