<?php

namespace App\Http\Controllers\Backend;

use App\Models\Fee;
use App\Models\FeeLog;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\FeeLog\StoreRequest;
use App\Http\Controllers\Controller;
class FeeLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update_member_fee',['only'=>['store','index']]);
    }
    public function index(Request $request,$id)
    {
         $memberFee = 0;
         $member = Member::whereId($id)->firstOrFail();
       $memberLatestFee= $member->feeLogs()->exists() ? $member->feeLogs()->latest()->first()->fees : 0;
        return response()->json(['memberFee'=>$memberLatestFee]);
    }
    public function store(StoreRequest $request ,$id)
    {
        $member = Member::find($id);
        if ($member->membership){
            $member->membership->fees = $request->fees ;
            $member->push();
        }
        $feesLog = new FeeLog();
        $feesLog->user_id = auth()->id();
        $feesLog->member_id = $id;
        $feesLog->updated_by = auth()->user()->name;
        $feesLog->fees = $request->fees;
        $feesLog->save();
        Fee::where('member_id',$id)->update(['fees' => $request->fees]);
        Member::whereId($id)->update(['fee_structure' => $request->fees]);
        return response()->json(['message'=>'Fees updated successfully']);
    }
}
