<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\AttributeValue\StoreRequest;
use App\Http\Requests\Backend\AttributeValue\UpdateRequest;
use App\Models\Value;
use Yajra\DataTables\DataTables;

class AttributeValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:value_list|value_create|value_edit|value_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:value_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:value_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:value_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $values = Value::all();
        return DataTables::of($values)
            ->addColumn('created', function ($value) {
                return $value->created_at->format('d F Y');
            })
            ->addColumn('attribute', function ($value) {
                return $value->attribute->name;
            })
            ->addColumn('name', function ($value) {
                return $value->name;
            })
            ->addColumn('action', function ($value) {
                return (auth()->user()->can('value_edit') ? '
                <span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $value->id . '" data-target="#edit-value-modal"><i class="far fa-edit"></i> Edit</span>' : '')
                    . (auth()->user()->can('value_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $value->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'attribute', 'name', 'action'])
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
        DB::beginTransaction();
        try {
            $value = Value::create($request->all());
            DB::commit();

            return response()->json([
                'message' => $value->name . " successfully created."
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $value = Value::findOrFail($id);
        return response()->json([
            'value' => $value
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {
            $value = Value::whereId($id)->firstOrFail();
            $value->update($request->all());
            DB::commit();
            return response()->json([
                'message' => $value->name . " successfully updated."
            ], 201);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $value = Value::whereId($id)->firstOrFail();
            $value->delete();
            DB::commit();
            return response()->json([
                'message' => $value->name . " successfully Deleted."
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
