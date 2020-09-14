<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function changePassword()
    {
        return view('admin.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_pass' => 'required|max:255',
            'new_pass'     => 'required|max:255',
            'confirm_pass' => 'required|max:255',
        ]);

        $current_pass = $request->input('current_pass');
        $new_pass     = $request->input('new_pass');

        $user_id = Auth::id();

        $user = User::find($user_id);

        if (!Hash::check($current_pass, $user->password)) {
            return redirect()->back()->with('error', 'Current password does not match !!');
        } else {
            $data['password'] = Hash::make($new_pass);

            User::find($user_id)->update($data);

            return redirect()->back()->with('success', 'Password updated successfully !!');
        }
    }

    public function profile()
    {
        $user = Auth::user();

        return view('admin.profile')->with(['user' => $user]);
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $id = $request->id;

        $user = request()->all();

        if ($request->hasFile('profile_pic')) {
            $image      = $request->file('profile_pic');
            $name       = time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/admin/uploads/users/');
            $image->move($uploadPath, $name);
            $user['profile_pic'] = $name;

            $oldImage    = User::find($id);
            $profile_pic = 'public/admin/uploads/users/' . $oldImage->profile_pic;
            File::delete($profile_pic);
        }

        user::find($id)->update($user);

        return redirect()->to('/admin/profile')->with('success', 'Profile updated successfully!');
    }
}
