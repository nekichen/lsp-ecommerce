<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function index()
    {
        return view('landing.auth.profile');
    }

    public function update(Request $request)
    {
        // Validate the input
        $request->validate([
            'name',
            'email',
        ]);

        // Get the current authenticated user
        $user = User::where('email', Auth::user()->email)->first();

        // Update the user
        if ($request->name == '') {
            $user->name = $user->name;
            $user->email = $request->email;
        } elseif ($request->email == '') {
            $user->name = $request->name;
            $user->email = $user->email;
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
        }

        // Save the user
        $user->save();

        return back()->with('success', 'Your profile has been updated successfully.');
    }

    public function changePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
        ]);

        // Get the current authenticated user
        $user = User::where('email', Auth::user()->email)->first();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'The old password does not match our records.');
        } else {
            // Hash the new password
            $user->password = bcrypt($request->password);
            $user->save();

            return back()->with('success', 'Your password has been changed successfully.');
        }
    }

    public function destroy(Request $request)
    {
        // Get the current authenticated user
        $user = User::where('email', Auth::user()->email)->first();
        $user->delete();
        Auth::logout();
        return redirect()->route('home')->with('success', 'Your account has been deleted successfully.');
    }
}