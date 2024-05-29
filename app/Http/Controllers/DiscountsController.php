<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discounts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountsController extends Controller
{
    public function index()
    {
        $discount = Discounts::latest();

        if(!empty(request('search'))){
            $discount = $discount->where('code', 'like', '%'.request('search').'%')->orWhere('name', 'like', '%'.request('search').'%');
        }

        $discount = $discount->paginate(10);

        return view('dashboard.discounts.index', compact('discount'), [
            "create" => route('discounts.create'),
        ]);
    }

    public function create()
    {
        return view('dashboard.discounts.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'amount' => 'required|numeric',
            'is_active' => 'required|boolean',
            'start_date' => 'nullable|date_format:Y-m-d\TH:i',
            'end_date' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            if (!empty($request->start_date)) {
                $now = Carbon::now();
                $start = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);

                if ($start < $now) {
                    $validator->errors()->add('start_date', 'Start date cannot be in the past.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
                $end = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);

                if ($end < $start) {
                    $validator->errors()->add('end_date', 'End date cannot be before the start date.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            $validator->errors()->add('date_format', 'Invalid date format. Please use Y-m-d\TH:i.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->type == 'fixed'){
            if($request->amount < 0){
                $validator->errors()->add('amount', 'Amount cannot be negative.');
                return redirect()->back()->withErrors($validator)->withInput();
            } 
        }else if($request->type == 'percentage'){
            if($request->amount < 0 || $request->amount > 100){
                $validator->errors()->add('amount', 'Amount must be between 0 and 100.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if($request->max_use < 0){
            $validator->errors()->add('max_use', 'Maximum usage cannot be negative.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->max_user < 0){
            $validator->errors()->add('max_user', 'Maximum user cannot be negative.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->min_amount < 0){
            $validator->errors()->add('min_amount', 'Minimum amount cannot be negative.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $discount = new Discounts();
        $discount->code = $request->code;
        $discount->name = $request->name;
        $discount->max_use = $request->max_use;
        $discount->max_user = $request->max_user;
        $discount->type = $request->type;
        $discount->amount = $request->amount;
        $discount->min_amount = $request->min_amount;
        $discount->is_active = $request->is_active;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
        $discount = Discounts::find($id);
        return view('dashboard.discounts.edit', compact('discount'));
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'amount' => 'required|numeric',
            'is_active' => 'required|boolean',
            'start_date' => 'nullable|date_format:Y-m-d\TH:i',
            'end_date' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $start = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
            $end = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);

            if ($end < $start) {
                return redirect()->back()->with('error', 'End date cannot be before the start date.');
            }
        }

        if($request->type == 'fixed'){
            if($request->amount < 0){
                return redirect()->back()->with('error', 'Amount cannot be negative.');
            }
        }else if($request->type == 'percentage'){
            if($request->amount < 0 || $request->amount > 100){
                return redirect()->back()->with('error', 'Amount must be between 0 and 100.');
            }
        }

        if($request->max_use < 0){
            return redirect()->back()->with('error', 'Maximum usage cannot be negative.');
        }

        if($request->max_user < 0){
            return redirect()->back()->with('error', 'Maximum user cannot be negative.');
        }

        if($request->min_amount < 0){
            return redirect()->back()->with('error', 'Minimum amount cannot be negative.');
        }

        $discount = Discounts::find($id);
        $discount->code = $request->code;
        $discount->name = $request->name;
        $discount->max_use = $request->max_use;
        $discount->max_user = $request->max_user;
        $discount->type = $request->type;
        $discount->amount = $request->amount;
        $discount->min_amount = $request->min_amount;
        $discount->is_active = $request->is_active;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();

        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully!');
    }

    public function destroy($id)
    {
        //
        $data = Discounts::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Discount deleted successfully!');
    }
}
