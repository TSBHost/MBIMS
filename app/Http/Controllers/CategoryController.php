<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd("asd");
        $categories = Category::query();
        if ($request->has("search_text") && isset($request->search_text))
            $categories = $categories->where("name", "like", '%' . $request->search_text . '%');
        $categories = $categories->paginate(20);
        //dd($banks);
        return view('backend.category.index', compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
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
                $category= Category::create(
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'is_active' => $request->is_active,
                        'creator' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.category.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view("backend.category.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request  $request, $id)
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


                $category = Category::where('id', '=', $id)->update(
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'is_active' => $request->is_active,
                        'editor' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.category.index')->with("success", "Updated Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::where('id', '=', $id)->delete();
        return 1;
    }
}
