<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Classes\StoreClassesRequest;
use App\Http\Requests\Backend\Classes\UpdateClassesRequest;
use App\Models\Clas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:classes_list|classes_create|classes_edit|classes_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:classes_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:classes_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:classes_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classess = Clas::all();
        return DataTables::of($classess)

            ->addColumn('name', function ($classes) {
                return $classes->name;
            })
            ->addColumn('Monday', function ($classes) {
                return $classes->Monday?'ON':'OFF';

            })
            ->addColumn('Tuesday', function ($classes) {
                return $classes->Tuesday?'ON':'OFF';

            })
            ->addColumn('Wednesday', function ($classes) {
                return $classes->Wednesday?'ON':'OFF';

            })
            ->addColumn('Thursday', function ($classes) {
                return $classes->Thursday?'ON':'OFF';

            })
            ->addColumn('Friday', function ($classes) {
                return $classes->Friday?'ON':'OFF';

            })
            ->addColumn('Saturday', function ($classes) {
                return $classes->Saturday?'ON':'OFF';

            })
            ->addColumn('Sunday', function ($classes) {
                return $classes->Sunday?'ON':'OFF';

            })

            ->addColumn('action', function ($classes) {
                return (auth()->user()->can('classes_edit') ? '
                <span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $classes->id . '" data-target="#edit-classes-modal"><i class="far fa-edit"></i> Edit</span>'
                  : '')
                    . (auth()->user()->can('classes_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $classes->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['name', 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday', 'action'])
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
    public function store(StoreClassesRequest $request)
    {
     //   dd($request->all());
        DB::beginTransaction();
        try {
            $request['status'] = true;
            $classes = Clas::create($request->all());

            DB::commit();

            return response()->json([
                'message' => $classes->name . " successfully created."
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
        $classes = Clas::findOrFail($id);

        return response()->json([
            'classes' => $classes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClassesRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $classes = Clas::where('id', $id)->firstOrFail();
            $classes->Monday = false;
            $classes->Tuesday = false;
            $classes->Wednesday = false;
            $classes->Thursday = false;
            $classes->Friday = false;
            $classes->Saturday = false;
            $classes->save();
            $classes->update($request->all());

            DB::commit();

            return response()->json([
                "message" => $classes->name . " successfully updated.",
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
            $classes = Clas::whereId($id)->firstOrFail();
            $classes->delete();

            DB::commit();
            return response()->json([
                'message' => $classes->name . " successfully deleted."
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function status($id)
    {
        DB::beginTransaction();
        try {
            $classes = Clas::whereId($id)->firstOrFail();
            $classes->status = $classes->status ? false : true;
            $classes->save();

            DB::commit();
            return response()->json([
                'message' => $classes->status ? $classes->name . ' successfully activated.' : $classes->name . ' successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
