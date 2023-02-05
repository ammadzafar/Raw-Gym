<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\NewsletterStoreRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class NewsletterController extends Controller
{
    public function store(NewsletterStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $newsletter = Newsletter::create($request->all());
            DB::commit();
            return response()->json(['message' => 'Thanks for Subscribing'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => "You've already Subscribed"
            ], 500);
        }
    }

    public function index()
    {
        $newsletters = Newsletter::all();
        return DataTables::of($newsletters)
            ->addColumn('created', function ($newsletter) {
                return $newsletter->created_at->format('d F Y');
            })
            ->addColumn('email', function ($newsletter) {
                return $newsletter->email;
            })
            ->rawColumns(['created', 'name'])
            ->make(true);
    }
}
