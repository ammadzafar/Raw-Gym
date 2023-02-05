<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Brand\StoreBrandRequest;
use App\Http\Requests\Backend\Brand\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return DataTables::of($brands)
            ->addColumn('created', function ($brand) {
                return $brand->created_at->format('d F Y');
            })
            ->addColumn('name', function ($brand) {
                return '<div class="d-flex align-items-center">
                            <img src="' . ($brand->image && (\File::exists(public_path($brand->image))) ? asset($brand->image) : asset('images/image-placeholder.jpg')) . '" class="rounded-circle mr-2" width="40" height="40">
                            <span>' . $brand->name . '</span>
                        </div>';
            })
            ->addColumn('action', function ($brand) {
                return (auth()->user()->can('brand_edit') ? '
                <span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $brand->id . '" data-target="#edit-brand-modal"><i class="far fa-edit"></i> Edit</span>
                 <div class="custom-control custom-switch d-inline-block" dir="ltr">
                    <input type="checkbox" class="custom-control-input toggle-status-brand" id="brand-togglstatus-' . $brand->id . '" data-id="' . $brand->id . '" ' . ($brand->status ? "checked" : "") . '>
                    <label class="custom-control-label" for="brand-togglstatus-' . $brand->id . '"></label>
                </div>' : '')
                    . (auth()->user()->can('brand_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $brand->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
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
    public function store(StoreBrandRequest $request)
    {
        DB::beginTransaction();
        try {
            $request['slug'] = $request['slug'] ? Str::slug($request['slug']) : Str::slug($request['name']);

            if ($request->has('image')) {

                $image_path = 'backend/brands';
                $image = $request->file('image');
                $image_name = time() . '-' . $request['slug'] . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($image_path, $image_name, 'public');
                $request->image = '/storage/' . $path;
            }

            $brand = Brand::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $request->image,
                'status' => true,
                'description' => $request->description,
            ]);

            DB::commit();

            return response()->json([
                'message' => $brand->name . " successfully created."
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
        $brand = Brand::findOrFail($id);

        return response()->json([
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::whereId($id)->firstOrFail();

            $request['slug'] = $request['slug'] ? Str::slug($request['slug']) : Str::slug($request['name']);

            if ($request->has('image')) {

                if ($brand->image) {
                    if (file_exists($brand->image)) {
                        unlink($brand->image);
                    }
                }

                $image_path = 'backend/brands';
                $image = $request->file('image');
                $image_name = time() . '-' . $request['slug'] . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($image_path, $image_name, 'public');
                $request->image = '/storage/' . $path;

            }

            $brand->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $request->image,
                'description' => $request->description,
            ]);

            DB::commit();

            return response()->json([
                'message' => $brand->name . " successfully updated."
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
            $brand = Brand::whereId($id)->firstOrFail();
            $brand->delete();

            DB::commit();
            return response()->json([
                'message' => $brand->name . " successfully deleted."
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
            $brand = Brand::whereId($id)->firstOrFail();

            $brand->status = $brand->status ? false : true;
            $brand->save();

            DB::commit();

            return response()->json([
                'message' => $brand->status ? $brand->name . ' successfully activated.' : $brand->name . ' successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
