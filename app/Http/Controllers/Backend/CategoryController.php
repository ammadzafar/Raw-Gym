<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Category\StoreRequest;
use App\Http\Requests\Backend\Category\UpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category_list|category_create|category_edit|category_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:category_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::all();
        return DataTables::of($categories)
            ->addColumn('created', function ($category) {
                return $category->created_at->format('d F Y');
            })
            ->addColumn('parent', function ($category) {
                return $category->category()->exists() ? $category->category->name : '...';
            })
            ->addColumn('position', function ($category) {
                return '<span class="text-success">' . $category->position . '</span>';
            })
            ->addColumn('name', function ($category) {
                return $category->name;
            })
            ->addColumn('image', function ($category) {
                return '<div class="d-flex align-items-center">
                            <img src="' . ($category->image && (\File::exists(public_path($category->image))) ? asset($category->image) : asset('images/image-placeholder.jpg')) . '" class="rounded-circle mr-2" width="40" height="40">
                        </div>';
            })
            ->addColumn('action', function ($category) {
                return (auth()->user()->can('category_edit') ? '
                <span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $category->id . '" data-target="#edit-category-modal"><i class="far fa-edit"></i> Edit</span>
                 <div class="custom-control custom-switch d-inline-block" dir="ltr">
                    <input type="checkbox" class="custom-control-input toggle-status-category" id="category-togglstatus-' . $category->id . '" data-id="' . $category->id . '" ' . ($category->status ? "checked" : "") . '>
                    <label class="custom-control-label" for="category-togglstatus-' . $category->id . '"></label>
                </div>' : '')
                    . (auth()->user()->can('category_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $category->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'parent', 'position', 'name', 'image', 'action'])
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
            $request['slug'] = $request['slug'] ? Str::slug($request['slug']) : Str::slug($request['name']);
            if ($request->has('image')) {
                $image_path = 'backend/categories';
                $image = $request->file('image');
                $image_name = time() . '-' . $request['slug'] . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($image_path, $image_name, 'public');
                $request->image = '/storage/' . $path;
            }
            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'category_id' => $request->category_id,
                'status' => true,
                'image' => $request->image,
                'position' => $request->position ?? null,
            ]);
            DB::commit();
            return response()->json([
                'message' => $category->name . " successfully created."
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
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
        $category = Category::findOrFail($id);
        return response()->json([
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::whereId($id)->firstOrFail();

            $request['slug'] = $request['slug'] ? Str::slug($request['slug']) : Str::slug($request['name']);

            if ($request->has('image')) {

                if ($category->image) {
                    if (file_exists($category->image)) {
                        unlink($category->image);
                    }
                }

                $image_path = 'backend/categorys';
                $image = $request->file('image');
                $image_name = time() . '-' . $request['slug'] . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($image_path, $image_name, 'public');
                $request->image = '/storage/' . $path;

            } else {
                $request->image = $category->image;
            }

            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'category_id' => $request->category_id,
                'image' => $request->image,
                'position' => $request->position ?? null,
            ]);

            DB::commit();

            return response()->json([
                'message' => $category->name . " successfully updated."
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::whereId($id)->firstOrFail();
            $category->delete();
            DB::commit();
            return response()->json([
                'message' => $category->name . " successfully deleted."
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
            $category = Category::whereId($id)->firstOrFail();

            $category->status = $category->status ? false : true;
            $category->save();

            DB::commit();

            return response()->json([
                'message' => $category->status ? $category->name . ' successfully activated.' : $category->name . ' successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function change($id)
    {
        $category = Category::whereId($id)->with('subCategories')->firstOrFail();

        return response()->json([
            'category' => $category
        ], 200);
    }
}
