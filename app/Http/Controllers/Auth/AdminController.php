<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($credentials->passes()) {
            if (Auth::guard('admin')->attempt([
                'email' => $request->email, 
                'password' => $request->password], 
                $request->get('remember'))) 
            {
                $users = Auth::guard('admin')->user();

                if ($users->role !== 'admin') {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You do not have the permission');
                } else {
                    return redirect()->route('dashboard')->with('success', 'Login Successful');
                }
            } else {
                return redirect()->route('admin.login')->with('error', 'Email or Password is incorrect');
            };
        } else {
            return redirect()->route('admin.login')
                ->withErrors($credentials)
                ->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
