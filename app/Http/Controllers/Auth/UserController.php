<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    
    public function login()
    {
        return view('landing.auth.login');
    }

    public function register()
    {
        return view('landing.auth.register');
    }

    public function registerPost(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);
        
        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';
        $user = User::create($data);
        
        if ($user) {
            return redirect()->route('login')->with('success', 'User created successfully, please login');
        } else {
            return back()->with('error', 'Something went wrong. Please try again.');
        }

        return back()->with('error', 'Something went wrong');
    }

    public function authenticate(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($credentials->passes()) {
            if (Auth::attempt([
                'email' => $request->email, 
                'password' => $request->password],
                $request->get('remember'))) 
            {
                return back()->with('success', 'Welcome, ' . Auth::user()->name);
            } else {
                return redirect()->route('login')->with('error', 'Email or Password is incorrect');
            }
        } else {
            return redirect()->route('login')
                ->withErrors($credentials)
                ->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
