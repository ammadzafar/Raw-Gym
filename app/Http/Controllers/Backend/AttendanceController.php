<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Member;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attendance_list|attendance_mark', ['only' => ['index']]);
        $this->middleware('permission:attendance_mark', ['only' => ['status']]);
    }

    public function index(Request $request, $date)
    {
        $date = new Carbon($date);
        $period = Attendance::whereDate('date', $date)->get();

        return DataTables::of($period)
            ->addColumn('date', function ($day) {
                return $day->date->format('d F Y');
            })
            ->addColumn('name', function ($day) {
                return $day->member->name;
            })
            ->addColumn('status', function ($day) {
                //<a href="" class="btn btn-' . ($day->status == 'absent' ? 'danger' : 'success') . ' status" data-id="' . $day->id . '" >' . $day->status . '</a>' : ''
                return (auth()->user()->can('attendance_mark') ?'<div class="custom-control custom-switch d-inline-block" dir="ltr">
                                <input type="checkbox" class="custom-control-input toggle-status-attendance" id="member-togglstatus-' . $day->id . '" data-id="' . $day->id . '" ' . ($day->status == 'present' ? "checked" : "") . '>
                                <label class="custom-control-label" for="member-togglstatus-' . $day->id . '"></label>
                            </div>':'' );

            })
            ->rawColumns(['date', 'name', 'status'])
            ->make(true);
    }

    public function status(Request $request, $clock_out,$id)
    {
//        dd($request->all());
        $date = $request->date;
        // dd(Carbon::now()->toTimeString(),$clock_out);
        $attendance = Attendance::whereId($id)->firstorFail();
        // dd($request->all());

        $clock_out == 'true'  ? $attendance->clock_out = Carbon::now()->toTimeString() : $attendance->clock_in = Carbon::now()->toTimeString();

        $attendance->status = $attendance->status == 'absent' ? 'present' : 'absent';
        $attendance->save();

        $member = Member::whereId($attendance->member->id)->first();
//        dd($attendance);

        $attendancePresent = $member->attendances()->where('status', 'present')->count();
        $attendanceAbsent = $member->attendances()->where('status', 'absent')->count();

        $attendanceDonat = [$attendancePresent, $attendanceAbsent];

        return response()->json([
            "message" => "Attendance successfully mark.",
            "attendanceDonat" => $attendanceDonat,
        ]);
    }
}
