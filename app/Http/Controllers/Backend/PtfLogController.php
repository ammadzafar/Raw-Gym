<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PtfLog;
use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\PtfLog\StoreRequest;
use Illuminate\Support\Facades\DB;

class PtfLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:update_member_ptf' , ['only'=>['index','show']]);
        $this->middleware('permission:update_member_fee',['only'=>['store','index']]);

    }
    public function index(Request $request ,$id)
    {

       $member = Member::whereId($id)->firstOrFail();
       $latestPtf = $member->ptfLogs()->exists()?$member->ptfLogs()->latest()->first()->personal_training_fees:0;
       return response()->json(['memberptf'=>$latestPtf]);

    }

    public function store(StoreRequest $request,$id)
    {

        $personal_training = $request['personal_training_fees']>0?1:0;
          try {
                DB::beginTransaction();
                $ptf = new PtfLog();
                $ptf->user_id = auth()->user()->id;
                $ptf->member_id = $id;
                $ptf->updated_by = auth()->user()->name;
                $ptf->personal_training_fees =$request['personal_training_fees'];
                $ptf->save();
                DB::commit();
              Member::whereId($id)->update(['personal_training'=>$personal_training,'personal_training_fees'=>$request['personal_training_fees']]);
              return response()->json(['message'=>'PTF updated successfully']);
            }catch (Exception $exception)
            {
                DB::rollBack();
                return  response()->json(['message'=>$exception->getMessage()]);
            }
        }




}
