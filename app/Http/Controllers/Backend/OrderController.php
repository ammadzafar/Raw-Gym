<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:order_list|order_create|order_edit|order_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:order_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return DataTables::of($orders)
            ->addColumn('created', function ($order) {
                return $order->created_at;
            })
            ->addColumn('customer', function ($order) {
                return $order->customer->name;
            })
            ->addColumn('address', function ($order) {
                return $order->address;
            })
            ->addColumn('status', function ($order) {
                $options = '';

                foreach (getPossibleEnumValues('orders', 'status') as $status) {
                    $options .= '<option value="' . $status . '"' . (($order->status === $status) ? 'selected' : '') . '>' . $status . '</option>';
                }

                return '<select class="form-control update-status" name="member" data-id="' . $order->id . '">' . $options . '</select>';
            })
            ->addColumn('action', function ($order) {
                return
                    '<a class="btn btn-link btn-sm text-info btn-sm" href="' . route('order.show', $order->id) . '"><i class="far fa-eye"></i> Show</a>'
                    . (auth()->user()->can('order_delete') ? '<span class="action-delete btn btn-link btn-sm text-danger btn-sm" data-id="' . $order->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'customer', 'address', 'status', 'action'])
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::whereId($id)->with('orderDetails')->firstOrFail();

//        foreach($order->orderDetails as $variant) {
//            dump($variant->pivot->total_amount);
//        }
//        dd();

        return view('backend.orders.view', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
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
            $order = Order::whereId($id)->firstOrFail();
            $order->delete();

            DB::commit();
            return response()->json([
                'message' => $order->name . " successfully deleted."
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function status($id, $status)
    {
        DB::beginTransaction();
        try {
            $order = Order::whereId($id)->firstOrFail();
            $order->status = $status;
            $order->save();

            DB::commit();
            return response()->json([
                'message' => 'Order status successfully updated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
