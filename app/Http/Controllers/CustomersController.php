<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\User;
use App\Models\Countries;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customers::paginate(10);

        $users = User::all();
        $country = Countries::all();

        return view('dashboard.customers.index', compact('customers', 'users', 'country'), [
            'create' => route('customers.create'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
        $customers->delete();
    }
}
