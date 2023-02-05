<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserAttendance\StoreRequest;
use App\Models\UserAttendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user_attendance_list|user_attendance_mark', ['only' => ['index']]);
        $this->middleware('permission:user_attendance_mark', ['only' => ['status']]);
    }

    public function index(Request $request, $date = null)
    {
        //
    }

    public function approval(Request $request, $id)
    {
        $date = $request->date;
        $attendance = UserAttendance::whereId($id)->firstorFail();
        $leave_array = ['absent', 'leave'];
        if (in_array($attendance->status, $leave_array) && $attendance->admin_approval == false) {
            $attendance->user->total_leaves = $attendance->user->total_leaves - 1;
        }
        if (in_array($attendance->status, $leave_array) && $attendance->admin_approval == true) {
            $attendance->user->total_leaves = $attendance->user->total_leaves + 1;
        }

        $attendance->admin_approval = $attendance->admin_approval == false ? true : false;
        $attendance->user->save();

        $attendance->save();

        return response()->json([
            "message" => "Attendance successfully mark."
        ]);
    }

    public function status(Request $request, $id)
    {
        $status = $request->status;
        $attendance = UserAttendance::whereId($id)->firstOrFail();

        $leave_array = ['absent', 'leave'];

        if ($attendance->admin_approval) {
            if (in_array($attendance->status, $leave_array)) {
                if (!in_array($attendance->status, $leave_array)) {
                    $attendance->user->total_leaves = $attendance->user->total_leaves - 1;
                }
            } else {
                if (in_array($attendance->status, $leave_array)) {
                    $attendance->user->total_leaves = $attendance->user->total_leaves + 1;
                }
            }
            $attendance->user->save();
        }

        $attendance->status = $status;
        $attendance->save();

        return response()->json([
            "message" => "Status successfully updated."
        ]);
    }

    public function bulkapproval(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $date = Carbon::create($request->date);
            $userAttendances = UserAttendance::whereDay('shift_time', $date->day)->get();

            foreach ($userAttendances as $userAttendance) {
                $userAttendance->status = $request->status;
                $userAttendance->admin_approval = true;
                $userAttendance->label = $request->label;
                $userAttendance->save();
            }
            
            DB::commit();
            return response()->json([
                'message' => 'Attendance mark successfully'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}

