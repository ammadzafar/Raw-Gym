<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $products = Product::with([
                'images:id,product_id,path',
                'brand:id,name,slug,image,description',
                'tags:id,name',
                'categories:id,category_id,name,slug,image',
                'variants.values'
            ])->get();

            return response()->json([
                'status' => true,
                'message' => 'Get products successfully',
                'products' => $products,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function getVariant($id)
    {
        $variant = Variant::whereId($id)->with('values')->firstOrFail();

        return response()->json([
            'status' => true,
            'variant' => $variant
        ], 200);
    }

    public function get($id)
    {
        $product = Product::whereId($id)->with([
            'images:id,product_id,path',
            'brand:id,name,slug,image,description',
            'tags:id,name',
            'categories:id,category_id,name,slug,image',
            'variants.values'
        ])->firstOrFail();

        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }

    public function search()
    {
        $pname = \request()->pname;
        $products = Product::where('name', 'LIKE', '%' . $pname . '%')->with([
            'images:id,product_id,path',
            'brand:id,name,slug,image,description',
            'tags:id,name',
            'categories:id,category_id,name,slug,image',
            'variants.values'
        ])->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ], 200);
    }

    public function searchBySubCategory($category_slug)
    {
        $category = Category::whereSlug($category_slug)->first();
        $products = $category->products()->with([
            'images:id,product_id,path',
            'brand:id,name,slug,image,description',
            'tags:id,name',
            'variants.values'
        ])->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ], 200);
    }

    public function searchByCategory($category_slug)
    {
        $subCategories = Category::whereSlug($category_slug)->first()->subCategories()->pluck('id')->toArray();
        $categoryProducts = CategoryProduct::whereIn('category_id', $subCategories)->pluck('product_id')->toArray();

        $products = Product::whereIn('id', $categoryProducts)->with([
            'images:id,product_id,path',
            'brand:id,name,slug,image,description',
            'tags:id,name',
            'variants.values'
        ])->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ], 200);
    }

    public function featured()
    {
        $limit = request()->get('limit') ?? 4;

        $product = Product::with([
            'images:id,product_id,path',
            'brand:id,name,slug,image,description',
            'tags:id,name',
            'categories:id,category_id,name,slug,image',
            'variants.values'
        ])->limit($limit)->get();

        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }

    public function top()
    {
        $limit = request()->get('limit') ?? 8;

        $product = Product::with([
            'images:id,product_id,path',
            'brand:id,name,slug,image,description',
            'tags:id,name',
            'categories:id,category_id,name,slug,image',
            'variants.values'
        ])->limit($limit)->get();

        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }
}
