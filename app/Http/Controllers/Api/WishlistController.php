<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function wishlist($customer_id)
    {
        $wislists = Wishlist::whereCustomerId($customer_id)->get();

        return response()->json([
            'status' => true,
            'wishlist' => $wislists,
        ], 200);
    }

    public function add(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:members,id'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        DB::beginTransaction();
        try {

            $wishlist = Wishlist::whereCustomerId($request->customer_id)->whereProductId($request->product_id)->first();
            if (!$wishlist) {
                Wishlist::create($request->all());
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Product successfully added to wishlist',
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:members,id'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        DB::beginTransaction();
        try {

            $wishlist = Wishlist::whereCustomerId($request->customer_id)->whereProductId($request->product_id)->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Product successfully removed from wishlist',
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
