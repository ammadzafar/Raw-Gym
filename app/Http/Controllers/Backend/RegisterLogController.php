<?php

namespace App\Http\Controllers\Backend;

use App\Models\Member;
use App\Models\RegisterLog;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\RegLog\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RegisterLogController extends Controller
{
    public function  __construct()
    {
        $this->middleware('permission:update_member_reg_date',['only'=>['index','store']]);
    }
    public function index(Request $request,$id)
    {
        $member = Member::whereId($id)->firstOrFail();
        $memberReg = $member->registerLogs()->exists()?$member->registerLogs()->latest()->first()->reg_date:"no";
      return response()->json(['memberReg'=>$memberReg]);
    }
    public function store(StoreRequest $request , $id)
    {
        try {
            DB::beginTransaction();
            $regLog = new RegisterLog();
            $regLog->user_id = auth()->id();
            $regLog->updated_by = auth()->user()->name;
            $regLog->member_id = $id;
            $regLog->reg_date =$request['reg_date'];
            $regLog->save();

            DB::commit();
            return response()->json(['message'=>'Updated sucessfully']);
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json(['message'=>$exception->getMessage()]);
        }

    }
}
