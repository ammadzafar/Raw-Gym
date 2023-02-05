<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Tag\StoreTagRequest;
use App\Http\Requests\Backend\Tag\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tag_list|tag_create|tag_edit|tag_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:tag_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tag_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:tag_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return DataTables::of($tags)
            ->addColumn('created', function ($tag) {
                return $tag->created_at->format('d F Y');
            })
            ->addColumn('name', function ($tag) {
                return $tag->name;
            })
            ->addColumn('action', function ($tag) {
                return (auth()->user()->can('tag_edit') ? '
                <span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $tag->id . '" data-target="#edit-tag-modal"><i class="far fa-edit"></i> Edit</span>
                 <div class="custom-control custom-switch d-inline-block" dir="ltr">
                    <input type="checkbox" class="custom-control-input toggle-status-tag" id="tag-togglstatus-' . $tag->id . '" data-id="' . $tag->id . '" ' . ($tag->status ? "checked" : "") . '>
                    <label class="custom-control-label" for="tag-togglstatus-' . $tag->id . '"></label>
                </div>' : '')
                    . (auth()->user()->can('tag_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $tag->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
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
    public function store(StoreTagRequest $request)
    {
        DB::beginTransaction();
        try {
            $request['status'] = true;
            $tag = Tag::create($request->all());

            DB::commit();

            return response()->json([
                'message' => $tag->name . " successfully created."
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
        $tag = Tag::findOrFail($id);

        return response()->json([
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTagRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $tag = Tag::where('id', $id)->firstOrFail();
            $tag->update($request->all());

            DB::commit();

            return response()->json([
                "message" => $tag->name . " successfully updated.",
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
            $tag = Tag::whereId($id)->firstOrFail();
            $tag->delete();

            DB::commit();
            return response()->json([
                'message' => $tag->name . " successfully deleted."
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
            $tag = Tag::whereId($id)->firstOrFail();
            $tag->status = $tag->status ? false : true;
            $tag->save();

            DB::commit();
            return response()->json([
                'message' => $tag->status ? $tag->name . ' successfully activated.' : $tag->name . ' successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
