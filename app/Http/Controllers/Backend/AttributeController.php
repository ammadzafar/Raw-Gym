<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\Attribute\StoreRequest;
use App\Http\Requests\Backend\Attribute\UpdateRequest;
use Yajra\DataTables\DataTables;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attribute_list|attribute_create|attribute_edit|attribute_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:attribute_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:attribute_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:attribute_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
        $attributes = Attribute::all();
        return DataTables::of($attributes)
            ->addColumn('created', function ($attribute) {
                return $attribute->created_at->format('d F Y');
            })
            ->addColumn('name', function ($attribute) {
                return $attribute->name;
            })
            ->addColumn('action', function ($attribute) {
                return (auth()->user()->can('attribute_edit') ? '
                <span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $attribute->id . '" data-target="#edit-attribute-modal"><i class="far fa-edit"></i> Edit</span>
                 <div class="custom-control custom-switch d-inline-block" dir="ltr">
                    <input type="checkbox" class="custom-control-input toggle-status-attribute" id="attribute-togglstatus-' . $attribute->id . '" data-id="' . $attribute->id . '" ' . ($attribute->status ? "checked" : "") . '>
                    <label class="custom-control-label" for="attribute-togglstatus-' . $attribute->id . '"></label>
                </div>' : '')
                    . (auth()->user()->can('attribute_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $attribute->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'name', 'action'])
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
            $request['status'] = true;
            $attribute = Attribute::create($request->all());
            DB::commit();

            return response()->json([
                'message' => $attribute->name . " successfully created."
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
        //
        $attribute = Attribute::findOrFail($id);
        return response()->json([
            'attribute' => $attribute
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $attribute = Attribute::whereId($id)->firstOrFail();
            $attribute->update($request->all());
            DB::commit();
            return response()->json([
                'message' => $attribute->name . " successfully updated."
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
            $attribute = Attribute::whereId($id)->firstOrFail();
            $attribute->delete();
            DB::commit();
            return response()->json([
                'message' => $attribute->name . " successfully Deleted."
            ], 201);
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
            $attribute = Attribute::whereId($id)->firstOrFail();

            $attribute->status = $attribute->status ? false : true;
            $attribute->save();

            DB::commit();

            return response()->json([
                'message' => $attribute->status ? $attribute->name . ' successfully activated.' : $attribute->name . ' successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function getValuesByAttribute(Request $request)
    {
        $attributeIds = $request->data;

        $values = Value::whereIn('attribute_id', $attributeIds ?? [])->get()->groupBy('attribute_id')->toArray();

        $new_values = [];

        foreach ($values as $attrId => $value) {
            $attribute = Attribute::whereId($attrId)->first();
            $new_values[$attribute->name] = $value;
        }

        return response()->json([
            'values' => $new_values
        ], 200);
    }
}
