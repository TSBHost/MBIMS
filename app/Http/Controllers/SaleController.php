<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\ProductSerialSale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sale::with("details", "customer");
        if ($request->has("customer_id") && isset($request->customer_id))
            $sales = $sales->where("customer_id", "=", $request->customer_id);

        if ($request->has("sale_date") && isset($request->sale_date))
            $sales = $sales->where("sale_date", "=", $request->sale_date);
        $sales = $sales->paginate(20);
        $customers = Customer::where('is_active', '=', 1)->get();
        //dd($sales);
        return view('backend.sale.index', compact("sales", "customers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $customers = Customer::where('is_active', '=', 1)->get();        
        $products = Product::where('is_active', '=', 1)->get();
        return view('backend.sale.create',compact("customers","products"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $v = Validator::make(
            $request->all(),
            [
                'sale_date' => 'required',
                'customer_id' => 'required',
            ]
        );

        if ($v->passes()) {

            DB::transaction(function () use ($request) {
                $sale = Sale::create(
                    [
                        "customer_id" => $request->customer_id,
                        "sale_date" => $request->sale_date,
                        "invoice_number" => $request->invoice_number,
                        "sale_code" => $request->sale_code,
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
                    $details = SaleDetails::create(
                        [
                            "sale_id" => $sale->id,
                            "product_id" => $request->product_id[$i],
                            "sale_price" => $request->sale_price[$i],
                            "quantity" => $request->quantity[$i],
                            "total_amount" => $request->total_amount[$i],
                            "creator" => Auth::user()->id,
                            "note" => $request->note[$i]
                        ]
                    );

                    $serials = $request->serials[$i];
                    if ($serials) {
                        $exp_serial = explode(",", $serials);
                        foreach ($exp_serial as $exps) {
                            ProductSerial::where('product_id','=',$request->product_id[$i])->where('serial_number','=',$exps)->update([
                                "is_sold"=>1,
                                "sale_id"=>$sale->id,
                                "sale_details_id"=>$details->id,
                                "editor" => Auth::user()->id,
                            ]);
                        }
                    }


                }
            });
            return redirect()->route('backend.sale.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $customers = Customer::where('is_active', '=', 1)->get();        
        $products = Product::where('is_active', '=', 1)->get();
        $sale=Sale::with('details','customer')->find($id);
        return view('backend.sale.edit',compact("customers","products","sale"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $v = Validator::make(
            $request->all(),
            [
                'sale_date' => 'required',
                'customer_id' => 'required',
            ]
        );

        if ($v->passes()) {

            ProductSerial::where("sale_id",'=',$id)->update(['is_sold'=>0,"sale_id"=>null,"sale_details_id"=>null]);
            DB::transaction(function () use ($request,$id) {
                $sale = Sale::where('id','=',$id)->update(
                    [
                        "customer_id" => $request->customer_id,
                        "sale_date" => $request->sale_date,
                        "invoice_number" => $request->invoice_number,
                        "sale_code" => $request->sale_code,
                        "total_amount" => $request->total,
                        "discount" => $request->discount,
                        "payable_amount" => $request->payable_amount,
                        "paid_amount" => $request->paid_amount,
                        "due_amount" => $request->due_amount,
                        "editor" => Auth::user()->id,
                        // "note" => $request->note,
                    ]
                );
                SaleDetails::where('sale_id','=',$id)->delete();
                for ($i = 0; $i < count($request->product_id); $i++) {
                    $details = SaleDetails::create(
                        [
                            "sale_id" => $id,
                            "product_id" => $request->product_id[$i],
                            "sale_price" => $request->sale_price[$i],
                            "quantity" => $request->quantity[$i],
                            "total_amount" => $request->total_amount[$i],
                            "creator" => Auth::user()->id,
                            "note" => $request->note[$i]
                        ]
                    );


                    // ProductSerial::where("sale_id",'=',$id)->update(['is_sold'=>0,"sale_id"=>null,"sale_details_id"=>null]);

                    $serials = $request->serials[$i];
                    if ($serials) {
                        $exp_serial = explode(",", $serials);
                        
                        foreach ($exp_serial as $exps) {
                            // var_dump(ProductSerial::where('product_id','=',$request->product_id[$i])->where('serial_number','=',$exps)->first());
                            ProductSerial::where('product_id','=',$request->product_id[$i])->where('serial_number','=',$exps)->update([
                                "is_sold"=>1,
                                "sale_id"=>$id,
                                "sale_details_id"=>$details->id,
                                "editor" => Auth::user()->id,
                            ]);
                        }
                    }


                }
                // dd("asdad");
            });
            return redirect()->route('backend.sale.index')->with("success", "Saved Successfully");
        } else
            return back()->withErrors($v)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function get_unsold_serials($product_id)
    {
        $serials=ProductSerial::where('product_id','=',$product_id)->where("is_sold",'=',0)->get();
        return $serials;
    }
}
