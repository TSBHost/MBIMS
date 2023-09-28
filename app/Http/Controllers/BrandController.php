<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::query();
        if ($request->has("search_text") && isset($request->search_text))
            $brands = $brands->where("name", "like", '%' . $request->search_text . '%');
        $brands = $brands->paginate(20);
        //dd($banks);
        return view('backend.brand.index', compact("brands"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brand.create');
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
                'name' => 'required'
            ]
        );

        if ($v->passes()) {
            $image_path = '';
            if ($request->hasfile('image')) {
                $image_path = mt_rand() . time() . " " . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('/images/brand'), $image_path);
                $image_path = "/images/brand/" . $image_path;
            }
            DB::transaction(function () use ($request, $image_path) {
                $brand = Brand::create(
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $image_path,
                        'is_active' => $request->is_active,
                        'creator' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.brand.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view("backend.brand.edit", compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        $v = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ]
        );

        if ($v->passes()) {
            $brand = Brand::find($id);
            $image_path = $brand->image;
            if ($request->hasfile('image')) {
                if ($brand->image)
                    File::delete(public_path($brand->image));
                $image_path = mt_rand() . time() . " " . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('/images/brand'), $image_path);
                $image_path = "/images/brand/" . $image_path;
            }
            DB::transaction(function () use ($id, $request, $image_path) {
                $brand = Brand::where("id", '=', $id)->update(
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $image_path,
                        'is_active' => $request->is_active,
                        'editor' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.brand.index')->with("success", "Updated Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        $image_path = $brand->image;
        if ($brand->delete())
            if ($brand->image)
                File::delete(public_path($image_path));
        return 1;
    }
}
