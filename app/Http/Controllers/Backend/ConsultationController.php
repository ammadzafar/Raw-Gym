<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ConsultationRequest;
use App\Jobs\SendEmailtoConsultantJob;
use App\Models\Consultant;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::all();
        return DataTables::of($consultations)
            ->addColumn('created', function ($consultation) {
                return $consultation->created_at->format('d F Y');
            })
            ->addColumn('name', function ($consultation) {
                return $consultation->consultant->name;
            })
            ->addColumn('mobile', function ($consultation) {
                return $consultation->consultant->mobile;
            })
            ->addColumn('subject', function ($consultation) {
                return $consultation->subject;
            })
            ->addColumn('action', function ($consultation) {
                return (auth()->user()->can('consultation_detail') ? '<a class="action-consultation-detail btn btn-link btn-sm text-primary" data-id="' . $consultation->id . '" href="consultation/detail/' . $consultation->id . '"><i class="fas fa-history"></i> More Info</a>' : '')
                    . (auth()->user()->can('consultation_delete') ? '<span class="action-consultation-delete btn btn-link btn-sm text-danger btn-sm" data-toggle="modal" data-target="#create-consultation-modal" id="consultation-conformation-delete" data-id="' . $consultation->id . '" data-name="' . $consultation->consultant->name . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'name', 'mobile', 'subject', 'action'])
            ->make(true);
    }

    public function store(ConsultationRequest $request)
    {

        DB::beginTransaction();
        try {
            $consultant = Consultant::where('email', $request->email)->first();
            if ($consultant) {
                $consultant->consultations()->create([
                    'subject' => $request->subject,
                    'message' => $request->message
                ]);
                $details = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message
                ];
                DB::commit();
                $this->dispatch(new SendEmailtoConsultantJob($details));


                return response()->json([
                    'message' => "Thanks for Consultiong us , We'll response shortily"
                ], 200);
            } else {
                $consultant = Consultant::create($request->all());
                $consultant->consultations()->create([
                    'subject' => $request->subject,
                    'message' => $request->message
                ]);
                $details = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message
                ];
                DB::commit();

                $this->dispatch(new SendEmailtoConsultantJob($details));

                return response()->json([
                    'message' => "Thanks for Consulting us , We'll response shortly"
                ], 200);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }


    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $consultation = Consultation::whereId($request->id)->firstOrFail();
            $consultation->delete();
            DB::commit();
            return response()->json(['message' => 'Deleted successfully'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function detail(Request $request)
    {
        $consultations = Consultation::where('id', $request->id)->get();
        $view = Consultation::where('id', $request->id)->first();
        $view->view = 1;
        $view->save();

        return view('backend.consultation.detail', ['consultations' => $consultations]);
    }

}
