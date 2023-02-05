<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Api\PlaceOrderRequest;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderVariant;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function place(PlaceOrderRequest $request)
    {
        DB::beginTransaction();
        try {

            $customer = Member::updateOrCreate([
                'email' => $request->email,
            ], [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => false,
                'is_member' => false,
            ]);

            $order = $customer->orders()->create([
                'order_at' => now(),
                'comment' => $request->comment,
                'address' => $request->address,
            ]);

            $variants = $request->variants;

            foreach ($variants as $obj) {

                $variant = Variant::whereId($obj['variant_id'])->firstOrFail();

                if ($variant->stock < (int)$obj['quantity']) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Not enough stock is available for variant: ' . $variant->id,
                    ], 422);
                }

                OrderVariant::create([
                    'variant_id' => $obj['variant_id'],
                    'order_id' => $order->id,
                    'quantity' => $obj['quantity'],
                    'unit_price' => $obj['unit_price'],
                    'total_amount' => $obj['total_amount'],
                ]);

                $variant->stock = $variant->stock - (int)$obj['quantity'];
                if ($variant->stock <= 0) {
                    $variant->status = 'out_of_stock';
                }
                $variant->save();
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Order successfully placed.',
                'data' => $order,
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
