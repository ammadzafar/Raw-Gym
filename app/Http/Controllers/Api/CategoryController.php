<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::with('subCategories')->get();

        return response()->json([
            'status' => true,
            'categories' => $categories
        ], 200);
    }


    public function categoryWiseProducts()
    {
        $category_limit = \request()->get('category_limit') ?? 4;
        $products_limit = \request()->get('products_limit') ?? 4;

        $data = Category::whereNotNull('category_id')->with(['products' => function ($query) use ($products_limit) {
            $query->whereStatus(true)->latest()->limit($products_limit);
        }])->orderBy('position', 'asc')->limit($category_limit)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
