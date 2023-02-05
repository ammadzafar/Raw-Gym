<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Product\StoreRequest;
use App\Http\Requests\Backend\Product\UpdateRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product_list|product_create|product_edit|product_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product_edit', ['only' => ['edit', 'update', 'status', 'featured', 'top']]);
        $this->middleware('permission:product_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return DataTables::of($products)
            ->addColumn('created', function ($product) {
                return $product->created_at->format('d F Y');
            })
            ->addColumn('name', function ($product) {
                return $product->name;
            })
            ->addColumn('brand', function ($product) {
                return $product->brand->name;
            })
            ->addColumn('action', function ($product) {
                return
                    '<a class="btn btn-link btn-sm text-info" href="' . route('product.show', ['id' => $product->id]) . '"><i class="far fa-eye"></i> View</a>'
                    . (auth()->user()->can('product_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $product->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '')
                    . (auth()->user()->can('product_edit') ? '
                        <a class="btn btn-link btn-sm text-dark" href="' . route('product.edit', ['id' => $product->id]) . '"><i class="far fa-edit"></i> Edit</a>
                         <div class="custom-control custom-switch" dir="ltr">
                            <input type="checkbox" class="custom-control-input toggle-status-product" id="product-togglstatus-' . $product->id . '" data-id="' . $product->id . '" ' . ($product->status ? "checked" : "") . '>
                            <label class="custom-control-label text-success" for="product-togglstatus-' . $product->id . '">Status</label>
                         </div>
                         <div class="custom-control custom-switch" dir="ltr">
                            <input type="checkbox" class="custom-control-input toggle-featured-product" id="product-toggleFeatured-' . $product->id . '" data-id="' . $product->id . '" ' . ($product->is_featured ? "checked" : "") . '>
                            <label class="custom-control-label text-primary" for="product-toggleFeatured-' . $product->id . '">Featured</label>
                         </div>
                         <div class="custom-control custom-switch" dir="ltr">
                            <input type="checkbox" class="custom-control-input toggle-top-product" id="product-toggleTop-' . $product->id . '" data-id="' . $product->id . '" ' . ($product->is_top ? "checked" : "") . '>
                            <label class="custom-control-label text-warning" for="product-toggleTop-' . $product->id . '">Top</label>
                         </div>
                        ' : '');
            })
            ->rawColumns(['created', 'name', 'brand', 'action'])
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
            $product = Product::create($request->all());
            if ($request->images) {
                foreach ($request->images as $key => $image) {
                    $image_path = 'backend/product_images';
                    $image_name = time() . '-' . $product->slug . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs($image_path, $image_name, 'public');
                    $request->image = '/storage/' . $path;
                    Image::create([
                        'product_id' => $product->id,
                        'path' => $request->image
                    ]);
                }
            }

            $product->tags()->sync($request->tags);
            $product->categories()->sync($request->categories);

            foreach ($request->variants as $s_variant) {
                $variant = Variant::create([
                    'product_id' => $product['id'],
                    'price' => $s_variant['price'],
                    'sku' => $s_variant['sku'],
                    'stock' => $s_variant['stock'],
                    'status' => $s_variant['status'],
                ]);

                $variant->values()->attach($s_variant['values']);
            }

            DB::commit();

            return response()->json([
                'message' => "Product successfully created."
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::whereId($id)->firstOrFail();

        return view('backend.product.view', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::whereId($id)->firstOrFail();
        $tags = Tag::whereStatus(true)->get();
        $brands = Brand::whereStatus(true)->get();
        $categories = Category::whereStatus(true)->whereNull('category_id')->with('subCategories')->get();
        $attributes = Attribute::with('values')->get();
        $statuses = getPossibleEnumValues('variants', 'status');

        $temp_attr = $product->variants()->with('values')->get();
//        dd($product->variants->pluck('id')->toArray());
//        $selectedAttributes = DB::table('value_variant')->whereIn('variant_id', $product->variants->pluck('id')->toArray())->groupBy('value_id')->get();

        $selectedAttributes = [];
        foreach ($temp_attr as $attr) {
            foreach ($attr->values as $value) {
                array_push($selectedAttributes, $value->attribute->id);
            }
        }

        return view('backend.product.edit', [
            "product" => $product,
            'tags' => $tags,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'statuses' => $statuses,
            'selectedAttributes' => $selectedAttributes,
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
            $product = Product::whereId($id)->firstOrFail();
            $product->update($request->all());

            if ($request->images) {
                $product->images()->delete();
                foreach ($request->images as $image) {
                    $image_path = 'backend/product_images';
                    $image_name = time() . '-' . $product->slug . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs($image_path, $image_name, 'public');
                    $request->image = '/storage/' . $path;
                    Image::create([
                        'product_id' => $product->id,
                        'path' => $request->image
                    ]);
                }
            }

            $product->tags()->sync($request->tags);
            $product->categories()->sync($request->categories);

            $product->variants()->delete();
            foreach ($request->variants as $s_variant) {
                $variant = Variant::create([
                    'product_id' => $product['id'],
                    'price' => $s_variant['price'],
                    'sku' => $s_variant['sku'],
                    'stock' => $s_variant['stock'],
                    'status' => $s_variant['status'],
                ]);

                $variant->values()->attach($s_variant['values']);
            }

            DB::commit();

            return response()->json([
                'message' => "Product successfully updated."
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::whereId($id)->firstOrFail();
            $product->delete();

            DB::commit();
            return response()->json([
                'message' => "Product successfully deleted."
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
            $admin = Product::whereId($id)->firstOrFail();

            $admin->status = $admin->status ? false : true;
            $admin->save();

            DB::commit();

            return response()->json([
                'message' => $admin->status ? 'Product successfully activated' : 'Product successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function featured($id)
    {
        DB::beginTransaction();
        try {
            $admin = Product::whereId($id)->firstOrFail();

            $admin->is_featured = $admin->is_featured ? false : true;
            $admin->save();

            DB::commit();

            return response()->json([
                'message' => $admin->is_featured ? 'Product successfully added to featured' : 'Product successfully removed from featured.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function top($id)
    {
        DB::beginTransaction();
        try {
            $admin = Product::whereId($id)->firstOrFail();

            $admin->is_top = $admin->is_top ? false : true;
            $admin->save();

            DB::commit();

            return response()->json([
                'message' => $admin->is_top ? 'Product successfully added to top' : 'Product successfully removed from top.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
