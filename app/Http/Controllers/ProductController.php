<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->has("search_text") && isset($request->search_text))
            $products = $products->where("name", "like", '%' . $request->search_text . '%');
        $products = $products->paginate(20);
        //dd($banks);
        return view('backend.product.index', compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::where("is_active",'=',1)->get();
        $brands=Brand::where("is_active",'=',1)->get();
        $units=Unit::where("is_active",'=',1)->get();
        return view('backend.product.create', compact("categories", "brands", "units"));

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
                'category_id' => 'required',
                'brand_id' => 'required',
                'unit_id' => 'required',
            ]
        );

        if ($v->passes()) {
            $image_path = '';
            if ($request->hasfile('image')) {
                $image_path = mt_rand() . time() . " " . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('/images/product'), $image_path);
                $image_path = "/images/product/" . $image_path;
            }
            DB::transaction(function () use ($request, $image_path) {
                $product = Product::create(
                    [
                        'name' => $request->name,
                        'code' => $request->code,
                        'category_id' => $request->category_id,
                        'brand_id' => $request->brand_id,
                        'unit_id' => $request->unit_id,
                        'description' => $request->description,
                        'image' => $image_path,
                        'is_active' => $request->is_active,
                        'creator' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.product.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories=Category::where("is_active",'=',1)->get();
        $brands=Brand::where("is_active",'=',1)->get();
        $units=Unit::where("is_active",'=',1)->get();
        $product=Product::find($id);
        return view('backend.product.edit', compact("categories", "brands", "units","product"));
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
                'category_id' => 'required',
                'brand_id' => 'required',
                'unit_id' => 'required',
            ]
        );

        if ($v->passes()) {
            $product=Product::find($id);
            $image_path = $product->image;
            if ($request->hasfile('image')) {
                if ($product->image)
                    File::delete(public_path($product->image));
                $image_path = mt_rand() . time() . " " . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('/images/product'), $image_path);
                $image_path = "/images/product/" . $image_path;
            }
            DB::transaction(function () use ($request, $image_path,$id) {
                $product = Product::where('id','=',$id)->update(
                    [
                        'name' => $request->name,
                        'code' => $request->code,
                        'category_id' => $request->category_id,
                        'brand_id' => $request->brand_id,
                        'unit_id' => $request->unit_id,
                        'description' => $request->description,
                        'image' => $image_path,
                        'is_active' => $request->is_active,
                        'editor' => Auth::user()->id,
                    ]
                );
            });
            return redirect()->route('backend.product.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $image_path = $product->image;
        if ($product->delete())
            if ($product->image)
                File::delete(public_path($image_path));
        return 1;
    }
}
