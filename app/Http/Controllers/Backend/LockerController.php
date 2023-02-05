<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Locker;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LockerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:locker_list|locker_create|locker_edit|locker_delete|locker_view|', ['only' => ['index', 'show']]);
        $this->middleware('permission:locker_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:locker_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:locker_delete', ['only' => ['destroy']]);
        $this->middleware('permission:locker_view', ['only' => ['show']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $locker = Locker::whereId($id)->with('member')->firstOrFail();
        $members = $locker->member;
        return response()->json([
            'locker' => $locker,
            'members' => $members
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $member = Member::find($request->member);
            $isSaved = false;
            if ($member) {
                Log::info('updated');
                $member->locker_id = $id;
                $isSaved = $member->save();
            }
            if ($request->member == 0) {
                $isSaved = Member::where(['locker_id'=> $id])
                    ->update(['locker_id'=>null]);
            }
            if ($isSaved) {
                return response(['success' > true, 'message' => "Updated successfully"]);
            } else {
                return response(['success' => false, 'message' => "Updated successfully"]);
            }

        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        try {
            DB::beginTransaction();
            $member = Member::where('locker_id',$request->id)->firstOrFail();
            $member->locker_id =null;
            $member->save();
            DB::commit();
            return response(['message'=>'Locker updated successfully'],200);

        }catch (\Exception $exception)
        {
            return response(['message'=>$exception->getMessage()],500);
        }
    }
}
