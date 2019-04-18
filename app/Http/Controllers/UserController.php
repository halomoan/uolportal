<?php
/**
 * Created by PhpStorm.
 * User: K.halomoan
 * Date: 16/4/2019
 * Time: 1:54 PM
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('profile',compact('user',$user));
    }

    public function update_avatar(Request $request){

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('avatars',$avatarName);

        $user->userprofile->avatar = $avatarName;
        $user->userprofile->save();

        return back()
            ->with('success','You have successfully upload image.');

    }

}