<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{

    public function index()
    {
        $memberships = Membership::whereFeatured(true)->get();
        return response()->json(['status'=>true,'memberships'=>$memberships],200);
    }
}
