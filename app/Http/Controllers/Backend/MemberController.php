<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Member\MakePaymentRequest;
use App\Http\Requests\Backend\Member\StoreMemberRequest;
use App\Http\Requests\Backend\Member\UpdateMemberRequest;
use App\Jobs\SendPendingPaymentToEmailJob;
use App\Jobs\WelcomeEmailJob;
use App\Mail\WelcomeMail;
use App\Jobs\SendPaymentDetailsToEmailJob;
use App\Mail\PaymentMail;
use App\Models\Clas;
use App\Models\Fee;
use App\Models\FeeLog;
use App\Models\IhtfLog;
use App\Models\Member;
use App\Models\Membership;
use App\Models\PtfLog;
use App\Models\RegisterLog;
use App\Support\CustomPaginate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:member_list|member_expire_list|member_pending_fees_list|member_create|member_edit|member_delete|member_view|make_payment', ['only' => ['index', 'show']]);
        $this->middleware('permission:member_create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:member_edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:member_delete', ['only' => ['destroy']]);
        $this->middleware('permission:member_view', ['only' => ['show']]);

        $this->middleware('permission:make_payment', ['only' => ['makePayment', 'paymentHistory','edit', 'getPayment']]);

        $this->middleware('permission:trashed_members', ['only' => ['restore', 'hardDelete']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMemberRequest $request)
    {
        DB::beginTransaction();
        try {
            $request['created_by'] = auth()->id();
            if ($request->membership_id) {
                $membership = Membership::whereId($request->membership_id)->firstOrFail();
                $request['fee_structure'] = $membership->fees;
            }

            if ($request->personal_training) {
                $request['personal_training'] = true;
            } else {
                $request['personal_training'] = false;
                $request['personal_training_fees'] = 0;
            }

            if ($request->in_house_training) {
                $request['in_house_training'] = true;
            } else {
                $request['in_house_training'] = false;
                $request['in_house_training_fees'] = 0;
            }

            if (isset($request->guest_member)) {
                $request['guest_member'] = true;
            }
            $member = Member::create($request->except('image'));

            $member->roll_number = 'RAW-' . $member->id;
            $member->save();

            if (!$member->email) {
                $member->email = Str::slug($member->name, '') . $member->id . '.raw@gmail.com';
                $member->save();
            }
            if (!$member->phone) {
                $member->phone = '03'.rand(333,999).rand(0000000,999999);
                $member->save();
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $ext = $image->extension();
                $imageName = rand(111111111, 999999999) . '.' . $ext;
                $path = $image->storeAs('/member_images', $imageName, 'public');
                $member->image = '/storage/' . $path;
                $member->save();
            }
            if($request->fee_structure)
            {
                $feelog = new FeeLog();
                $feelog->user_id = auth()->id();
                $feelog->updated_by = auth()->user()->name;
                $feelog->member_id = $member->id;
                $feelog->fees = $request->fee_structure;
                $feelog->save();
            }
            if($request['reg_date'])
            {
                $regLog = new RegisterLog();
                $regLog->user_id = auth()->user()->id;
                $regLog->updated_by = auth()->user()->name;
                $regLog->member_id  = $member->id;
                $regLog->reg_fee   = $request['reg_fee'];
                $regLog->reg_date = $request['reg_date'];
                $regLog->save();
            }
            if ($request->personal_training) {
                $request['personal_training'] = true;
                $ptf = new PtfLog();
                $ptf->user_id = auth()->user()->id;
                $ptf->member_id = $member->id;
                $ptf->updated_by = auth()->user()->name;
                $ptf->personal_training_fees = $request['personal_training_fees'];
                $ptf->save();

            } else {
                $request['personal_training'] = false;
                $request['personal_training_fees'] = 0;
            }

            if ($request->in_house_training) {
                $request['in_house_training'] = true;
                $ptf = new IhtfLog();
                $ptf->user_id = auth()->user()->id;
                $ptf->member_id = $member->id;
                $ptf->updated_by = auth()->user()->name;
                $ptf->in_house_training_fees = $request['in_house_training_fees'];
                $ptf->save();

            } else {
                $request['in_house_training'] = false;
                $request['in_house_training_fees'] = 0;
            }

            // in case of classes
            /*if($request['classes'])
            {
                $member->classes()->attach($request['classes']);
            }*/


            DB::commit();
            $this->dispatch(new WelcomeEmailJob($member));

            return response()->json([
                'message' => $member->name . ' successfully created.'
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $member = Member::whereId($id)->with('fees.collectedBy', 'fees.membership', 'membership', 'attendances','createdBy' )->firstOrFail();

        $attendancePresent = $member->attendances()->where('status', 'present')->count();
        $attendanceAbsent = $member->attendances()->where('status', 'absent')->count();
        $memberRedDate = $member->registerLogs()->latest()->first()->reg_date;

        $attendanceDonat = [$attendancePresent, $attendanceAbsent];

        return view('backend.members.view', [
            'member' => $member,
            'attendanceDonat' => json_encode($attendanceDonat),
            'memberRedDate'=>$memberRedDate,
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
        $member = Member::whereId($id)->with('fees.collectedBy', 'fees.membership', 'membership')->firstOrFail();
        $paymentDate = null;
        $memberRegDate = $member->registerLogs()->latest()->first()->reg_date;

        if ($member->fees()->exists()
            && $member->fees()->whereYear('payment_date', Carbon::today()->year)->whereMonth('payment_date', Carbon::today()->month)->first()
            && $member->fees()->latest()->first()->status !== 'pending') {
            $paymentDate = Carbon::createFromFormat('d', $memberRegDate->format('d'))->addMonth();
        }
        if (!$member->membership){
            $memberLatestFee = $member->feeLogs()->exists() ? $member->feeLogs()->latest()->first()->fees : 0;
        }else {
            $memberLatestFee = $member->membership->fees;
        }
        $memberlatestPtf = $member->ptfLogs()->exists()?  $member->ptfLogs()->latest()->first()->personal_training_fees:0;

        $memberlatestIhtf = $member->inhtfLogs()->exists() ? $member->inhtfLogs()->latest()->first()->in_house_training_fees : 0;

        $classes = Clas::all();

          if ($member->classes()->exists())
          {

              foreach ($classes as $class)
              {
                  $class->is_active = false;

                  foreach ($member->classes as $abc)
                  {
                      if($class->id == $abc->id)
                      {
                          $class->is_active = true;
                      }
                  }

              }

          }

        return response()->json([
            'member' => $member,
            'paymentDate' => $paymentDate,
            'memberFee'=>$memberLatestFee,
            'memberRegDate'=>$memberRegDate,
            'memberPtf'=>$memberlatestPtf,
            'memberIhtf'=>$memberlatestIhtf,
            'memberRegFee'=>$member->reg_fee,
            'classes'=>$classes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $member = Member::whereId($id)->firstOrFail();

            if ($member->inhtfLogs){
                $inHouseTrainingFee = IhtfLog::where("member_id",$id)->first();
                if ($inHouseTrainingFee){
                    $inHouseTrainingFee->update(['in_house_training_fees' => $request->in_house_training_fees]);
                }else {
                    $ihtf = new IhtfLog();
                    $ihtf->user_id = auth()->user()->id;
                    $ihtf->member_id = $member->id;
                    $ihtf->updated_by = auth()->user()->name;
                    $ihtf->in_house_training_fees = $request['in_house_training_fees'];
                    $ihtf->save();
                }
            }

            if ($member->ptfLogs){
                $ptf = PtfLog::where("member_id",$id)->first();
                if ($ptf){
                    $ptf->update(['personal_training_fees' => $request->personal_training_fees]);
                }else {
                    $ptf = new PtfLog();
                    $ptf->user_id = auth()->user()->id;
                    $ptf->member_id = $member->id;
                    $ptf->updated_by = auth()->user()->name;
                    $ptf->personal_training_fees = $request['personal_training_fees'];
                    $ptf->save();
                }

            }


            $request['reg_date'];

            if ($request->membership_id) {
                $membership = Membership::whereId($request->membership_id)->firstOrFail();
                $request['fee_structure'] = $membership->fees;
                $request['guest_member'] = 0;
            }

            if ($request->personal_training) {
                $request['personal_training'] = true;
            } else {
                $request['personal_training'] = false;
                $request['personal_training_fees'] = 0;
            }

            if ($request->in_house_training) {
                $request['in_house_training'] = true;
            } else {
                $request['in_house_training'] = false;
                $request['in_house_training_fees'] = 0;
            }

           // dd($member->registerLogs()->latest()->first()->created_at);
          if($member->registerLogs()->latest()->first()->reg_date != Carbon::create($request['reg_date'])) {
              $memberRegDate = RegisterLog::where('member_id', $id)->latest()->first();
              $updatedByAdminId = auth()->user()->id;
              $updatedByAdminName = auth()->user()->name;
              if ($member->fees()->exists()) {
                  $newFeesExpiryDate = Carbon::create($request['reg_date'])->addMonth()->format('Y-m-d');
                  Fee::where('member_id', $id)->update(['expire_date' => $newFeesExpiryDate,'reg_date'=>$request['reg_date']]);
                  $memberRegDate->user_id = $updatedByAdminId;
                  $memberRegDate->updated_by = $updatedByAdminName;
                  $memberRegDate->reg_date = $request['reg_date'];
                  $memberRegDate->save();
              } else {
                  $memberRegDate->user_id = $updatedByAdminId;
                  $memberRegDate->updated_by = $updatedByAdminName;
                  $memberRegDate->reg_date = $request['reg_date'];
                  $memberRegDate->save();
              }
          }



            if ($request->membership_id != $member->membership_id) {
                if ($member->fees()->exists()) {

                    $last_fees = $member->fees()->latest()->first();

                    $payment_date = Carbon::create($last_fees->payment_date);
                    $expire_date = Carbon::create($last_fees->expire_date);
                    $now = Carbon::now();

                    if (!($now > $payment_date && $now > $expire_date)) {
                        return response()->json([
                            'message' => "Sorry you can't change Fee or Membership Package untill it expire "
                        ], 422);
                    }
                }
            }

            $member->update($request->except(['_token', 'image']));

            if ($request->hasFile('image')) {
                if ($member->image && file_exists('storage/profile_images/' . $member->image)) {
                    unlink('storage/profile_images/' . $member->image);
                }
                $image = $request->file('image');
                $ext = $image->extension();
                $imageName = rand(111111111, 999999999) . '.' . $ext;
                $path = $image->storeAs('/member_images', $imageName, 'public');
                $member->image = '/storage/' . $path;
                $member->save();
            }


            DB::commit();

            return response()->json([
                'message' => $member->name . ' successfully updated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
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
            $member = Member::whereId($id)->firstOrFail();
            $member->delete();

            DB::commit();

            return response()->json([
                'message' => $member->name . ' successfully deleted.'
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
            $member = Member::whereId($id)->firstOrFail();

            $member->status = $member->status ? false : true;
            $member->save();

            DB::commit();

            return response()->json([
                'message' => $member->status ? $member->name . ' successfully activated' : $member->name . ' successfully deactivated.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function makePayment(MakePaymentRequest $request, $id)
    {
        DB::beginTransaction();
        try {
//            dd($request->all());
            $request['total_payment'] = $request['total_payment'] + $request['personal_training_fees'] + $request['extra_charges'] ;
            $request['in_house_training_fees'] = (int)$request->in_house_training_fees;
            $member = Member::whereId($id)->firstOrFail();
            $memberRegDate = $member->registerLogs()->latest()->first()->reg_date;
            $discount = (int)$request['discount'];
            $request['reg_date'] = $memberRegDate;
            $registerDate = Carbon::create($memberRegDate)->day;

            if($member->guest_member == 1)
            {
                $request['expire_date'] = Carbon::create($request['payment_date']);
            }else
            {
//                dd($request->payment_month);
                $request['expire_date'] = Carbon::create($request->payment_month)->setDay($registerDate)->addMonth()->format('Y-m-d');
                if (Carbon::create($request->payment_date) < $memberRegDate) {
                    return response()->json([
                        'message' => 'Payment date cannot before the registration date.'
                    ], 422);
                }

                if ($request['payment_month']){
                    $monthNum  = (int)$request['payment_month'];
//                $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
                    $monthNum = $monthNum < 10 ? '0'.$monthNum : $monthNum;
                    $payment_month = Carbon::now()->format('Y').'-'.$monthNum.'-'.Carbon::now()->format('d');
                    $request['payment_month'] = $payment_month;
                }else {
                    $request['payment_month'] = $request->payment_date;
                }

                if ($member->fees()->exists()) {
                    if ($member->fees()->latest()->first()->status == 'pending') {
                        return response()->json([
                            'message' => 'Your have to pay pending fees first'
                        ], 422);
                    } else if ($member->fees()->whereYear('payment_month', Carbon::create($request->payment_month)->year)->whereMonth('payment_month', Carbon::create($request->payment_month)->month)->first()) {
                        return response()->json([
                            'message' => 'Fees already paid for this month'
                        ], 422);
                    }
                }
            }


           /* $registerDate = Carbon::create($memberRegDate)->day;
            $request['expire_date'] = Carbon::create($request->payment_date)->setDay($registerDate)->addMonth()->format('Y-m-d');
*/
            $request['reg_fee'] = 0;

            if (!$member->fees()->exists()) {
                if($request['total_payment'] <= $member->reg_fee)
                {
                    $request['reg_fee'] = $request['total_payment'];
                    $request['fees'] = 0;
                    $request['pending_personal_training_fees'] = $request['personal_training_fees'];
                    $request['personal_training_fees'] = 0;
                }
                else
                {
                    $request['reg_fee'] = $member->membership()->exists() ? $member->membership->reg_fee : $member->reg_fee;
                    $request['fees']= $request['total_payment']-$request['reg_fee']-$request['personal_training_fees'] - $request['extra_charges'] - $request['classes_fees'];
                }

            }
            if ($member->membership()->exists()) {
                $request['membership_id'] = $member->membership->id;
                $request['fees'] = $member->membership->fees;
                $request['reg_fee'] = $request->reg_fee;
                $request['pending_fees'] = 0;
                $request['classes_fees']=$request->classes_fees;
                $request['total_payment '] = $request['extra_charges'] +$request['classes_fees'] +$request['fees'];
                $request['status'] = (int)$request->pending_personal_training_fees ? 'pending' : 'paid';
                if ($member->membership->membership_type == "weekly"){
                    $request['expire_date'] = Carbon::create($request->payment_date)->addDays($member->membership->duration * 7)->format('Y-m-d');
                }
                else {
                    $request['expire_date'] = Carbon::create($request->payment_month)->addMonth($member->membership->duration)->format('Y-m-d');
                }
            } else {
                if ((int)$request->pending_fees || (int)$request->pending_personal_training_fees) {
                    $request['status'] = 'pending';
                } else {
                    $request['status'] = 'paid';
                }
            }

//            $request['total_payment'] = (int)$request['total_payment'] - $discount;
            $request['total_payment'] = ((int)$request['total_payment'] + $request['in_house_training_fees']) - $discount;

//            $request['notes'] = count($member->fees) ? $member->fees()->latest()->first()->status == 'pending' ? "Pay Your Pending Fee" : "Successful Payment" : "Successful Payment";
            $request['date'] = Carbon::now()->toDateString();
            $member->fees()->create($request->all());

            if ($member->fees()->latest()->first()->status == 'paid' || $member->fees()->latest()->first()->status == 'pending') {
                $member->is_expired = false;
                $member->save();
            }

            DB::commit();

            $details = [
                'member' => $member,
                'last_payment' => $member->fees()->latest()->first(),
            ];

            $this->dispatch(new SendPaymentDetailsToEmailJob($details));
            return response()->json([
                'message' => 'Fees successfully paid.',
                'details' => $details
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function paymentHistory($id)
    {

        $member = Member::whereId($id)->with('fees', 'membership')->firstOrFail();

        return response()->json([
            'member' => $member
        ]);
    }

    public function getPayment($id)
    {
        $fees = Fee::whereId($id)->with('member', 'collectedBy')->firstOrFail();

        return response()->json([
            'fees' => $fees
        ]);
    }

    public function getPending(Request $request, $id)
    {
        $this->validate($request, [
            'payment_method' => ['required', Rule::in(getPossibleEnumValues('fees', 'payment_method') ?? [])],
        ]);

        DB::beginTransaction();
        try {
            $fees = Fee::where('member_id', $id)->latest('id')->with('member', 'collectedBy')->first();
            $memberExpiree = $fees->expire_date;
            $pf = $fees->pending_fees;
            //$ptf = $fees->personal_training_fees;
            $pendingPtf = $fees->pending_personal_training_fees;
            $totalFees = $pf +$pendingPtf ;
            $today = \Illuminate\Support\Carbon::now();
            $pendingFee = new Fee();
            $pendingFee->member_id = $id;
            if($fees->reg_fee<$fees->member->reg_fee)
            {
                $pendingFee->reg_fee = $fees->member->reg_fee - $fees->reg_fee;
                $pendingFee->fees = $totalFees - $pendingFee->reg_fee;
                $pendingFee->total_payment = $totalFees;
            }else
            {
                $pendingFee->fees = $pf;
                $pendingFee->total_payment = $totalFees;
                $pendingFee->pending_personal_training_fees = $pendingPtf;
                $pendingFee->reg_fee = 0;
            }

            $pendingFee->pending_fees = 0;
            $pendingFee->personal_training_fees = $pendingPtf;
            $pendingFee->pending_personal_training_fees = 0;
            $pendingFee->payment_date = $today;
            $pendingFee->status = 'paid';
            $pendingFee->expire_date = $memberExpiree;
            $pendingFee->payment_method = $request->payment_method;
            $pendingFee->save();
            DB::commit();
            $member = Member::where('id', $id)->firstOrFail();

            $details = [
                'member' => $member,
                'paid_pending_fee' => $totalFees,
                'payment_method' => $request->payment_method,
                'payment_date' => $today,
                'fees' => $fees
            ];
            $this->dispatch(new SendPendingPaymentToEmailJob($details));
            return response(['message' => 'Payment proceed successfully'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {

            $member = Member::onlyTrashed()->whereId($id)->firstOrFail();
            $member->restore();

            DB::commit();
            return response()->json([
                'message' => 'Member successfully restored.'
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

            $member = Member::withTrashed()->whereId($id)->firstOrFail();
            $member->forceDelete();

            DB::commit();
            return response()->json([
                'message' => 'Member permanently deleted.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function classes( Request $request , $id)
    {
      $member = Member::whereId($id)->firstOrFail();
      $member->classes_fees = $request['classes_fees'];
        $member->classes()->attach($request['classes']);
        $member->save();
        return response()->json([
            'message' => 'Classes Assigned to Member.'.$member->name
        ], 200);

    }
    public function editClass($id)
    {
       $member = Member::whereId($id)->firstOrFail();
        $classes = Clas::all();

        if ($member->classes()->exists())
        {

            foreach ($classes as $class)
            {
                $class->is_active = false;

                foreach ($member->classes as $abc)
                {
                    if($class->id == $abc->id)
                    {
                        $class->is_active = true;
                    }
                }

            }

        }

        return response()->json([
            'member' => $member,
            'classes'=>$classes,
        ]);
    }

    public function updateClass(Request $request, $id)
    {
        $member = Member::whereId($id)->firstOrFail();
        $member->classes_fees = $request['classes_fees'];

        if($request['classes'])
        {
            $member->classes()->sync($request['classes']);
        }
        $member->save();
        return response()->json([
            'message' => 'Update Successfully'
        ], 200);
    }

    public function makeClassesPayment(Request $request , $id)
    {
          $member = Member::whereId($id)->firstOrFail();
      $fees = $member->fees()->latest()->first();
        $paymentDate = $request['payment_date'];
        $request['expire_date'] =$fees->expire_date??$paymentDate;
        $request['status'] =$fees->status??'paid';
        $request['total_payment'] = $request['classes_fees'] ;
        $request['status']         = 'paid';
        $member = Member::whereId($id)->firstOrFail();
        $memberRegDate = $member->registerLogs()->latest()->first()->reg_date;
        $request['reg_date'] = $memberRegDate;

        $member->fees()->create($request->all());
        return response(['message' => 'Payment proceed successfully'], 200);

    }

    public function deletePayment($id)
    {
        DB::beginTransaction();
        try {
            $member = Fee::whereId($id)->firstOrFail();
            $member->delete();

            DB::commit();

            return response()->json([
                'message' => 'payment successfully deleted.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
