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
use App\Models\Orders;

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
        // Retrieve all countries
        $countries = Countries::all();

        // Retrieve customer addresses for the authenticated user
        $customers = Customers::where('user_id', Auth::user()->id)->get();

        // If no customer address exists, redirect to add address page
        if($customers->isEmpty()){
            return redirect()->route('add-address-page');
        }

        // Pass both customers and countries to the view
        return view('landing.auth.customer.list', compact('customers', 'countries'));
    }

    public function addAddressPage()
    {
        $countries = Countries::all();
        return view('landing.auth.customer.add', compact('countries'));
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'country_id' => 'required|exists:countries,id',
            'state' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
        ]);

        $customer = new Customers();
        $customer->user_id = Auth::user()->id;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->country_id = $request->country_id;
        $customer->state = $request->state;
        $customer->address = $request->address;
        $customer->apartment = $request->apartment;
        $customer->city = $request->city;
        $customer->zip_code = $request->zip_code;
        $customer->save();

        return redirect()->route('customer-address')->with('success', 'Your address has been saved successfully.');
    }

    public function editAddressPage($id)
    {
        $customer = Customers::find($id);
        $countries = Countries::all();
        return view('landing.auth.customer.edit', compact('customer', 'countries'));
    }

    public function editAddress(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'country_id' => 'required|exists:countries,id',
            // 'state' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
        ]);

        $customer = Customers::find($id);
        $customer->user_id = Auth::user()->id;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->country_id = $request->country_id;
        // $customer->state = $request->state;
        $customer->address = $request->address;
        $customer->apartment = $request->apartment;
        $customer->city = $request->city;
        $customer->zip_code = $request->zip_code;
        $customer->save();

        return redirect()->route('customer-address')->with('success', 'Your address has been updated successfully.');
    }

    public function destroyAddress($id)
    {
        $customer = Customers::find($id);
        $customer->delete();
        return redirect()->route('customer-address')->with('success', 'Your address has been deleted successfully.');
    }

    public function activateAddress($id)
    {
        // Temukan alamat berdasarkan ID
        $address = Customers::find($id);

        // Periksa apakah alamat ditemukan
        if ($address) {
            // Nonaktifkan alamat lain yang saat ini aktif
            Customers::where('is_active', 1)->update(['is_active' => 0]);

            // Set status alamat menjadi aktif
            $address->is_active = true;
            $address->save();

            return redirect()->back()->with('success', 'Address activated successfully.');
        }

        // Redirect kembali jika alamat tidak ditemukan
        return redirect()->back()->with('error', 'Address not found.');
    }

    public function changePasswordPage()
    {
        return view('landing.auth.change-password');
    }

    public function orders()
    {
        $user = Auth::user();
        $customers = Customers::where('user_id', $user->id)->get();

        if ($customers->isEmpty()) {
            // Handle case where no customers are found
            return view('landing.auth.orders')->with('orders', collect());
        }

        // Get orders for the first customer (assuming customers are associated with orders)
        $orders = Orders::where('customer_id', $customers[0]->id)->get();
        return view('landing.auth.orders', compact('orders'));
    }
}