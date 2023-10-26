<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchases = Purchase::with("details", "supplier");
        if ($request->has("supplier_id") && isset($request->supplier_id))
            $purchases = $purchases->where("supplier_id", "=", $request->supplier_id);

        if ($request->has("purchase_date") && isset($request->purchase_date))
            $purchases = $purchases->where("purchase_date", "=", $request->purchase_date);
        $purchases = $purchases->paginate(20);
        $suppliers = Supplier::where('is_active', '=', 1)->get();
        //dd($banks);
        return view('backend.purchase.index', compact("purchases", "suppliers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('is_active', '=', 1)->get();
        $products = Product::where('is_active', '=', 1)->get();
        return view('backend.purchase.create', compact("suppliers", "products"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return back()->withInput();
        $v = Validator::make(
            $request->all(),
            [
                'purchase_date' => 'required',
                'supplier_id' => 'required',
            ]
        );

        if ($v->passes()) {

            DB::transaction(function () use ($request) {
                $purchase = Purchase::create(
                    [
                        "supplier_id" => $request->supplier_id,
                        "purchase_date" => $request->purchase_date,
                        "invoice_number" => $request->invoice_number,
                        "purchase_code" => $request->purchase_code,
                        "total_amount" => $request->total,
                        "discount" => $request->discount,
                        "payable_amount" => $request->payable_amount,
                        "paid_amount" => $request->paid_amount,
                        "due_amount" => $request->due_amount,
                        "creator" => Auth::user()->id,
                        // "note" => $request->note,
                    ]
                );

                for ($i = 0; $i < count($request->product_id); $i++) {
                    $details = PurchaseDetails::create(
                        [
                            "purchase_id" => $purchase->id,
                            "product_id" => $request->product_id[$i],
                            "purchase_price" => $request->purchase_price[$i],
                            "quantity" => $request->quantity[$i],
                            "total_amount" => $request->total_amount[$i],
                            "warranty_info" => $request->warranty_info[$i],
                            "creator" => Auth::user()->id,
                            "note" => $request->note[$i]
                        ]
                    );

                    $serials = $request->serials[$i];
                    if ($serials) {
                        $exp_serial = explode(",", $serials);
                        foreach ($exp_serial as $exps) {
                            ProductSerial::create([
                                "purchase_id" => $purchase->id,
                                "purchase_details_id" => $details->id,
                                "product_id" => $details->product_id,
                                "serial_number" => $exps,
                                "creator" => Auth::user()->id,
                            ]);
                        }
                    }


                }
            });
            return redirect()->route('backend.purchase.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suppliers = Supplier::where('is_active', '=', 1)->get();
        $products = Product::where('is_active', '=', 1)->get();
        $purchase=Purchase::where("id",'=', $id)->with("details")->first();
        return view('backend.purchase.edit', compact("suppliers", "products","purchase"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        // return back()->withInput();
        $v = Validator::make(
            $request->all(),
            [
                'purchase_date' => 'required',
                'supplier_id' => 'required',
            ]
        );

        if ($v->passes()) {

            DB::transaction(function () use ($request,$id) {
                $purchase = Purchase::where("id",'=',$id)->update(
                    [
                        "supplier_id" => $request->supplier_id,
                        "purchase_date" => $request->purchase_date,
                        "invoice_number" => $request->invoice_number,
                        "purchase_code" => $request->purchase_code,
                        "total_amount" => $request->total,
                        "discount" => $request->discount,
                        "payable_amount" => $request->payable_amount,
                        "paid_amount" => $request->paid_amount,
                        "due_amount" => $request->due_amount,
                        "creator" => Auth::user()->id,
                        // "note" => $request->note,
                    ]
                );
                PurchaseDetails::where("purchase_id",'=',$id)->delete();

                ProductSerial::where("purchase_id",'=',$id)->delete();
                for ($i = 0; $i < count($request->product_id); $i++) {
                    $details = PurchaseDetails::create(
                        [
                            "purchase_id" => $id,
                            "product_id" => $request->product_id[$i],
                            "purchase_price" => $request->purchase_price[$i],
                            "quantity" => $request->quantity[$i],
                            "total_amount" => $request->total_amount[$i],
                            "warranty_info" => $request->warranty_info[$i],
                            "creator" => Auth::user()->id,
                            "note" => $request->note[$i]
                        ]
                    );

                    $serials = $request->serials[$i];
                    if ($serials) {
                        $exp_serial = explode(",", $serials);
                        foreach ($exp_serial as $exps) {
                            ProductSerial::create([
                                "purchase_id" => $purchase->id,
                                "purchase_details_id" => $details->id,
                                "product_id" => $details->product_id,
                                "serial_number" => $exps,
                                "creator" => Auth::user()->id,
                            ]);
                        }
                    }


                }
            });
            return redirect()->route('backend.purchase.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}