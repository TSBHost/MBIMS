<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd("asd");
        $suppliers = Supplier::query();
        if ($request->has("search_text") && isset($request->search_text))
            $suppliers = $suppliers->where("name", "like", '%' . $request->search_text . '%');
        $suppliers = $suppliers->paginate(20);
        //dd($banks);
        return view('backend.supplier.index', compact("suppliers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.supplier.create');
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
                $supplier= Supplier::create(
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
            return redirect()->route('backend.supplier.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view("backend.supplier.edit", compact('supplier'));
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


                $supplier = Supplier::where('id', '=', $id)->update(
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
            return redirect()->route('backend.supplier.index')->with("success", "Updated Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::where('id', '=', $id)->delete();
        return 1;
    }
}
