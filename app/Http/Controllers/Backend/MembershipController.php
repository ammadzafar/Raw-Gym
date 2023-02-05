<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Membership\StoreRequest;
use App\Http\Requests\Backend\Membership\UpdateRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MembershipController extends Controller
{

    public function index()
    {
        //
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->reg_fee) {
                $request['reg_fee'] = 0;
            }
            $membership = Membership::create($request->all());
            DB::commit();
            return response()->json(["message" => " Created successfully"], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(["message" => $exception], 500);
        }
    }

    public function edit($id)
    {
        $membership = Membership::whereId($id)->firstOrFail();
        return response()->json(["membership" => $membership]);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $membership = Membership::whereId($id)->firstOrFail();

            $membership->update($request->except('_token'));
            DB::commit();
            return response()->json([
                'message' => $membership->name . ' successfully updated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $membership = Membership::whereId($id)->firstOrFail();
            $membership->delete();
            DB::commit();

            return response()->json([
                'message' => $membership->name . ' successfully deleted.'
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

            $membership = Membership::whereId($id)->firstOrFail();
            $membership->status = $membership->status ? false : true;
            $membership->save();
            DB::commit();
            return response()->json([
                'message' => $membership->status ? $membership->name . ' successfully activated' : $membership->name . ' successfully deactivated.'
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

            $membership = Membership::whereId($id)->firstOrFail();
            $membership->featured = $membership->featured ? false : true;
            $membership->save();
            DB::commit();
            return response()->json([
                'message' => $membership->featured ? $membership->name . ' successfully make Featured' : $membership->name . ' successfully UN Featured.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {

            $membership = Membership::onlyTrashed()->whereId($id)->firstOrFail();
            $membership->restore();

            DB::commit();
            return response()->json([
                'message' => 'Membership successfully restored.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function hardDelete($id)
    {
        DB::beginTransaction();
        try {

            $membership = Membership::withTrashed()->whereId($id)->firstOrFail();
            $membership->forceDelete();

            DB::commit();
            return response()->json([
                'message' => 'Membership permanently deleted.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
