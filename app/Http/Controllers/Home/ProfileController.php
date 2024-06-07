<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Countries;
use App\Models\Customers;

class ProfileController extends Controller
{
    //
    public function index()
    {
        return view('landing.auth.profile');
    }

    public function updatePage()
    {
        return view('landing.auth.update-user');
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

        return redirect()->route('profile')->with('success', 'Your profile has been updated successfully.');
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

    public function addresses()
    {
        $countries = Countries::all();
        $customerId = Customers::where('user_id', Auth::user()->id);

        $customers = $customerId->first();
        $customer = $customerId->get();

        if($customers == null){
            return redirect()->route('add-address-page');
        } else {
            return view('landing.auth.customer.list', compact('customer'));
        }
    }

    public function addAddressPage()
    {
        $countries = Countries::all();
        return view('landing.auth.customer.add', compact('countries'));
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
        ]);

        $customer = new Customers();
        $customer->user_id = Auth::user()->id;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->country = $request->country;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->zip_code = $request->zip_code;
        $customer->save();

        return redirect()->route('addresses')->with('success', 'Your address has been saved successfully.');
    }
}