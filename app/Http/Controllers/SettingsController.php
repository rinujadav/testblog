<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('content.page.settings.index', ['pageConfigs' => $pageConfigs]);
    }

    public function upload(Request $request) {
        $request->validate([
            'image'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current user
        $user = User::findOrFail(auth()->user()->id);

        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            $user->profile_photo_path = $request->image->store('avatars');
        }
        // Persist user record to database
        $user->update();

        // Return user back and show a flash message
        return redirect()->back()->with(['success' => 'Profile updated successfully.']);
    }

    public function user_general_update(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);
        
        // Get current user
        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;
        // Persist user record to database
        $user->update();

        // Return user back and show a flash message
        return redirect()->back()->with(['success' => 'Profile updated successfully.']);
    }

    public function user_password_update(Request $request) {
        $request->validate([
            'password' => ['required'],
            'new_password' => ['required'],
            'confirm_new_password' => ['same:new_password'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');

    }
}
