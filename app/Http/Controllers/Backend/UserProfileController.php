<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ConfirmPasswordRequest;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Userprofile\UpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(auth()->id());
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            if ($request->has('image')) {

                if ($user->image && file_exists('storage/profile_images/' . $user->image)) {
                    unlink('storage/profile_images/' . $user->image);
                }
                $image = $request->file('image');
                $ext = $image->extension();
                $imageName = rand(111111111, 999999999) . '.' . $ext;
                $path =  $image->storeAs('profile_images', $imageName,'public');
                $user->image = 'storage/'.$path;
            }
            $user->save();
            DB::commit();
            return response()->json([
                'message' => 'Updated Successfully',
                'user' => $user
            ], 200);
            //return response()->json(["message"=>"Updated Successfully"],200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(["message" => $exception->getMessage()], 500);
        }
    }

    public function resetPassword(ConfirmPasswordRequest $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Your current password is not Correct'], 422);
        } else {
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['message' => 'Password updated Successfuly'], 200);
        }

    }
}
