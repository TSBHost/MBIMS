<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // dd("asd");
       $customers = Customer::query();
       if ($request->has("search_text") && isset($request->search_text))
           $customers = $customers->where("name", "like", '%' . $request->search_text . '%');
       $customers = $customers->paginate(20);
       //dd($banks);
       return view('backend.customer.index', compact("customers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        // dd($request->all());
        $v = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );

        if ($v->passes()) {

            DB::transaction(function () use ($request) {
                $customer= Customer::create(
                    [
                        'name' => $request->name,
                        'contact_person' => $request->contact_person,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'description' => $request->description,
                        'is_active' => $request->is_active,
                        'creator' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.customer.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view("backend.customer.edit", compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        // dd($request->all());
        $v = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );

        if ($v->passes()) {

            DB::transaction(function () use ($request, $id) {


                $customer = Customer::where('id', '=', $id)->update(
                    [
                        'name' => $request->name,
                        'contact_person' => $request->contact_person,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'description' => $request->description,
                        'is_active' => $request->is_active,
                        'editor' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.customer.index')->with("success", "Updated Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::where('id', '=', $id)->delete();
        return 1;
    }
}
